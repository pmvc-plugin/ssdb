<?php
namespace PMVC\PlugIn\ssdb;

class BaseSsdb implements \ArrayAccess
{
    /**
     * Group ID
     */
    protected $groupId;
    /**
     * SSDB instance
     */
    public $db;

    public function __construct($ssdb, $groupId=null)
    {
        $this->db = $ssdb;
        $this->groupId = $groupId;
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
        if (empty($this->groupId)) {
            return;
        }
        return $this->db->hexists($this->groupId, $k);
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
        $arr = false;
        if (empty($this->groupId)) {
            return $arr;
        }
        if (is_null($k)) {
	    $arr = $this->db->hgetall($this->groupId);
        } elseif (is_array($k)) { 
            $arr = $this->db->multi_hget($this->groupId, $k);
        } else {
            $arr = $this->db->hget($this->groupId, $k);
        }
        return $arr;
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
        if (empty($this->groupId)) {
            return;
        }
        return $this->db->hset($this->groupId,$k,$v);
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
        if (empty($this->groupId)) {
            return;
        }
        return $this->db->hdel($this->groupId, $k);
    }
}
