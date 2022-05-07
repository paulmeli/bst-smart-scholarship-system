<?php include 'view/header.php'; ?>
<main id='home_content'>
  <?php include 'member/member_menu.php' ?>
  <section id='member_section'>
    <h2>Eligible applicants</h2>
    <p>Below are the applicants that meet the 'Requirements' listed on the
      home page and are eligible to receive the B. S. T. Smart Scholarship.
      Click the 'Send emails' button to send emails to them after the awardee is selected.
      (The awardee listed will be excluded from this set of emails.)</p>
    <table class='member_table'>
      <tr>
        <th>Student Number</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Email Address</th>
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Status</th>
        <th>Cumulative GPA</th>
        <th>Credit Hours</th>
      </tr>
      <?php if ($eligible_apps != false) { ?>
        <?php while ($eligible_apps_iterator->hasNext()) { 
              $app = $eligible_apps_iterator->next(); 
        ?>
          <tr>
            <td><?php echo $app['studentNumber']; ?></td>
            <td><?php echo $app['firstName']; ?></td>
            <td><?php echo $app['lastName']; ?></td>
            <td><?php echo $app['phoneNumber']; ?></td>
            <td><?php echo $app['email']; ?></td>
            <td><?php echo $app['gender']; ?></td>
            <td><?php echo $app['dateOfBirth']; ?></td>
            <td><?php echo $app['status']; ?></td>
            <td><?php echo $app['cumulativeGPA']; ?></td>
            <td><?php echo $app['credits']; ?></td>
          </tr>
        <?php } ?>
      <?php } ?>
    </table><br>
    <span id='message'></span><input style='float: right;' type='submit' value='Send emails' onclick="sendEmails()">
  </section>
</main>
<?php include 'view/footer.php'; ?>
