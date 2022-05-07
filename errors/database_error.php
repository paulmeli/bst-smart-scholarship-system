<?php include './view/header.php'; ?>
<main class='mainError'>
  <h2>Database Error</h2>
  <p>There was an error connecting to the database.</p>
  <p>Error message: <?php echo $error_message; ?></p>
</main>
<?php include './view/footer.php'; ?>
