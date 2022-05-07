<?php
    require_once('model/iterator/classes.php');
    
    // ConcreteIterator for array
    class EligibleStudentIterator implements StudentIterator {
        private $student_aggregate; 
        private $current_student = 0;

        public function __construct($student_aggregate) {
            $this->student_aggregate = $student_aggregate;
        }

        public function next() {
            if ($this->hasNext()) {
                return $this->student_aggregate->getStudent(++$this->current_student);
            } 
            else {
                return NULL;
            }
        }

        public function hasNext() {
            if ($this->student_aggregate->getStudentCount() > $this->current_student) {
                return TRUE;
            } 
            else {
                return FALSE;
            }
        }
    }
?>