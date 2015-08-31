<?php
namespace PMVC\PlugIn\ssdb;

class session extends BaseSsdb
{
     public $cache = 86400;

     public function initKey($k)
     {
        return $this->groupId.'_'.$k;
     }

    /**
     * ContainsKey
     *
     * @param string $k key 
     *
     * @return boolean
     */
    public function offsetExists($k)
    {
        $theKey = $this->initKey($k);
        return $this->db->exists($theKey);
    }

    /**
     * Get
     *
     * @param mixed $k key
     *
     * @return mixed 
     */
    public function offsetGet($k=null)
    {
        $theKey = $this->initKey($k);
        return $this->db->get($theKey); 
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
        $theKey = $this->initKey($k);
        $this->db->setx(
           $theKey,
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
        $theKey = $this->initKey($k);
        return $this->db->del($theKey);
    }
}
