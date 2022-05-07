<?php include 'view/header.php';
      if (!isset($message)) {$message = '';}
?>
<main id='home_content'>
  <?php include 'member/member_menu.php' ?>
  <section id='member_section'>
    <h2>Reimburse awardee</h2>
    <p>Select the 'Request' button, to request the Accounting Department
      to reimburse the awardee. The awardee and reimbursement information
      will display after visiting the 'Request bill' page.</p>
    <form action='controller.php' method='post' id='request_form'>
      <input type="hidden" name="action" value="add_reimburse">
      <label><b>Awardee:</b></label>
      <?php if ($finalAwardee == '') { ?>
        <span></span>
      <?php } else { ?>
        <span id='awardee'><?php echo $finalAwardee['firstName'].' '.$finalAwardee['lastName'].' (Student Number: '.$finalAwardee['studentNumber'].')'; ?></span>
      <?php } ?>
      <br><br>
      <label><b>Reimbursement:</b></label>
      <?php if ($bill == '') { ?>
        <span></span><br><br><br>
        <input type='button' value='Request' id='reimburse'>
      <?php } else { ?>
        <span><?php echo "$$bill"; ?></span><br><br><br>
        <input type='submit' value='Request' id='reimburse'>
      <?php } ?>
      <?php if (!empty($message)) { ?>
        <span style='float: right;' id='message'><?php echo htmlspecialchars($message); ?></span>
      <?php } ?>
    </form>
  </section>
</main>
<?php include 'view/footer.php'; ?>
