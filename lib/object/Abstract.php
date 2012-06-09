<?php

/**
 * Description of Object
 *
 * @author Eric Tuchscherer 
 */
abstract class Eric_Object_Abstract 
{
    const INVALID_PARAMETER = -103;
   
    private $_data = array();
    
    private $_row;
    
    private $_cols;
    
    public function __construct($row = null) 
    {

        if ($row === null) {
            throw new Exception('Cannot instansiate an object without data.');
        }
        
        if (!empty($row)) {
            $this->_row = $row;
        } else {
            throw new Exception($this->_stdError($row, '!empty', __METHOD__, __LINE__), self::INVALID_PARAMETER);
        }
        
        $this->_loadMetaData($row);
        $this->init();
    }
    
    public function save() 
    {
        $this->_row->save();
    }
    
    /**
     * Converts a timestamp (from database) to a 
     * specified string format. 
     * @param $timestamp 
     * @param $format -see below for options
     * @see http://php.net/manual/en/function.date.php
     */
    public function getDate($timestamp, $format)
    {
        if (!is_numeric($timestamp)) {
            throw new Exception($this->_stdError($timestamp, 'numeric', __METHOD__, __LINE__), self::INVALID_PARAMETER);
        }
        
        return date($format, $timestamp);
    }
    
    /**
     * Returns an object by $id. 
     * @param int $id
     * @return Math_Model_Tuch_Object_Abstract
     * //TODO debug magic method loading !!
     */
    public static function findById($id)
    {
        $data = self::getDataModel();
        $row  = $data->find($id);
        
        if ($row) {
            return new static($row->current());
        }
    }
    
    /**
     * Returns the data model. 
     * @return Zend_Db_Table_Abstract
     */
    public static function getDataModel()
    {
        $data = static::$_dataModel;

        if(class_exists($data))
        {
            return new $data;
        }
        throw new Exception('Data model:: ' . $data . ' could not be loaded, is public $_dataModel defined ?');
    }
    
    abstract public function init();
    
    /**
     * Returns a row. 
     * @return Zend_Db_Table_Row
     */
    public function getRow()
    {
        return $this->_row;
    }
    
    /**
     * Returns an array of table column names. 
     * @return array
     */
    public function getCols()
    {
        return $this->_cols;
    }
    
    /**
     * Sets up column name data if $row is an instance of Zend_Db_Table_Row. 
     * Otherwise throws an exception. 
     * @param  Zend_Db_Table_Row $row
     * @return Zend_Db_Table_Row
     * @throws Exception 
     */
    private function _loadMetaData($row)
    {
        if ($row instanceof Zend_Db_Table_Row)
        {
            $this->_setCols($row->getTable()->info(Zend_Db_Table_Abstract::COLS));
        } else {
            throw new Exception($this->_stdError($row, 'Zend_Db_Table_Row', __METHOD__, __LINE__), self::INVALID_PARAMETER);
        }

        $this->_hydrate();
        return $row;
    }
    
    /**
     * Loads the tables column names. 
     * @param  Zend_Db_Table_Row $row
     * @throws Exception 
     */
    private function _setCols($row)
    {
        if (is_array($row))
        {
            $this->_cols = $row;
        } else {
            throw new Exception($this->_stdError($row, 'array', __METHOD__, __LINE__), self::INVALID_PARAMETER);
        }
    }

    /**
     * Hydrates the object. 
     */
    private function _hydrate()
    {
        foreach ($this->_cols as $field)
        {
            $this->_data[$field] = $this->_row->$field;
        }
    }
    
    /**
     * Magic setter. 
     * @param mixed $name
     * @param mixed $value 
     */
    public function __set($name, $value) {
        $this->_data[$name]=$value;
    }
    
    /**
     * Magic getter.
     * @param mixed $name
     * @return mixed 
     */
    public function __get($name) {
        if (array_key_exists($name, $this->_data))
        {
            return $this->_data[$name];
        }
    }
    
    /**
     * Magic isset.
     * @param mixed $name 
     */
    public function __isset($name) {
        return isset($this->_data[$name]);
    }
    
    /**
     * Magic unset.
     * @param mixed $name 
     */
    public function __unset($name) {
        unset($this->_data[$name]);
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


