<?php
namespace PMVC\PlugIn\ssdb;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ssdb';
\PMVC\l(__DIR__.'/lib/SSDB.php');
\PMVC\l(__DIR__.'/src/BaseSsdb.php');

class ssdb extends \PMVC\PlugIn
{
    private $dbs;
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

    public function getDb($db,$key=null)
    {
        if(empty($this->dbs[$db])){
            $path = __DIR__.'/src/dbs/'.$key.'.php';
            if (\PMVC\realpath($path)) {
                \PMVC\l($path);
                $class = __NAMESPACE__.'\\'.$key;
                if(class_exists($class)){
                    $this->dbs[$db] = new $class(
                        $this,
                        $db 
                    );
                } else {
                    trigger_error($class .' not exists.');
                    return false;
                }
            } else {
                $this->dbs[$db] = new BaseSsdb(
                    $this,
                    $db
                );
            }
        }
        return $this->dbs[$db];
    }
}
