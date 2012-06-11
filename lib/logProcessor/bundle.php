<?php

require_once '../object/iterator.php';

/**
 * Description of newPHPClass
 *
 * @author papersling
 */
class bundle extends iteratorObject {
    
    /**
     * Container for messages
     * @var array
     */
    private $_messages = array();
    
    /**
     * Timestamp of last read.
     * @var int
     */
    private $_lastRead;
    
    /**
     * Constructor
     */
    public function __construct($lastRead = null) {
        
        if (!$lastRead) {
            $lastRead = time();
        }
        
        if (!is_numeric($lastRead)) {
            throw new Exception($this->_stdError($lastRead, 'numeric', __METHOD__, __LINE__));
        }
        
        $this->_lastRead = $lastRead;
    }
    
    /**
     * Instansiates a bundle.
     * @return bundle 
     */
    public static function instansiate() {
        return new static();
    }
    
    /**
     * Returns an array of all the bundle's messages. 
     * @return array
     */
    public function getMessages() {
        return $this->_messages;
    }
    
    /**
     * Returns a timestamp of the last time
     * the bundle was read. 
     * @param  string $format - (optional) std php date format
     * @return int 
     */
    public function getLastRead($format = null) {
        
        if ($format === null) {
            return $this->_lastRead;
        }
        
        if (!is_string($format)) {
            throw new Exception($this->_stdError($format, 'string', __METHOD__, __LINE__));
        }
        
        return date($format, $this->_lastRead);
    }
    
    /**
     * Adds a message into the bundle.
     * @param message $message 
     */
    private function _addMessage(message $message) {
        $this->_messages[] = $message;
        return $this;
    }
}
