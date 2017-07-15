<?php

namespace Core;


use Core\Exceptions\NotExistsException;
/**
 * Description of Controller
 *
 * @author walk
 */
class Controller {
    
    protected $defaultAction = 'index';
    public $title = '';
    protected $request;
    protected $layout;
    private $path;
    
    public function __construct()
    {
        $this->request = MLight::app()->request;
        
        $config = MLight::app()->config;
        if(isset($config->layout)) {
            $this->setLayout($config->layout);
        }
        $this->path   = (isset($config->viewPath)) ? $config->viewPath : APP . 'Views/';
        $this->title = (isset($config->title)) ? $config->title : $this->title;
        
        $this->init();
    }
    
    public function beforeAction() {}
    public function afterAction() {}
    
    public function render($tmplPath = false, $params = false)
    {
        $controller = $this->request->getControllerName();
        $action = $this->request->getActionName();
        $tmplPath = ( $tmplPath ) ? $controller . '/' . $tmplPath 
                : $controller . '/' . $action;
        $params = ( $params ) ? $params : array();
        
        $this->buildPage($this->path . $tmplPath, $params, $this->layout);
    }
    
    public function setLayout($layout)
    {
        $this->layout = APP . 'Views/layout/' . $layout;
    }
    
    public function name()
    {
        return self::class;
    }
    
    protected function init()
    {
        
    }
    
    private function buildPage($tmpl, array $params, $layout)
    {
        
        extract($params, EXTR_OVERWRITE);
        if($this->layout) {
            if(!file_exists($this->layout . '.php')) {
                throw new NotExistsException('Неверно задан путь к макету страницы');
            }
            if(!file_exists($tmpl . '.php')) {
                throw new NotExistsException('Неверно задан путь к файлу шаблона');
            }
            $content = $this->renderTemplate($tmpl . '.php', $params);
            include($this->layout . '.php');
        } else {
            if(!file_exists($tmpl . '.php')) {
                throw new NotExistsException('Неверно задан путь к файлу шаблона');
            }
            include($tmpl . '.php');
        }
    }
    
    private function renderTemplate($tmpl, $params = false)
    {
        extract($params, EXTR_OVERWRITE);
        ob_start();
        include($tmpl);
        return ob_get_clean();
    }
}
