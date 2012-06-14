<?php

require_once '../object/object.php';
/**
 * Description of onboarding
 *
 * @author papersling
 */
class onboarding extends object {
    
    /**
     * Container for onboarding cookie data.
     * @var array
     */
    protected $_output;
    
    /**
     * Constructor. 
     */
    public function __construct() {
        $this->_output = array('pages' => array(), 'registeredUri' => '');
    }
    
    /**
     * Returns a new onboarding instance.
     * @return onboarding
     */
    public function getInstance() {
        return new static();
    }
    
    /**
     * Sets the uri where registration was triggered. 
     * @param  string $uri <b>The uri that the player registerd on.</b>
     * @return onboarding
     */
    public function setRegisteredUri($uri) {
        $this->_output['registeredUri'] = $uri;
        return $this;
    }
    
    /**
     * Gets the uri where registration was triggered. 
     * @return string
     */
    public function getRegisteredUri() {
        return $this->_output['registeredUri'];
    }
    
    /**
     * Sets onboarding vars. 
     * @param string $page 
     * @return onboarding
     */
    public function setOnboarding($page) {

        $this->_output['pages'][] = $page;
        return $this;
    }
    
    /**
     * Outputs the needed shit for the cookie.
     * @return string
     */
    public function getOutput() {
        return serialize($this->_output);
    }
}

$foo = onboarding::getInstance();
        $foo->setOnboarding('profile')->setOnboarding('entourage')->setOnboarding('badges')
            ->setRegisteredUri('/player/log');

var_dump($foo->getOutput());