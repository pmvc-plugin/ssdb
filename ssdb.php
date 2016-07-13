<?php
namespace PMVC\PlugIn\ssdb;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ssdb';
\PMVC\l(__DIR__.'/lib/SSDB.php');
\PMVC\l(__DIR__.'/src/BaseSsdb.php');
\PMVC\l(__DIR__.'/src/BaseZset.php');
\PMVC\l(__DIR__.'/src/BaseTempSsdb.php');

class ssdb extends \IdOfThings\GetDb
{
    public function init()
    {
        if (empty($this['ssdb'])) {
            $get = \PMVC\plug('get');
            $host = $get->get('SSDB_HOST');
            if (empty($host)) {
                return;
            }
            try {
                $ssdb = new \SimpleSSDB (
                    $host,
                    $get->get('SSDB_PORT')
                );
                $this['ssdb']=$ssdb;
            } catch (Exception $e) {
                \PMVC\log($e->getMessage());
                \PMVC\d($e->getMessage());
            }
        }
        $this->setDefaultAlias($this['ssdb']);
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
