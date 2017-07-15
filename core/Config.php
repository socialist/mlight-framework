<?php
namespace core;
/**
 * Description of Config
 *
 * @author walk
 */
class Config {
    
    private $params = [];
    
    public function __construct($config)
    {
        if(is_array($config)) {
            $this->params = $this->setArrayParams($config);
        } else if($config instanceof \StdClass) {
            $this->params = $config;
        } else if(file_exists($config)) {
            $this->params = $this->parseFile($config);
        } else {
            throw new \Exception("Unknown configuration format");
        }
    }
    
    public function __get($name)
    {
        if(array_key_exists($name, $this->params)) {
            return $this->params->$name;
        }
        return null;
    }
    
    public function __set($name, $value)
    {
        $this->params->$name = $value;
    }
    
    public function __isset($name)
    {
        return array_key_exists($name, $this->params);
    }
  
    protected function setArrayParams(array $array)
    {
        $std = new \StdClass();
        foreach($array as $key =>$val) {
            if(is_array($val)) {
                $std->$key = $this->setArrayParams($val);
            } else {
                $std->$key = $val;
            }
        }
        return $std;
    }
    
    protected function parseFile($file)
    {
        if(preg_match('/(.*)\.php$/i',$file)) {
            return $this->setArrayParams(include($file));
        } else {
            throw new \Exception('Unknown configuratiin file type');
        }
    }
}