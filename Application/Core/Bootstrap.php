<?php
namespace Application\Core;
/**
 * Description of ABootstrap
 *
 * @author walk
 */
class Bootstrap {
    
    private $_config;
    private static $_instance;
    
    private function __construct() {}
    
    public static function run()
    {
        if(null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function init( $config )
    {
        $this->_config = new Config(include($config));
        
        MLight::app()->config = $this->_config;
        MLight::app()->request = new Request();
        
        Dump::log(MLight::app());
    }
}
