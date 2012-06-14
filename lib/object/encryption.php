<?php

/**
 * Description of reverse
 *
 * @author papersling
 */
class encryption {
    
    /**
     * Temp key - remove during production. 
     */
    const KEY = 'werguiohrgwieuhsdf';
    
    /**
     * Magiv constructor. 
     */
    public function __construct() {
        ;
    }
    
    /**
     * Returns an instance of encryption
     * @return encryption
     */
    public static function getInstance() {
        return new static();
    }
    
    /**
     * Encrypts a string
     * @param string $string
     * @return string
     */
    public function encrypt($string) {
        $key = $this->_getKey();
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
    }
    
    /**
     * Decrypts a string
     * @param string $encrypted
     * @return string
     */
    public function decrypt($encrypted) {
        $key = $this->_getKey();
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
    }
    
    /**
     * Gets thee key for (en|de)cryption 
     * @return string
     */
    private function _getKey() {
        return self::KEY;
    }
}
$baz = 'a:2:{s:5:"pages";a:3:{i:0;s:7:"profile";i:1;s:9:"entourage";i:2;s:6:"badges";}s:13:"registeredUri";s:11:"/player/log";}';
$foo = encryption::getInstance()->encrypt($baz);
echo $foo;

var_dump(unserialize(encryption::getInstance()->decrypt($foo)));