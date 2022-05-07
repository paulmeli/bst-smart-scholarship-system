<?php
function request_reimburse($student_number, $bill) {
  global $db;
  $query = 'INSERT INTO ACCOUNTING_DEPARTMENT
              (studentNumber, reimbursement)
            VALUES
              (:student_number, :bill)';
  $statement = $db->prepare($query);
  $statement->bindValue(':student_number', $student_number);
  $statement->bindValue(':bill', $bill);
  $statement->execute();
  $statement->closeCursor();
  return 'Request submitted!';
}
?>
