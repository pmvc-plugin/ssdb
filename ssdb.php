<?php
namespace PMVC\PlugIn\ssdb;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ssdb';

class ssdb extends \PMVC\PlugIn
{
    public function init()
    {
        if (!$this->get('ssdb')) {
            try {
                $ssdb = new \SSDB\SimpleClient(
                    getenv('SSDB_HOST'),
                    getenv('SSDB_PORT')
                );
                $this->set('ssdb', $ssdb);
            } catch (Exception $e) {
                \PMVC\log($e->getMessage());
            }
        }
        $this->setDefaultAlias($this->get('ssdb'));
    }
}
