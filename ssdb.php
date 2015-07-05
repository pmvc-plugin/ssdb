<?php
namespace PMVC\PlugIn\ssdb;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ssdb';
\PMVC\l(__DIR__.'/lib/SSDB.php');

class ssdb extends \PMVC\PlugIn
{
    public function init()
    {
        if (empty($this['ssdb'])) {
            try {
                $ssdb = new \SimpleSSDB (
                    getenv('SSDB_HOST'),
                    getenv('SSDB_PORT')
                );
                $this['ssdb']=$ssdb;
            } catch (Exception $e) {
                \PMVC\d($e->getMessage());
            }
        }
        $this->aliasForce = true;
        $this->setDefaultAlias($this['ssdb']);
    }
}
