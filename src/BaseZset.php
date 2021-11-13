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
        if (empty($this->modelId)) {
            return;
        }
        return $this->engine->zexists($this->modelId, $k);
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
        $arr = null;
        if (empty($this->modelId)) {
            return $arr;
        }
        if (is_null($k)) {
            $arr = $this->engine->zscan($this->modelId, '', '', '', 99999);
        } elseif (is_array($k)) {
            $arr = $this->engine->multi_zget($this->modelId, $k);
        } else {
            $arr = $this->engine->zget($this->modelId, $k);
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
        return $this->engine->zset($this->modelId, $k, $v);
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
        return $this->engine->zdel($this->modelId, $k);
    }
}
