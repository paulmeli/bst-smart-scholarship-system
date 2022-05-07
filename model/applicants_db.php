<?php
require_once('model/iterator/classes.php');

function mark_eligibility($student_number, $first_name, $last_name, $phone_number, $email_address, $gender, $dob, $status, $cumulative_gpa, $semester_gpa, $credit_hours, $eligibleCheck) {
  global $db;
  if (insert_exists($student_number)) {
    return 'Submission failed. Applicant already exists.';
  }
  else {
    $query = 'INSERT INTO APPLICANTS
                (studentNumber, firstName, lastName, phoneNumber, email, gender,
                dateOfBirth, status, cumulativeGPA, semesterGPA, credits, eligible)
              VALUES
                (:student_number, :first_name, :last_name, :phone_number, :email_address,
                :gender, :dob, :status, :cumulative_gpa, :semester_gpa, :credit_hours, :eligibleCheck)';
    $statement = $db->prepare($query);
    $statement->bindValue(':student_number', $student_number);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':phone_number', $phone_number);
    $statement->bindValue(':email_address', $email_address);
    $statement->bindValue(':gender', $gender);
    $statement->bindValue(':dob', $dob);
    $statement->bindValue(':status', $status);
    $statement->bindValue(':cumulative_gpa', $cumulative_gpa);
    $statement->bindValue(':semester_gpa', $semester_gpa);
    $statement->bindValue(':credit_hours', $credit_hours);
    $statement->bindValue(':eligibleCheck', $eligibleCheck);
    $statement->execute();
    $statement->closeCursor();
    return 'Submission successful!';
  }
}

function insert_exists($student_number) {
  global $db;
  $query = 'SELECT *
            FROM APPLICANTS X
            WHERE X.studentNumber = :student_number';
  $statement = $db->prepare($query);
  $statement->bindValue(':student_number', $student_number);
  $statement->execute();
  $exists = $statement->fetch();
  $statement->closeCursor();
  return $exists;
}

function get_eligible($eligible) {
  global $db;
  $query = 'SELECT *
            FROM APPLICANTS X
            WHERE X.eligible = :eligible';
  $statement = $db->prepare($query);
  $statement->bindValue(':eligible', $eligible);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();

  if ($results) {
    $eligible_apps = new EligibleStudentAggregate();
    foreach ($results as $result) :
      $eligible_apps->addStudent($result);
    endforeach;

    return $eligible_apps;
  }
  else {
    return false;
  }

}

function get_noneligible($noneligible) {
  global $db;
  $query = 'SELECT *
            FROM APPLICANTS X
            WHERE X.eligible = :noneligible';
  $statement = $db->prepare($query);
  $statement->bindValue(':noneligible', $noneligible);
  $statement->execute();
  $results = $statement->fetchAll();
  $statement->closeCursor();

  if ($results) {
    $noneligible_apps = new NoneligibleStudentAggregate();
    foreach ($results as $result) :
      $noneligible_apps->addStudent($result);
    endforeach;

    return $noneligible_apps;
  }
  else {
    return false;
  }

}

function update_votes($student_number_vote) {
  global $db;
  $query = 'UPDATE APPLICANTS X
            SET votes = votes + 1
            WHERE X.studentNumber = :student_number_vote';
  $statement = $db->prepare($query);
  $statement->bindValue(':student_number_vote', $student_number_vote);
  $statement->execute();
  $statement->closeCursor();
}

function get_awardee() {
  global $db;
  $query = 'SELECT *, (COUNT(*) OVER()) AS count
            FROM APPLICANTS X
            INNER JOIN
              (SELECT MAX(cumulativeGPA) AS cumulativeGPA
               FROM APPLICANTS Y
               WHERE Y.eligible = TRUE) Y
            ON X.cumulativeGPA = Y.cumulativeGPA
            WHERE X.eligible = TRUE';
  $statement = $db->prepare($query);
  $statement->execute();
  $awardee = $statement->fetchAll();
  $statement->closeCursor();
  // echo $awardee[0]['count'];

  if ($awardee[0]['count'] > 1) {
    $query = 'SELECT *, (COUNT(*) OVER()) AS count
              FROM APPLICANTS X
              INNER JOIN
                (SELECT MAX(cumulativeGPA) AS cumulativeGPA, MAX(semesterGPA) AS semesterGPA
                 FROM APPLICANTS Y
                 WHERE Y.eligible = TRUE) Y
              ON X.cumulativeGPA = Y.cumulativeGPA AND X.semesterGPA = Y.semesterGPA
              WHERE X.eligible = TRUE';
    $statement = $db->prepare($query);
    $statement->execute();
    $awardee = $statement->fetchAll();
    $statement->closeCursor();
    // echo $awardee[0]['count'];

    if ($awardee[0]['count'] > 1) {
      $query = 'SELECT *, (COUNT(*) OVER()) AS count
                FROM APPLICANTS X
                INNER JOIN
                  (SELECT MAX(cumulativeGPA) AS cumulativeGPA, MAX(semesterGPA) AS semesterGPA
                   FROM APPLICANTS Y
                   WHERE Y.eligible = TRUE) Y
                ON X.cumulativeGPA = Y.cumulativeGPA AND X.semesterGPA = Y.semesterGPA
                WHERE X.eligible = TRUE AND X.status = "Junior"';
      $statement = $db->prepare($query);
      $statement->execute();
      $awardee = $statement->fetchAll();
      $statement->closeCursor();
      // echo $awardee[0]['count'];

      if ($awardee[0]['count'] > 1 || $awardee[0]['count'] == 0) {
        $query = 'SELECT *, (COUNT(*) OVER()) AS count
                  FROM APPLICANTS X
                  INNER JOIN
                    (SELECT MAX(cumulativeGPA) AS cumulativeGPA, MAX(semesterGPA) AS semesterGPA
                     FROM APPLICANTS Y
                     WHERE Y.eligible = TRUE) Y
                  ON X.cumulativeGPA = Y.cumulativeGPA AND X.semesterGPA = Y.semesterGPA
                  WHERE X.eligible = TRUE AND X.status = "Junior" AND X.gender = "Female"';
        $statement = $db->prepare($query);
        $statement->execute();
        $awardee = $statement->fetchAll();
        $statement->closeCursor();
        // echo $awardee[0]['count'];

        if ($awardee[0]['count'] > 1 || $awardee[0]['count'] == 0) {
          $query = 'SELECT MAX(dateOfBirth) AS dateOfBirth
                    FROM APPLICANTS X
                    INNER JOIN
                      (SELECT MAX(cumulativeGPA) AS cumulativeGPA, MAX(semesterGPA) AS semesterGPA
                       FROM APPLICANTS Y
                       WHERE Y.eligible = TRUE) Y
                    ON X.cumulativeGPA = Y.cumulativeGPA AND X.semesterGPA = Y.semesterGPA
                    WHERE X.eligible = TRUE AND X.status = "Junior" AND X.gender = "Female"';
          $statement = $db->prepare($query);
          $statement->execute();
          $dateOfBirth = $statement->fetch();
          $statement->closeCursor();
          // echo $dateOfBirth['dateOfBirth'];
          $query = 'SELECT *, (COUNT(*) OVER()) AS count
                    FROM APPLICANTS X
                    INNER JOIN
                      (SELECT MAX(cumulativeGPA) AS cumulativeGPA, MAX(semesterGPA) AS semesterGPA
                       FROM APPLICANTS Y
                       WHERE Y.eligible = TRUE) Y
                    ON X.cumulativeGPA = Y.cumulativeGPA AND X.semesterGPA = Y.semesterGPA
                    WHERE X.eligible = TRUE AND X.status = "Junior" AND X.gender = "Female" AND X.dateOfBirth = :dateOfBirth';
          $statement = $db->prepare($query);
          $statement->bindValue(':dateOfBirth', $dateOfBirth['dateOfBirth']);
          $statement->execute();
          $awardee = $statement->fetchAll();
          $statement->closeCursor();
          // echo $awardee[0]['count'];
        }
      }
    }
  }

  if ($awardee) {
    $awardee_result = new AwardeeStudentAggregate();
    foreach ($awardee as $result) :
      $awardee_result->addStudent($result);
    endforeach;

    return $awardee_result;
  }
  else {
    return false;
  }

}
?>
