<?php
namespace application\controller;

use core\Controller;
/**
 * Description of Index
 *
 * @author walk
 */
class Index extends Controller {

    public function name()
    {
        return self::class;
    }

    public function indexAction()
    {
        $this->render();
    }
    
    public function infoAction()
    {
        $this->render();
    }
}
