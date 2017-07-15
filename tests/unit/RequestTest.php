<?php


class RequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $_GET['r'] = 'index/info';
    }

    protected function _after()
    {
    }

    // tests
    public function testGetRightController()
    {
        $request = new \Core\Request();

        $this->assertEquals('Index', $request->getControllerName());
    }

    public function testGetRightActionName()
    {
        $request = new \Core\Request();

        $this->assertEquals('infoAction', $request->getActionName());
    }
}