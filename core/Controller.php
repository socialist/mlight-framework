<?php

namespace core;


use core\exceptions\NotExistsException;
/**
 * Description of Controller
 *
 * @property Request $request
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
        $this->path   = (isset($config->viewPath)) ? $config->viewPath : APP . 'views/';
        $this->title = (isset($config->title)) ? $config->title : $this->title;
        
        $this->init();
    }
    
    public function beforeAction() {}
    public function afterAction() {}
    
    public function render($tmplPath = false, $params = false)
    {
        $controller = strtolower($this->request->getControllerName());
        $tmplPath = ( $tmplPath ) ? $controller . '/' . $tmplPath 
                : $this->request->getRequestURI();
        $params = ( $params ) ? $params : array();

        $this->buildPage($this->path . $tmplPath, $params, $this->layout);
    }
    
    public function setLayout($layout)
    {
        $this->layout = APP . 'views/layout/' . $layout;
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
