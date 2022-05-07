<?php
    require_once('model/iterator/classes.php');
    
    // ConcreteIterator for stack
    class NoneligibleStudentIterator implements StudentIterator {
        private $student_aggregate; 
        private $current_student;

        public function __construct($student_aggregate) {
            $this->student_aggregate = $student_aggregate;
            $this->current_student = $student_aggregate->getStudentCount() - 1; // Top of stack
        }

        public function next() {
            if ($this->hasNext()) {
                --$this->current_student;
                return $this->student_aggregate->getStudent();
            } 
            else {
                return NULL;
            }
        }

        public function hasNext() {
            if ($this->current_student > -1) {
                return TRUE;
            } 
            else {
                return FALSE;
            }
        }
    }
?>