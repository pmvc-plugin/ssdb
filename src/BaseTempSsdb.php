<?php
namespace PMVC\PlugIn\ssdb;

class BaseTempSsdb extends BaseSsdb
{
     private $_cache = 86400;

    /**
     * For composite key
     */
     public function initKey($k)
     {
        return $this->groupId.'_'.$k;
     }

     /**
      * Set Cache
      */
     public function setCache($i)
     {
        $this->_cache = $i;
     }

     /**
      * TTL
      * Get expire sec by key.
      */
      public function ttl($k)
      {
          $theKey = $this->initKey($k);
          $ssdb = $this->db->ttl($theKey);
          return reset($ssdb);
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
    public function &offsetGet($k=null)
    {
        $theKey = $this->initKey($k);
        $result = $this->db->get($theKey);
        return $result;
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
           $this->_cache
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
