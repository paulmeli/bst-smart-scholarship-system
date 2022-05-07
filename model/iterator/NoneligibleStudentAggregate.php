<?php
    require_once('model/iterator/classes.php');
    
    // ConcreteAggregate for stack
    class NoneligibleStudentAggregate implements StudentAggregate {
        private $students = array(); // Hidden stack data structure
        private $student_count = 0;

        public function createIterator() {
            return new NoneligibleStudentIterator($this);
        }

        public function getStudentCount() {
            return $this->student_count;
        }

        private function setStudentCount($count) {
            $this->student_count = $count;
        }

        public function getStudent() {
            if ($this->getStudentCount() > 0) {
                $this->setStudentCount($this->getStudentCount() - 1);
                return array_pop($this->students);
            } 
            else {
                return NULL;
            }
        }

        public function addStudent($student) {
            $this->setStudentCount($this->getStudentCount() + 1);
            array_push($this->students, $student);
        }

    }
?>