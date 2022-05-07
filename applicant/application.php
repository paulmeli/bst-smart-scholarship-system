<?php include 'view/header.php';
      if (!isset($message)) {$message = '';}
?>
<main>
  <form id="form" class='center' action='controller.php' method='post'>
    <input type='hidden' name='action' value='add_application'>
    <h2 style='padding-left:5%;'>B. S. T. Smart Scholarship Application</h2>
    <p style='padding-left:5%;'>Fill out the application fields below and click the 'Submit' button when finished.</p>
    <table id='app_table'>
      <tr><td><label class="aligned">Student Number:</label><br>
      <input type="text" name="student_number" id="student_number"
            placeholder="e.g., 12345678" class="text_box"
            pattern='[0-9]{8}' title='8-digit student number'
            required></td></tr>
      <tr><td><label class="aligned">First Name:</label><br>
      <input type="text" name="first_name" id="first_name"
            placeholder="e.g., John" class="text_box" required></td>
      <td><label class="aligned">Last Name:</label><br>
      <input type="text" name="last_name" id="last_name"
            placeholder="e.g., Doe" class="text_box" required></td></tr>
      <tr><td><label class="aligned">Phone Number:</label><br>
      <input type="tel" name="phone_number" id="phone_number"
            placeholder="e.g., 123-456-7890"
            pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}'
            class="text_box" required></td>
      <td><label class="aligned">Email Address:</label><br>
      <input type="email" name="email_address" id="email_address"
            placeholder="e.g., email@bst.com" class="text_box" required></td></tr>
      <tr><td><label class="aligned">Gender:</label><br>
      <select name="gender" id="gender" class="text_box" required>
        <option value=''></option>
        <option value='Male'>Male</option>
        <option value='Female'>Female</option>
      </select></td>
      <td><label class="aligned">Date of Birth:</label><br>
      <input type="date" name="dob" id="dob"
            placeholder="e.g., 1/1/1999" class="text_box" required></td></tr>
      <tr><td><label class="aligned">Status:</label><br>
      <select name="status" id="status" placeholder="e.g., Freshman" class="text_box" required>
        <option value=''></option>
        <option value='Freshman'>Freshman</option>
        <option value='Sophomore'>Sophomore</option>
        <option value='Junior'>Junior</option>
        <option value='Senior'>Senior</option>
      </select></td>
      <td><label class="aligned">Cumulative GPA:</label><br>
      <input type="text" name="cumulative_gpa" id="cumulative_gpa"
            placeholder="e.g., 4.00" class="text_box" title='A GPA from 0-4 followed by two decimal places'
            pattern='[0-4]{1}.[0-9]{1}[0-9]{1}' required></tr></td>
      <tr><td><label class="aligned">Number of Credit Hours (Current Semester):</label><br>
      <input type="number" name="credit_hours" id="credit_hours"
            placeholder="e.g., 14" class="text_box"
            min='0' max='18' step='1' required></td></tr>
      <tr><td>
        </td><td><input type='submit' value='Submit' id='app_submit_btn'></td>
      </tr>
    </table>
    <?php if (!empty($message)) { ?>
      <span style="display:block;width:90%;margin: 1% 5%;" id='message'><?php echo htmlspecialchars($message); ?></span>
    <?php } ?>
  </form>
</main>
<?php include 'view/footer.php'; ?>
