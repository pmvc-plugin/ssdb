<?php

namespace PMVC\PlugIn\ssdb;

use ArrayAccess;

class BaseSsdb implements ArrayAccess
{
    /**
     * Group ID
     */
    protected $groupId;
    /**
     * SSDB instance
     */
    public $db;

    /**
     * Construct
     */
    public function __construct($ssdb, $groupId=null)
    {
        $this->db = $ssdb;
        $this->groupId = $groupId;
    }

    /**
     * Super Call
     */
     public function __call($method, $args)
     {
         $func = array($this->db,$method);
         if (is_callable($func)) {
            array_unshift($args, $this->groupId);
            return call_user_func_array(
                $func,
                $args
            );
         }
     }

    /**
     * Really name in database table name
     */
     public function getTable()
     {
        return $this->groupId;
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
            // hgetall sometimes will make ssdb crash
            $max = $this->db['getAllMax'];
            $size = $this->hsize();
            if ($max >= $size) {
                $arr = $this->hgetall();
            } else {
                trigger_error(
                    'The db size: ['.
                    $size.
                    '] already over protected size ['.
                    $max.
                    ']. can\'t run getall automatically.'
                );
            }
            return $arr;
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
        if (is_object($v) || is_array($v)) {
            return !trigger_error(
                'SSDB only support string: '.
                    var_export($v,true),
                E_USER_WARNING
            );
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
