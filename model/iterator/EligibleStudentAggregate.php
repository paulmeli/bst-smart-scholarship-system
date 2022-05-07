<?php
    require_once('model/iterator/classes.php');
    
    // ConcreteAggregate for array
    class EligibleStudentAggregate implements StudentAggregate {
        private $students = array(); // Hidden array data structure
        private $student_count = 0;

        public function createIterator() {
            return new EligibleStudentIterator($this);
        }

        public function getStudentCount() {
            return $this->student_count;
        }

        private function setStudentCount($count) {
            $this->student_count = $count;
        }

        public function getStudent($student_number) {
            if ((is_numeric($student_number)) && ($student_number <= $this->getStudentCount())) {
                return $this->students[$student_number];
            } 
            else {
                return NULL;
            }
        }

        public function addStudent($student) {
            $this->setStudentCount($this->getStudentCount() + 1);
            $this->students[$this->getStudentCount()] = $student;
        }

    }
?>