<?php
    require_once('model/iterator/classes.php');
    
    // Iterator
    interface StudentIterator {
        public function next();
        public function hasNext();
    }
?>