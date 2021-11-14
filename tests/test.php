<?php

namespace PMVC\PlugIn\ssdb;

use PMVC\TestCase;

\PMVC\initPlugIn(['ssdb' => null], true);

class SsdbTest extends TestCase
{
    private $_plug = 'ssdb';

    private $_instance;

    function pmvc_setup()
    {
        \PMVC\unplug($this->_plug);
        $this->_instance = \PMVC\plug($this->_plug, [
            'ssdb' => new \stdClass(),
        ]);
    }

    function testPlugin()
    {
        ob_start();
        print_r($this->_instance);
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->_plug, $output);
    }

    function testGetModel()
    {
        $oPlug = $this->_instance;
        $oPlug->setConnected(true);
        $db = $oPlug->getModel('xxx');
        $this->haveString('xxx', print_r($db, true));
        $this->assertTrue(is_a($db, '\PMVC\PlugIn\ssdb\BaseSsdb'));
    }

    /**
     * @expectedException Exception
     */
    function testGetAll()
    {
        $fakeId = '999999';
        $fakeDb = new fakeSSDB($this->_instance, $fakeId);
        $fakeDb->size = 5000;
        $all = \PMVC\get($fakeDb);
        $this->assertTrue($fakeDb->getAll);
        $fakeDb->size = 5001;
        $this->willThrow(function () use($all, $fakeDb){
            $all = \PMVC\get($fakeDb);
        });
    }
}

class fakeSSDB extends BaseSsdb
{
    public $getAll = false;
    public $size = 0;
    function hsize()
    {
        return $this->size;
    }

    function hgetall()
    {
        $this->getAll = true;
    }
}
