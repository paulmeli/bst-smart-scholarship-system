<?php
    require_once('model/iterator/classes.php');

    // ConcreteAggregate for binary search tree
    class AwardeeStudentAggregate implements StudentAggregate {
        public $root = null; // Hidden binary search tree data structure
        private $student_count = 0;

        public function createIterator() {
            return new AwardeeStudentIterator($this);
        }

        public function getStudentCount() {
            return $this->student_count;
        }

        private function setStudentCount($count) {
            $this->student_count = $count;
        }

        public function addStudent($student) {
            $student_node = $this->root;

            if (!$student_node) {
                $this->setStudentCount($this->getStudentCount() + 1);
                return $this->root = new StudentNode($student);
            }

            while ($student_node) {
                if ((int)$student['studentNumber'] > (int)$student_node->student['studentNumber']) {
                    if ($student_node->right) {
                        $student_node = $student_node->right;
                    } 
                    else {
                        $student_node = $student_node->right = new StudentNode($student, $student_node);
                        $this->setStudentCount($this->getStudentCount() + 1);
                        break;
                    }
                } 
                else if ((int)$student['studentNumber'] < (int)$student_node->student['studentNumber']) {
                    if ($student_node->left) {
                        $student_node = $student_node->left;
                    } 
                    else {
                        $student_node = $student_node->left = new StudentNode($student, $student_node);
                        $this->setStudentCount($this->getStudentCount() + 1);
                        break;
                    }
                } 
                else {
                    break;
                }
            }

            return $student_node;
        }

    }
?>