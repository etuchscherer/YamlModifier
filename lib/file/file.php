<?php

/**
 * Description of file
 *
 * @author papersling
 */
class fileObj extends object {
    
    const FILE_DOES_NOT_EXIST = -1;
    
    public function __construct($filename, $path) {
        $this->filename = strtolower($filename);
        $this->path     = strtolower($path);
    }
    
    /**
     * Instansiate an instance of a file. 
     * @param string $filename
     * @param string $path
     * @throws Exception 
     */
    public static function instansiate($filename, $path = null) {
        
        if (!is_string($filename)) {
            throw new Exception($this->_stdError($filename, 'string', __METHOD__, __LINE__));
        }
        
        if ($path === null) {
            $path = './';
        }
        
        if (!file_exists($path . '/' . $filename)) {
            throw new Exception('Cannot instansiate, the specified file: \'' . $path . '/' . $filename . '\', does not exist.', 
                                self::FILE_DOES_NOT_EXIST);
        }
        
        return new static($filename, $path);
    }
    
    /**
     * Returns true if the file is yaml.
     * @return boolean 
     */
    public function isYaml() {
        if (preg_match('/\S+\.(yml|yaml)/', $this->filename)) {
            return true;
        }
        return false;
    }
    
    /**
     * Returns true if the file is php.
     * @return boolean 
     */
    public function isPhp() {
        if (preg_match('/\S+\.(phtml|php)/', $this->filename)) {
            return true;
        }
        return false;
    }
    
    public function __toString() {
        return file_get_contents($this->path . '/' . $this->filename);
    }
}
