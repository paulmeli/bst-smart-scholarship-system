<?php
// Required access to database (tables) to perform query/update funtion calls
  require('model/database.php');
  require('model/registrar_office_db.php');
  require('model/applicants_db.php');
  require('model/awarded_db.php');
  require('model/accounting_department_db.php');

  try {
    // Retrieve action submitted from web page
    // If none, default is to show home page
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == NULL) {
          $action = 'show_home'; // Default show home page
        }
    }

    if ($action == 'show_home') {
      include('view/home.php');
    }
    else if ($action == 'show_application') {
      include('applicant/application.php');
    }
    else if ($action == 'add_application') {
      // Retrieve applicant form inputs from web page
      $student_number = filter_input(INPUT_POST, 'student_number', FILTER_VALIDATE_INT);
      $first_name = filter_input(INPUT_POST, 'first_name');
      $last_name = filter_input(INPUT_POST, 'last_name');
      $phone_number = filter_input(INPUT_POST, 'phone_number');
      $email_address = filter_input(INPUT_POST, 'email_address', FILTER_VALIDATE_EMAIL);
      $gender = filter_input(INPUT_POST, 'gender');
      $dob = filter_input(INPUT_POST, 'dob');
      $status = filter_input(INPUT_POST, 'status');
      $cumulative_gpa = filter_input(INPUT_POST, 'cumulative_gpa', FILTER_VALIDATE_FLOAT);
      $credit_hours = filter_input(INPUT_POST, 'credit_hours', FILTER_VALIDATE_INT);

      // Check that data was entered in all fields and that data type is correct
      if ($student_number == NULL || $student_number == FALSE || $first_name == NULL || $last_name == NULL ||
      $phone_number == NULL || $email_address == NULL || $email_address == FALSE ||
      $gender == NULL || $dob == NULL || $status == NULL ||
      $cumulative_gpa == NULL || $cumulative_gpa == FALSE || $credit_hours == NULL || $credit_hours == FALSE) {
        // If input invalid, display error on application page
        $message = 'Submission failed. Data in one or more fields is invalid.';
        include('applicant/application.php');
      }
      else { // Check with registrar office that student application info is correct
        $dob_format = date('Y-m-d', strtotime(str_replace('/', '-', $dob))); // Check DOB format to SQL DATE format
        $valid_student_info = check_registrar($student_number); // Function call to interact with external entity Registrar Office
        if ($valid_student_info == FALSE || $status != $valid_student_info['status'] || number_format($cumulative_gpa, 2) != $valid_student_info['cumulativeGPA']
        || $credit_hours != $valid_student_info['credits'] || $dob_format != $valid_student_info['dateOfBirth']) {
          // If info not correct, display error on application page
          $message = 'Submission failed. Student does not exist or data is incorrect for existing student. If error persists, check with the Registrar Office.';
          include('applicant/application.php');
        }
        else { // If all application data is valid and correct, then check eligibility requirements
          $age = intval(substr(date('Ymd') - date('Ymd', strtotime($dob_format)), 0, -4));
          if ($cumulative_gpa < 3.2 || $credit_hours < 12 || 23 < $age) {$eligibleCheck = FALSE;} // Applicant is ineligible
          else {$eligibleCheck = TRUE;} // Applicant is eligible
          // Save applicant information and eligibility in data store
          $message = mark_eligibility($student_number, $first_name, $last_name, $phone_number, $email_address, $gender, $dob, $status, $cumulative_gpa, $valid_student_info['semesterGPA'], $credit_hours, $eligibleCheck);
          include('applicant/application.php');
        } // end of inner else
      } // end of outer else
    } // end of else if 'add_application'
    else if ($action == 'show_members_home') { // Members home page for 'Members Only' link
      include('member/members_home.php');
    }
    else if ($action == 'show_eligible') { 
      // Show eligible applicants. Retrieved from data store
      $eligible = TRUE;
      $eligible_apps = get_eligible($eligible);
      if ($eligible_apps != false) {
        $eligible_apps_iterator = $eligible_apps->createIterator();
      }
    
      include('member/eligible_applicants.php');
    }
    else if ($action == 'show_noneligible') { 
      // Show noneligible applicants. Retrieved from data store
      $noneligible = FALSE; // Applicant not eligible
      $noneligible_apps = get_noneligible($noneligible);
      if ($noneligible_apps != false) {
        $noneligible_apps_iterator = $noneligible_apps->createIterator();
      }

      include('member/noneligible_applicants.php');
    }
    else if ($action == 'show_awardee') {
      $awardee = get_awardee(); 
      // Filter eligible applicants to find awardee based on decision-making criteria
      if ($awardee != false) {
        $awardee_iterator = $awardee->createIterator();
      }

      include('member/awardee.php');
    }
    else if ($action == 'show_election') {
      $student_number_vote = filter_input(INPUT_POST, 'vote'); // Retrieve student voted for
      $awardeeVote = get_awardee();  // Get awardee option(s) to display as election candidate(s)
      if ($student_number_vote != NULL) { // Store committee member votes
        update_votes($student_number_vote);
        $messageElect = 'Vote submitted!';
      }
      if ($awardeeVote != false) {
        $awardee_vote_iterator = $awardeeVote->createIterator();
      }
      include('member/awardee_election.php');
    }
    else if ($action == 'add_awardee') {
      $awardee = get_awardee();
      if ($awardee != false) {
        $awardee_iterator = $awardee->createIterator();
      }

      // Add the single awardee or the one with more votes in the data store
      $max_vote = 0;
      while ($awardee_iterator->hasNext()) {
        $app = $awardee_iterator->next();
        if ($app['count'] == 1) {
          $message2 = add_awardee($app);
          $max_vote = -1;
          break;
        }
        else if ($app['votes'] > $max_vote) {
          $max_vote = $app['votes'];
          $max_app = $app;
        }

      }

      if (isset($max_app)) {
        $message2 = add_awardee($max_app);
      }
      else if ($max_vote == 0) {
        $message2 = "Error: Please vote for an awardee before sending emails";
      }

      if ($awardee != false) {
        $awardee_iterator = $awardee->createIterator();
      }
      include('member/awardee.php');
    }
    else if ($action == 'show_bill') { // Request XML of awardee bill from registrar office
      $finalAwardee = get_final_awardee();
      if ($finalAwardee == FALSE) { // Final awardee was not decided yet, so display nothing
        $finalAwardee = '';
      }
      else {
        $bill = ask_bill($finalAwardee); // Request to registrar office
        add_bill($finalAwardee['studentNumber'], $bill); // Store bill in data store
      }
      include('member/request_bill.php');
    }
    else if ($action == 'show_reimburse') {
      $finalAwardee = get_final_awardee();
      if ($finalAwardee == FALSE) { // Final awardee was not decided yet, so display nothing
        $finalAwardee = '';
        $bill = '';
      }
      else {
        $bill = ask_bill($finalAwardee);
      }
      include('member/reimburse_awardee.php');
    }
    else if ($action == 'add_reimburse') {
      $finalAwardee = get_final_awardee();
      $bill = ask_bill($finalAwardee);
      // Request reimbursement to awardee from Accounting Department external entity
      $message = request_reimburse($finalAwardee['studentNumber'], $bill);
      include('member/reimburse_awardee.php');
    }
  } // end of try
  catch (PDOException $e) {
    include('errors/error.php');
    exit();
  }

?>
