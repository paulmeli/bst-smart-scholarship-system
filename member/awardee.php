<?php include 'view/header.php';
      if (!isset($message2)) {$message2 = '';}
?>
<main id='home_content'>
  <?php include 'member/member_menu.php' ?>
  <section id='member_section'>
    <h2>Awardee</h2>
    <p>Below is listed the awardee of the B. S. T. Smart Scholarship
      based on the awarding decision-making process. If more than one applicant
      is listed, then these students must be interviewed by the
      committee. Each committee member can elect one student using the 'Awardee
      election' page.</p>
    <p>When the single awardee is decided, click the 'Send Email'
    button to send a congratulation email to the awardee. (The awardee will also be stored in the data store.)</p>
    <form action="controller.php" method="post">
      <input type="hidden" name="action" value="add_awardee">
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
          <th>Votes</th>
        </tr>
        <?php if ($awardee != FALSE) { ?>
          <?php while ($awardee_iterator->hasNext()) { 
              $app = $awardee_iterator->next();  
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
              <td><?php echo $app['votes']; ?></td>
            </tr>
          <?php } ?>
        <?php } ?>
      </table><br>
      <?php if (!empty($message2)) { ?>
        <span id='message'><?php echo htmlspecialchars($message2); ?></span>
      <?php } ?>
      <?php if ($awardee != FALSE) { ?>
        <input style='float: right;' type='submit' value='Send email'>
      <?php } ?>
    </form>
  </section>
</main>
<?php include 'view/footer.php'; ?>
