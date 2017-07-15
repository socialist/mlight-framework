<?php
namespace core;
/**
 * Description of Request
 *
 * @author walk
 */
class Request {
    
    private $post    = [];
    private $get     = [];
//    private $fies    = [];
    private $cookie  = [];
    private $session = [];
    private $params  = [];


    public function __construct() {
        $this->get     = @$_GET;
        $this->post    = @$_POST;
        $this->files   = @$_FILES;
        $this->cookie  = @$_COOKIE;
        $this->session = @$_SESSION;
        
        $this->parseRequest();
    }

    /**
     * @param string $key
     * @return array
     */
    public function serverInfo($key = null)
    {
        if($key && array_key_exists($key, $_SERVER)) {
            return $_SERVER[$key];
        }
        return $_SERVER;
    }

    /**
     * @return mixed|string
     */
    public function getControllerName()
    {
        $controller = (isset($this->params[0])) ? $this->params[0] : 'index';
        return ucfirst($controller);
    }

    /**
     * @return mixed|string
     */
    public function getActionName()
    {
        $action = (isset($this->params[1])) ? $this->params[1] : 'index';

        return "{$action}Action";
    }

    public function getRequestURI()
    {
        return implode('/', $this->params);
    }

    private function parseRequest()
    {
        if(isset($this->get['r'])) {
            $request = $this->get['r'];
        } else {
            $request = $this->serverInfo('REQUEST_URI');
        }

        $params = explode('/', $this->clear($request));

        if(count($params) === 0) {
            $params = array('index', 'index');
        }
        $this->params = $params;
    }

    /**
     * @param string $path
     * @return string
     */
    private function clear( $path )
    {
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }
        return $path;
    }
}
