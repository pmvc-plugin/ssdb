<?php
namespace PMVC\PlugIn\ssdb;

class BaseSsdb implements \ArrayAccess
{

    protected $groupDb;
    public $db;

    public function __construct($db, $groupDb=null)
    {
        $this->db = $db;
        $this->groupDb = $groupDb;
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
        if (empty($this->groupDb)) {
            return;
        }
        return $this->db->hexists($this->groupDb, $k);
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
        if (empty($this->groupDb)) {
            return $arr;
        }
        if (is_null($k)) {
	    $arr = $this->db->hgetall($this->groupDb);
        } elseif (is_array($k)) { 
            $arr = $this->db->multi_hget($this->groupDb, $k);
        } else {
            $arr = $this->db->hget($this->groupDb, $k);
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
        if (empty($this->groupDb)) {
            return;
        }
        return $this->db->hset($this->groupDb,$k,$v);
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
        if (empty($this->groupDb)) {
            return;
        }
        return $this->db->hdel($this->groupDb, $k);
    }
}
