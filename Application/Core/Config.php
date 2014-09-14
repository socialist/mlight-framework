<?php
namespace Application\Core;
/**
 * Description of Config
 *
 * @author walk
 */
class Config {
    
    private $_attributes = array();
    
    public function __construct( $config )
    {
        $this->setData($config);
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
    
    private function setData($data)
    {
        if( !is_array($data) ) return null;
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                $this->$key = new self($value);
                continue;
            }
            $this->$key = $value;
        }
        return $this;
    }
}
