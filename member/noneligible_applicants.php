<?php include 'view/header.php'; ?>
<main id='home_content'>
  <?php include 'member/member_menu.php' ?>
  <section id='member_section'>
    <h2>Noneligible applicants</h2>
    <p>Below are the applicants that do not meet the 'Requirements' listed on the home page and are not eligible to receive the B. S. T. Smart Scholarship.
      Click on the 'Send emails' button to send emails to them regarding their ineligibility.</p>
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
        <?php if ($noneligible_apps != false) { ?>
          <?php while ($noneligible_apps_iterator->hasNext()) { 
              $app = $noneligible_apps_iterator->next();  
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
      <?php if ($noneligible_apps != FALSE) { ?>
        <span id='message'></span><input style='float: right;' type='submit' value='Send emails' onclick="sendEmails()">
      <?php } ?>
  </section>
</main>
<?php include 'view/footer.php'; ?>
