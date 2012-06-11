<?php

require_once 'object.php';

/**
 * Description of iterator
 *
 * @author papersling
 */
class iteratorObject extends object implements Iterator {
    
    const POSITION_DOES_NOT_EXIST = -1;
    const ITERATOR_NOT_LOADED     = -2;

    private $_iterator = array();
    
    /**
     * @param int $position
     * @return mixed
     */
    public function seek($position) {
        
        if (!is_numeric($position)) {
            throw new Exception($this->_stdError($position, 'numeric', __METHOD__, __LINE__));
        }
        
        if (!$this->isLoaded()) {
            throw new Exception('Cannot return iterator. Data not loaded. Thrown in ' . 
                                __METHOD__ . ' on line: ' . __LINE__ . '.', self::ITERATOR_NOT_LOADED);
        }
        
        if (array_key_exists($position, $this->_iterator)) {
            return $this->_iterator[$position];
        }
        throw new Exception('Cannot return iterator. Position does not exist.', self::POSITION_DOES_NOT_EXIST);
    }
    
    /**
     * Loads data into the iterator.
     * @param array $data 
     * @return $data;
     */
    public function loadIterator(Array $data) {
        $this->_iterator = $data;
        return $this;
    }

    public function rewind() {
        reset($this->_iterator);
        return $this;
    }
    
    public function current() {
        
        if (!$this->isLoaded()) {
            throw new Exception('Cannot return iterator. Data not loaded. Thrown in ' . 
                                __METHOD__ . ' on line: ' . __LINE__ . '.', self::ITERATOR_NOT_LOADED);
        }
        
        return current($this->_iterator);
    }
    
    public function key() {
        return key($this->_iterator);
    }
    
    public function next() {
        next($this->_iterator);
        return $this;
    }
    
    public function valid() {
        return array_key_exists($this->_iterator, $this->key());
    }
    
    /**
     * Returns true if the iterator is loaded, otherwise false.
     * @return boolean 
     */
    private function isLoaded() {
        if (!empty($this->_iterator)) {
            return true;
        }
        return false;
    }
    
    /**
     * Returns the iterator object
     * @return file 
     */
    public function getIterator() {
        return $this->_iterator;
    }
}
