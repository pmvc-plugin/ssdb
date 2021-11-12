<?php
namespace PMVC\PlugIn\ssdb;

class BaseTempSsdb extends BaseSsdb
{
     private $_ttl = 86400;

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
     public function setTTL($i)
     {
        $this->_ttl = $i;
     }

     /**
      * TTL
      * Get expire sec by key.
      */
      public function ttl($k)
      {
          $theKey = $this->initKey($k);
          $ssdb = $this->engine->ttl($theKey);
          return reset($ssdb);
      }

      /**
       * Set expire
       */
      public function setExpire($k, $sec)
      {
          $theKey = $this->initKey($k);
          $result = $this->engine->expire($theKey, $sec);
          return $result;
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
        return $this->engine->exists($theKey);
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
        $result = $this->engine->get($theKey);
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
        $this->engine->setx(
           $theKey,
           $v,
           $this->_ttl
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
        return $this->engine->del($theKey);
    }
}
