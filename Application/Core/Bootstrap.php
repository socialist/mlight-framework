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
        
        $this->initController();
    }
    
    private function initController()
    {
        $controller = ucfirst(MLight::app()->request->getControllerName());
        $action     = MLight::app()->request->getActionName() . 'Action';
        if(!file_exists(APP . 'Controller/' . $controller . '.php')) {
            throw new \Exception('Контроллер ' . $controller . ' не существует');
        } else {
            $controller = 'Application\\Controller\\' . $controller;
            $controller = new $controller();
        }
        if(!method_exists($controller, $action)) {
            throw new Exception("Контроллер {$controller} не имеет действия {$action}");
        } else {
            $controller->$action();
        }
    }
}
