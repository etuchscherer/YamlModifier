<?php

require_once '../object/object.php';
/**
 * Description of file
 *
 * @author papersling
 */
class fileObj extends object {
    
    const FILE_DOES_NOT_EXIST = -1;
    
    const WRITE_MODE  = 'w';
    
    const APPEND_MODE = 'a';
    
    public function __construct($filename, $path) {
        $this->filename = $filename;
        $this->path     = $path;
        $this->content  = $this->_getContents();
    }
    
    /**
     * Instansiate an instance of a file. 
     * @param string $filename
     * @param string $path
     * @return fileObj
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
     * Creates a new file in the current directory. If the file already exists,
     * it returns that fileObj
     * @param string $filename
     * @return fileObj
     */
    public static function touch($filename) {
        
        if (!is_string($filename)) {
            throw new Exception($this->_stdError($filename, 'string', __METHOD__, __LINE__));
        }
        
        if (!file_exists($filename)) {
            
            $newFile = new static($filename, '.');
            $newFile->setHandle(self::WRITE_MODE)->closeHandle();

            if (!is_file($filename)) {
                throw new Exception('New file creation failed.');
            }
        } else {
            $newFile = self::instansiate($filename);
        }
        
        return $newFile;
    }
    
    /**
     * Writes content to the file.
     * @param string $content
     * @return fileObj
     */
    public function write($content) {
        
        if (!is_string($content)) {
            $content = (string) $content;
        }
        
        $this->_setHandle(self::WRITE_MODE);
        fwrite($this->handle, $content);
        $this->closeHandle();
        return $this;
    }
    
    /**
     * Appends a line to the file. If newline is true, automaticly
     * inserts a lf after the content. 
     * @param string $content
     * @param bool   $newline optional - newline char defaults to true.
     * @return fileObj 
     */
    public function append($content, $newline = true) {
        if (!is_string($content)) {
            $content = (string) $content;
        }
        
        if ($newline) {
            $newline = "\n";
        } else {
            $newline = "";
        }
        
        $this->setHandle(self::APPEND_MODE);
        fwrite($this->handle, $content . $newline);
        $this->closeHandle();
        
        return $this;
    }
    
    /**
     * Deletes the file and returns true upon success.  
     */
    public function destroy() {
        unlink($this->getAbsolutePath());
        
        if (file_exists($this->getAbsolutePath())) {
            throw new Exception('File destruction failed. Check permissions. Thrown in ' 
                                . __METHOD__ . ' on line: ' .__LINE__ );
        }
        return true;
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
    
    /**
     * Returns a string of the files contents. 
     * @return string
     */
    public function getContent() {
        return $this->content;
    }
    
    /**
     * Returns true if the file is empty, otherwise false. 
     * @return bool
     */
    public function isEmpty() {
        return empty($this->content);
    }
    
    /**
     * Returns the string representation of the file's absolute path. 
     * @return string
     */
    public function getAbsolutePath() {
        return $this->path . '/' . $this->filename;
    }
    
    /**
     * Returns a string of the files contents.
     * @param int $offset [optional] <p>
     * The offset where the reading starts on the original stream.
     * </p>
     * <p>
     * Seeking (<i>offset</i>) is not supported with remote files.
     * Attempting to seek on non-local files may work with small offsets, but this
     * is unpredictable because it works on the buffered stream.
     * </p>
     * @param int $maxlen [optional] <p>
     * Maximum length of data read. The default is to read until end
     * of file is reached. Note that this parameter is applied to the
     * stream processed by the filters.
     * </p>
     * @return string 
     */
    private function _getContents() {
        return file_get_contents($this->getAbsolutePath());
    }
    
    /**
     * Opens the file and overloads the handle object.
     * @param string $mode
     * @return fileObj
     */
    public function setHandle($mode) {
        
        if (!preg_match('/(w|r)/', $mode)) {
            throw new Exception('Invalid $mode specified. Please use \'w\' for write or \'r\' for read. ' . 
                                'Thrown in ' . __METHOD__ . ' on line: ' . __LINE__);
        }
        
        $this->handle = fopen($this->getAbsolutePath(), $mode);
        return $this;
    }
    
    /**
     * Closes the file's handle.
     * @return fileObj
     */
    public function closeHandle() {
        fclose($this->handle);
        return $this;
    }

    /**
     * Magic toString
     * @return string
     */
    public function __toString() {
        return $this->content;
    }
}
