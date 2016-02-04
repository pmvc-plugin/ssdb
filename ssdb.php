<?php
namespace PMVC\PlugIn\ssdb;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ssdb';
\PMVC\l(__DIR__.'/lib/SSDB.php');
\PMVC\l(__DIR__.'/src/BaseSsdb.php');
\PMVC\l(__DIR__.'/src/TempSsdb.php');

class ssdb extends \PMVC\PlugIn
{
    private $dbs;
    public function init()
    {
        if (empty($this['ssdb'])) {
            $get = \PMVC\plug('get');
            try {
                $ssdb = new \SimpleSSDB (
                    $get->get('SSDB_HOST'),
                    $get->get('SSDB_PORT')
                );
                $this['ssdb']=$ssdb;
            } catch (Exception $e) {
                \PMVC\log($e->getMessage());
                \PMVC\d($e->getMessage());
            }
        }
        $this->aliasForce = true;
        $this->setDefaultAlias($this['ssdb']);
    }

    /**
     * @param int    $id  group guid
     * @param string $key group key
     */
    public function getDb($id,$key=null)
    {
        if(empty($this->dbs[$id])){
            $path = __DIR__.'/src/dbs/'.$key.'.php';
            if (\PMVC\realpath($path)) {
                \PMVC\l($path);
                $class = __NAMESPACE__.'\\'.$key;
                if(class_exists($class)){
                    $this->dbs[$id] = new $class(
                        $this['this'],
                        $id 
                    );
                } else {
                    trigger_error($class .' not exists.');
                    return false;
                }
            } else {
                $this->dbs[$id] = new BaseSsdb(
                    $this['this'],
                    $id
                );
            }
        }
        return $this->dbs[$id];
    }
}
