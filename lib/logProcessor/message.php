<?php

require_once '../object/object.php';

/**
 * Description of message
 *
 * @author papersling
 */
class message extends object {
    
    /**
     * The message container
     * @var array
     */
    private $_message = array();
    
    /**
     * Magic constructor
     * @param type $content
     * @param type $date 
     */
    public function __construct($content, $date) {
        
        if (!is_string($content)) {
            $content = (string) $content;
        }
        
        if (!is_numeric($date)) {
            $date = strtotime($date);
        }
        
        $this->setContent($content);
        $this->setDate($date);
    }
    
    /**
     * Gets an instance of message object
     * @param string $content
     * @param int    $date
     * @return message
     */
    public static function getInstance($content = null, $date = null) {
        return new static($content, $date);
    }
    
    /**
     * Sets the message content. 
     * @param string $content
     * @return message 
     */
    public function setContent($content) {
        $this->_message['content'] = $content;
        return $this;
    }
    
    /**
     * Sets the message date
     * @param int $date
     * @return message 
     */
    public function setDate($date) {
        $this->_message['date'] = $date;
        return $this;
    }
    
    /**
     * Gets the message in hash format.
     * @return array
     */
    public function toArray() {
        return $this->_message;
    }
    
    /**
     * Gets the message in json format.
     * @return string
     */
    public function toJson() {
        return json_encode($this->_message);
    }
    
    /**
     * Defaults to json output.
     * @return sting.
     */
    public function __toString() {
        return $this->toJson();
    }
    
}
