<?php
namespace Core;
/**
 * Description of App
 *
 * @author walk
 */
class MLight {
    
    private static $_instance;
    
    private $_attributes = [];
    
    private function __construct() {}
    
    public static function app()
    {
        if(null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function __get($name)
    {
        if(array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        }
        return null;
    }
    
    public function __set($name, $value)
    {
        $this->_attributes[$name] = $value;
    }
    
}
