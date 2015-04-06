<?php
namespace Application\Core;
/**
 * Description of Request
 *
 * @author walk
 */
class Request {
    
    private $_post    = array();
    private $_get     = array();
    private $_fies    = array();
    private $_cookie  = array();
    private $_session = array();
    private $_params  = array();
    
    public function __construct() {
        $this->_get     = @$_GET;
        $this->_post    = @$_POST;
        $this->_files   = @$_FILES;
        $this->_cookie  = @$_COOKIE;
        $this->_session = @$_SESSION;
        
        $this->parseRequest();
    }
    
    public function serverInfo($key = false)
    {
        if($key && array_key_exists($key, $_SERVER)) {
            return $_SERVER[$key];
        }
        return $_SERVER;
    }
    
    public function getControllerName()
    {
        return $this->_params[0];
    }
    
    public function getActionName()
    {
        return $this->_params[1];
    }
    
    private function parseRequest()
    {
        $request = $this->serverInfo('REQUEST_URI');
        $params = $this->clearArray(explode("/", $request));
        
        if(count($params) === 0) {
            $params = array('index', 'index');
        }
        $this->_params = $params;
        \Application\Core\Dump::log($this->_params);
    }
    
    private function clearArray( $array )
    {
        foreach ($array as $key => $value) {
            if($value == '') unset ($array[$key]);
        }
        sort($array);
        return $array;
    }
}
