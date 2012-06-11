<?php

require_once '../object/iterator.php';
require_once 'file.php';

class dir extends iteratorObject {
    
    public function __construct($directory) 
    {
        if (!is_string($directory)) {
            $this->_stdError($var, $expected, $method, $line);
        }
        
        $files  = array();
        $handle = opendir($directory);

        while (($file = readdir($handle)) !== false) {
            $files[]  = new fileObj($file, $directory);
        }
        
        array_shift($files);
        array_shift($files);
        
        closedir($handle);        
        $this->loadIterator($files);
        return $this;
    }
    
    /**
     * Creates a file in this dir. 
     * @param string $filename
     * @param string $content 
     */
    public function addFile($filename, $content) {
        $file = fileObj::create($filename, $content);
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
