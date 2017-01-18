<?php

namespace PMVC\PlugIn\ssdb;

use PHPUnit_Framework_TestCase;

\PMVC\Load::plug();
\PMVC\addPlugInFolders(['../']);

\PMVC\initPlugIn(['ssdb'=>null]);

class SsdbTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'ssdb';

    private $_instance;

    function setup()
    {
        $this->_instance = \PMVC\plug(
            $this->_plug,
            [
                'ssdb'=>new \stdClass()
            ]
        );
    }

    function testPlugin()
    {
        ob_start();
        print_r($this->_instance);
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testGetDb()
    {
        $oPlug = $this->_instance;
        $oPlug->setConnected(true);
        $db = $oPlug->getDb('xxx');
        $this->assertContains('xxx',print_r($db,true));
        $this->assertTrue(is_a($db,'\PMVC\PlugIn\ssdb\BaseSsdb'));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    function testGetAll()
    {
        $fakeId = '999999';
        $fakeDb = new fakeSSDB(
            $this->_instance,
            $fakeId
        );
        $fakeDb->size = 5000;
        $all = \PMVC\get($fakeDb);
        $this->assertTrue($fakeDb->getAll);
        $fakeDb->size = 5001;
        $all = \PMVC\get($fakeDb);
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
