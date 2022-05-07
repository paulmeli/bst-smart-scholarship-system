<?php
    require_once('model/iterator/classes.php');
    
    // ConcreteIterator for binary search tree
    class AwardeeStudentIterator implements StudentIterator {
        private $student_aggregate; 
        private $current_student;
        private $student_nodes_stack = array(); // Stack for binary search tree nodes
        private $first_node = true; // Checks if the first node is being displayed

        public function __construct($student_aggregate) {
            $this->student_aggregate = $student_aggregate;
            $this->current_student = $student_aggregate->getStudentCount() - 1;
            $current_node = $student_aggregate->root;

            while ($current_node != null) { // Initial stack
                array_push($this->student_nodes_stack, $current_node);
                $current_node = $current_node->left;
            }
        }

        public function next() {
            if ($this->hasNext()) {
                if (!$this->first_node) { 
                    $temp_node = end($this->student_nodes_stack)->right;
                    array_pop($this->student_nodes_stack);

                    while ($temp_node != null) {
                        array_push($this->student_nodes_stack, $temp_node);
                        $temp_node = $temp_node->left;
                    }
                }

                $this->first_node = false;
                --$this->current_student;
                return end($this->student_nodes_stack)->student;
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