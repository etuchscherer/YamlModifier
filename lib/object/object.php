<?php

/**
 * Description of Object
 *
 * @author Eric Tuchscherer 
 */
abstract class object {
    
    private $_overload = array();
    
    /**
     * Magic setter. 
     * @param mixed $name
     * @param mixed $value 
     */
    public function __set($name, $value) {
        $this->_overload[$name]=$value;
    }
    
    /**
     * Magic getter.
     * @param mixed $name
     * @return mixed 
     */
    public function __get($name) {
        if (array_key_exists($name, $this->_overload))
        {
            return $this->_overload[$name];
        }
    }
    
    /**
     * Magic isset.
     * @param mixed $name 
     */
    public function __isset($name) {
        return isset($this->_overload[$name]);
    }
    
    /**
     * Magic unset.
     * @param mixed $name 
     */
    public function __unset($name) {
        unset($this->_overload[$name]);
    }
    
    /**
     * A standard error for a functions parameters. 
     * @param mixed  $var
     * @param string $expected
     * @param string $method
     * @param string $line
     * @return string
     */
    protected function _stdError($var, $expected, $method, $line) {
        $error = 'Missing or incorrect variable in ' . $method . '() on line: ' . $line .
                 '. Expected %s to be a %s, was passed, \''. $var .'\', type: ' .
                 gettype($var);
        
        return sprintf($error, $var, $expected);
    }
}


