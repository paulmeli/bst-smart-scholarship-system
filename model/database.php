<?php
  // Connect to MySQL database named smart_scholarship_system
  $dsn = 'mysql:host=localhost;dbname=smart_scholarship_system'; // Specifies host computer for MySQL database and name of database
  $username = 'guest_user';
  $password = 'pa$$word';

  try {
    $db = new PDO($dsn, $username, $password);
  }
  catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('errors/database_error.php');
    exit();
  }
?>
