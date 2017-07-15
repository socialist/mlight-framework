<?php
namespace Application\Controller;

use Core\Controller;
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
