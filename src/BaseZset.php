<?php
namespace PMVC\PlugIn\ssdb;

class BaseZset extends BaseSsdb
{
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
        return $this->db->zexists($this->groupId, $k);
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
        $arr = null;
        if (empty($this->groupId)) {
            return $arr;
        }
        if (is_null($k)) {
	    $arr = $this->db->zscan($this->groupId, '', '', '', 99999);
        } elseif (is_array($k)) { 
            $arr = $this->db->multi_zget($this->groupId, $k);
        } else {
            $arr = $this->db->zget($this->groupId, $k);
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
        return $this->db->zset($this->groupId,$k,$v);
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
        return $this->db->zdel($this->groupId, $k);
    }
}
