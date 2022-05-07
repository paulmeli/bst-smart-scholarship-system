<?php
    require_once('model/iterator/classes.php');
    
    // IteratorAggregate
    interface StudentAggregate {
        public function createIterator();
    }
?>