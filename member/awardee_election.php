<?php include 'view/header.php';
  if (!isset($messageElect)) { $messageElect = ''; }
?>
<main id='home_content'>
  <?php include 'member/member_menu.php' ?>
  <section id='member_section'>
    <h2>Awardee election</h2>
    <p>Select one of the potential awardees below and click the 'Submit'
      button. The current voting results will be displayed on the 'Awardee' page.</p>
    <form id='elect_form' action="controller.php" method="post">
      <input type="hidden" name="action" value="show_election">
      <?php if ($awardeeVote != FALSE) { ?>
        <?php while ($awardee_vote_iterator->hasNext()) { 
              $app = $awardee_vote_iterator->next();  
        ?>
          <input type="radio" name="vote" value="<?php echo $app['studentNumber']; ?>" required>
          <?php echo $app['firstName'].' '.$app['lastName'].' (Student Number: '.$app['studentNumber'].')'; ?><br><br>
        <?php } ?>
        <br><input type='submit' value='Submit'>
        <?php if(!empty($messageElect)) { ?>
          <span style='float: right;' id='message'><?php echo $messageElect; ?></span>
        <?php } ?>
      <?php } ?>
    </form>
  </section>
</main>
<?php include 'view/footer.php'; ?>
