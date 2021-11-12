<?php

namespace PMVC\PlugIn\ssdb;

use ArrayAccess;

class BaseSsdb implements ArrayAccess
{
    /**
     * Group ID
     */
    protected $modelId;
    /**
     * SSDB instance
     */
    public $engine;

    /**
     * Construct
     */
    public function __construct($ssdb, $modelId = null)
    {
        $this->engine = $ssdb;
        $this->modelId = $modelId;
    }

    /**
     * Super Call
     */
    public function __call($method, $args)
    {
        $func = [$this->engine, $method];
        if (is_callable($func)) {
            array_unshift($args, $this->modelId);
            return call_user_func_array($func, $args);
        }
    }

    /**
     * Really name in database table name
     */
    public function getTable()
    {
        return $this->modelId;
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
        if (empty($this->modelId)) {
            return;
        }
        return $this->engine->hexists($this->modelId, $k);
    }

    /**
     * Get
     *
     * @param mixed $k key
     *
     * @return mixed
     */
    public function &offsetGet($k = null)
    {
        $arr = false;
        if (empty($this->modelId)) {
            return $arr;
        }
        if (is_null($k)) {
            // hgetall sometimes will make ssdb crash
            $max = $this->engine['getAllMax'];
            $size = $this->hsize();
            if ($max >= $size) {
                $arr = $this->hgetall();
            } else {
                trigger_error(
                    'The db size: [' .
                        $size .
                        '] already over protected size [' .
                        $max .
                        ']. can\'t run getall automatically.'
                );
            }
            return $arr;
        } elseif (is_array($k)) {
            $arr = $this->engine->multi_hget($this->modelId, $k);
        } else {
            $arr = $this->engine->hget($this->modelId, $k);
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
    public function offsetSet($k, $v = null)
    {
        if (empty($this->modelId)) {
            return;
        }
        if (is_object($v) || is_array($v)) {
            return !trigger_error(
                'SSDB only support string: ' . var_export($v, true),
                E_USER_WARNING
            );
        }
        return $this->engine->hset($this->modelId, $k, $v);
    }

    /**
     * Clean
     *
     * @param mixed $k key
     *
     * @return bool
     */
    public function offsetUnset($k = null)
    {
        if (empty($this->modelId)) {
            return;
        }
        return $this->engine->hdel($this->modelId, $k);
    }
}
