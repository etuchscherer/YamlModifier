<?php

require_once '../object/iterator.php';

/**
 * Description of messageHolder
 *
 * @author papersling
 */
class messageHolder extends iteratorObject {
    
    /**
     * Container for holding messages
     * @var array
     */
    private $_messages = array();


    /**
     * Constructor 
     */
    public function __construct() {
        ;
    }
    
    /**
     * Returns a new instance of messageHolder
     * @return messageHolder 
     */
    public static function instansiate() {
        return new static();
    }
    
    /**
     * Adds a message into the messageHolder.
     * @param message $message
     * @return messageHolder 
     */
    public function addMessage(message $message) {
        $this->_messages[] = $message;
        
        return $this;
    }
    
    /**
     * Adds an array of messages into the message holder.
     * @param array $messages
     * @return messageHolder 
     */
    public function addMessages(Array $messages) {
        foreach ($messages as $message) {
            $this->addMessage($message);
        }
        
        return $this;
    }
    
    /**
     * Returns messages in array format.
     * @return array;
     */
    public function toArray() {
        $messages = array();
        
        foreach ($this->_messages as $message) {
            $messages[] = $message->toArray();
        }
        return $messages;
    }
}
