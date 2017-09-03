<?php

namespace PMVC\PlugIn\ssdb;

use IdOfThings\GetDb;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ssdb';
\PMVC\l(__DIR__.'/lib/SSDB.php');
\PMVC\l(__DIR__.'/src/BaseSsdb.php');
\PMVC\l(__DIR__.'/src/BaseZset.php');
\PMVC\l(__DIR__.'/src/BaseTempSsdb.php');

class ssdb extends GetDb
{
    public function init()
    {
        if (empty($this['ssdb'])) {
            $this->initSSDB();
        }
        if (!isset($this['getAllMax'])) {
            $this['getAllMax'] = 5000;
        }
    }

    public function initSSDB($readHost=null, $writeHost=null)
    {
        if (empty($readHost)) {
            $readHost = $this['readHost'];
        }
        if (empty($writeHost)) {
            $writeHost = $this['writeHost'];
        }
        try {
            $ssdb = $this->read_write($readHost, $writeHost); 
            $this->setDefaultAlias($ssdb);
            $this->setConnected(true);
            $this['ssdb']=$ssdb;
        } catch (Exception $e) {
            trigger_error($e->getMessage());
        }
    }

    public function getBaseDb()
    {
        return __NAMESPACE__.'\BaseSsdb';
    }

    public function getNameSpace()
    {
        return __NAMESPACE__;
    }
}
