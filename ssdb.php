<?php
namespace PMVC\PlugIn\ssdb;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ssdb';

class ssdb extends \PMVC\PlugIn
{
    public function init()
    {
        try {
            $ssdb = new SimpleSSDB(
                getenv('SSDB_HOST'),
                getenv('SSDB_PORT')
            );
            $this->setDefaultAlias($ssdb);
        } catch (Exception $e) {
            \PMVC\log($e->getMessage());
        }
    }
}
