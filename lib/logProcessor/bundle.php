<?php

require_once 'messageHolder.php';

/**
 * Description of newPHPClass
 *
 * @author papersling
 */
class bundle extends iteratorObject {
    
    /**
     * Container for messages
     * @var messageHolder
     */
    private $_messages;
    
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
        $this->_messages = new messageHolder();
    }
    
    /**
     * Instansiates a bundle.
     * @return bundle 
     */
    public static function instansiate() {
        return new static();
    }
    
    /**
     * Returns the message holder object.
     * @return array
     */
    public function getMessageHolder() {
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
     * Returns an array of the bundle.
     * @return array
     */
    public function toArray() {
        
        return array('bundle' => array(
                         'lastRead' => $this->_lastRead,
                         'messages' => $this->_messages->toArray(),
                    )
        );
    }
    
    /**
     * Returns the bundle in JSON format.
     * @return string
     */
    public function toJson() {
        return json_encode($this->toArray());
    }


    /**
     * Adds a message into the bundle's message container.
     * @param message $message 
     */
    public function addMessage(message $message) {
        $this->_messages->addMessage($message);
        return $this;
    }
}
