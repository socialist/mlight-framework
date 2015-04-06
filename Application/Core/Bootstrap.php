<?php
namespace Application\Core;

use Application\Core\Exceptions\NotExistsException as NotExistsException;
/**
 * Description of Bootstrap
 *
 * @author walk
 */
define('APP', dirname(dirname(__FILE__)) . '/');

class Bootstrap {
    
    private $_config;
    private static $_instance;
    
    private function __construct() {
        spl_autoload_register([$this, 'autoload']);
    }
    
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
            $e->getMessage();
        }
    }
    
    protected function autoload($className)
    {
        $basePath = dirname(dirname(dirname(__FILE__)));
        
        $path = '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';
        
        require_once($basePath . $path);
    }
    
    private function initController()
    {
        $controller = ucfirst(MLight::app()->request->getControllerName());
        $action     = MLight::app()->request->getActionName() . 'Action';
        if(!file_exists(APP . 'Controller/' . $controller . '.php')) {
            throw new NotExistsException( 'Контроллер ' . $controller . ' не существует');
        } else {
            $controller = 'Application\\Controller\\' . $controller;
            $controller = new $controller();
        }
        if(!method_exists($controller, $action)) {
            throw new NotExistsException("Контроллер " . $controller->name() . " не имеет действия {$action}");
        } else {
            $controller->$action();
        }
    }
}