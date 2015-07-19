<?php
namespace PMVC\PlugIn\ssdb;

class image extends BaseSsdb
{
     public $cache;

    /**
     * Get
     *
     * @param mixed $k key
     *
     * @return mixed 
     */
    public function &offsetGet($k=null)
    {
        $json=$this->db->get($k); 
        if(!empty($json)){
            $json = json_decode($json);
        }
        return $json;
    }

    /**
     * Set 
     *
     * @param mixed $k key
     * @param mixed $v value 
     *
     * @return bool 
     */
    public function offsetSet($k, $v=null)
    {
        $this->db->setx(
           $k,
           $v,
           $this->cache
        );
    }

    /**
     * Clean
     *
     * @param mixed $k key
     *
     * @return bool 
     */
    public function offsetUnset($k=null)
    {
        if (false===strpos($k,$this->groupDb)) {
            return false;
        }
        return $this->db->del($k);
    }
}
