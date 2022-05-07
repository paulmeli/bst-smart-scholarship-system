<?php
function check_registrar($student_number) {
  global $db;
  $query = 'SELECT status, cumulativeGPA, credits, dateOfBirth, semesterGPA
            FROM REGISTRAR_OFFICE X
            WHERE X.studentNumber = :student_number';
  $statement = $db->prepare($query);
  $statement->bindValue(':student_number', $student_number);
  $statement->execute();
  $valid_student_info = $statement->fetch();
  $statement->closeCursor();
  return $valid_student_info;
}

function ask_bill($finalAwardee) {
  // Query bill amount for awardee
  global $db;
  $query = 'SELECT *
            FROM REGISTRAR_OFFICE X
            WHERE X.studentNumber = :student_number';
  $statement = $db->prepare($query);
  $statement->bindValue(':student_number', $finalAwardee['studentNumber']);
  $statement->execute();
  $awardeeBill = $statement->fetch();
  $statement->closeCursor();

  // Generate corresponding XML doc
  $domDoc = new DOMDocument('1.0', 'UTF-8');
  $domDoc->preserveWhiteSpace = false;
  $domDoc->formatOutput = true;

  $xmlRoot = $domDoc->createElement("awardeeBill");
  $xmlRoot = $domDoc->appendChild($xmlRoot);

  $awardee = $domDoc->createElement("awardee");
  $awardee = $xmlRoot->appendChild($awardee);
  $awardee->appendChild($domDoc->createElement('firstName', $finalAwardee['firstName']));
  $awardee->appendChild($domDoc->createElement('lastName', $finalAwardee['lastName']));
  $awardee->appendChild($domDoc->createElement('studentNumber', $finalAwardee['studentNumber']));

  $xmlRoot->appendChild($domDoc->createElement('bill', $awardeeBill['billAmount']));

  $xml = fopen('awardee_bill.xml','w+');
  fwrite($xml, $domDoc->saveXML());
  fclose($xml);

  return $awardeeBill['billAmount'];
}
?>
