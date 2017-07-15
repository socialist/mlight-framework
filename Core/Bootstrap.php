<?php
namespace Core;

use Core\Exceptions\NotExistsException;
/**
 * Description of Bootstrap
 *
 * @author walk
 */

class Bootstrap {
    
    private $_config;
    private static $_instance;
    
    private function __construct() {}
    
    public static function app()
    {
        if(null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function run( $config )
    {
        try {
            $this->_config = new Config($config);
        
            MLight::app()->config = $this->_config;
            MLight::app()->request = new Request();
        
            $this->initController();
        } catch(NotExistsException $e) {
            echo $e->getMessage();
        }
        catch(\Exception $e) {
            echo $e->getMessage();
        }
    }
    
    private function initController()
    {
        $controller = ucfirst(MLight::app()->request->getControllerName());
        $action     = MLight::app()->request->getActionName() . 'Action';

        if(!file_exists(APP . 'Controller/' . $controller . '.php')) {
            throw new NotExistsException( 'Контроллер ' . $controller . ' не существует');
        } else {
            $controllerName = 'Application\\Controller\\' . $controller;
            $controller = new $controllerName();
        }

        if(!method_exists($controller, $action)) {
            throw new NotExistsException("Контроллер " . $controller->name() . " не имеет действия {$action}");
        } else {
            $controller->$action();
        }
    }
}