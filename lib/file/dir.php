<?php

include '../object/iterator.php';

class dir extends iteratorObject {
    
    public function __construct($directory) 
    {
        if (!is_string($directory)) {
            $this->_stdError($var, $expected, $method, $line);
        }
        
        $array = array();
        $handle = opendir($directory);

        while (($file = readdir($handle)) !== false) {
            $array[] = new fileObj($file, $directory);
        }
        
        array_shift($array);
        array_shift($array);
        
        closedir($handle);        
        $this->load($array);
        return $this;
    }
    
    /**
     * Returns an instance of File.
     * @return dir
     */
    public static function getInstance($directory) {
        return new static($directory);
    }
    
    /**
     * Returns the current file object.
     * @return fileObj
     */
    public function current() {
        return parent::current();
    }
    
    /**
     * Returns a file object. 
     * @param type $position 
     * @return fileObj
     */
    public function seek($position) {
        return parent::seek($position);
    }
    
    /**
     * Goes to the first file in the dir.
     * @return dir
     */
    public function rewind() {
        parent::rewind();
        return $this;
    }
    
    /**
     * Moves forward to the next file in the dir. 
     * @return dir
     */
    public function next() {
        parent::next();
        return $this;
    }
}
