<?php
function add_awardee($awardee) {
  if (awardee_insert_exists()) {
    return 'Email already sent.';
  }
  else {
    global $db;
    $query = 'INSERT INTO AWARDED
                (studentNumber, firstName, lastName)
              VALUES
                (:student_number, :first_name, :last_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':student_number', $awardee['studentNumber']);
    $statement->bindValue(':first_name', $awardee['firstName']);
    $statement->bindValue(':last_name', $awardee['lastName']);
    $statement->execute();
    $statement->closeCursor();
    return 'Email sent!';
  }
}

function awardee_insert_exists() {
  global $db;
  $query = 'SELECT *
            FROM AWARDED X';
  $statement = $db->prepare($query);
  $statement->execute();
  $awardeeExists = $statement->fetch();
  $statement->closeCursor();
  return $awardeeExists;
}

function get_final_awardee() {
  global $db;
  $query = 'SELECT *
            FROM AWARDED';
  $statement = $db->prepare($query);
  $statement->execute();
  $finalAwardee = $statement->fetch();
  $statement->closeCursor();
  return $finalAwardee;
}

function add_bill($student_number, $bill) {
  global $db;
  $query = 'UPDATE AWARDED X
            SET awardedAmount = :bill
            WHERE X.studentNumber = :student_number';
  $statement = $db->prepare($query);
  $statement->bindValue(':student_number', $student_number);
  $statement->bindValue(':bill', $bill);
  $statement->execute();
  $statement->closeCursor();
}
?>
