<?php
PMVC\Load::plug();
PMVC\setPlugInFolder('../');
class SsdbTest extends PHPUnit_Framework_TestCase
{
    function testPlugin()
    {
        ob_start();
        $plug = 'ssdb';
        print_r(PMVC\plug($plug,array('ssdb'=>new stdClass())));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($plug,$output);
    }
}
