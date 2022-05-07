<?php include 'view/header.php'; ?>
<main id='home_content'>
  <?php include 'member/member_menu.php' ?>
  <section id='member_section'>
    <h2>Request bill</h2>
    <p>Select the 'Request' button, to retrieve the bill amount paid by the awardee at
      the beginning of the semester from the Registrar Office. The awardee information
      will display once a single awardee has been stored.</p>
    <div id='request_form'>
      <label><b>Awardee:</b></label>
      <?php if ($finalAwardee == '') { ?>
        <span></span>
      <?php } else { ?>
        <span id='awardee'><?php echo $finalAwardee['firstName'].' '.$finalAwardee['lastName'].' (Student Number: '.$finalAwardee['studentNumber'].')'; ?></span>
      <?php } ?>
      <br><br>
      <label><b>Bill:</b></label>
      <input type='text' id='bill'>
      <br><br><br>
      <?php if ($finalAwardee == '') { ?>
        <input type='submit' value='Request'>
      <?php } else { ?>
        <input type='submit' value='Request' onclick="requestBill()">
      <?php } ?>
    </div>
  </section>
</main>
<?php include 'view/footer.php'; ?>
