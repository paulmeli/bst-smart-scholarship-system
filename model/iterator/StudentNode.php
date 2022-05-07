<?php
    require_once('model/iterator/classes.php');
    
    // Node for AwardeeStudentAggregate 
    // Binary search tree data structure that holds student values
    class StudentNode {
        public $parent;
        public $student;
        public $left;
        public $right;

        public function __construct($student, $parent = null) {
            $this->student = $student;
            $this->parent = $parent;
        }
    }
?>


