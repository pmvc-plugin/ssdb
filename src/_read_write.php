<?php

namespace PMVC\PlugIn\ssdb;

use SimpleSSDB;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ReadWriteAdapter';

class ReadWriteAdapter
{

    private $_read;
    private $_write;
    private $_same;

    private $_waction = [
        'set'=>1,
        'setx'=>1,
        'setnx'=>1,
        'expire'=>1,
        'del'=>1,
        'incr'=>1,
        'setbit'=>1,
        'multi_set'=>1,
        'multi_del'=>1,
        'hset'=>1,
        'hdel'=>1, 
        'hincr'=>1,
        'hclear'=>1,
        'multi_hset'=>1,
        'multi_hdel'=>1,
        'zset'=>1,
        'zdel'=>1,
        'zincr'=>1,
        'zclear'=>1,
        'zremrangebyrank'=>1,
        'zremrangebyscore'=>1,
        'zpop_front'=>1,
        'zpop_back'=>1,
        'qclear'=>1,
        'qset'=>1,
        'qpush'=>1,
        'qpush_front'=>1,
        'qpush_back'=>1,
        'qpop'=>1,
        'qpop_front'=>1,
        'qpop_back'=>1,
        'qtrim_front'=>1,
        'qtrim_back'=>1,
    ];

    public function __invoke($read, $write = null)
    {
        if (empty($read)) {
            return !trigger_error('Not set ssdb server. such as $this[readHost] or $this[writeHost]');
        }
        $this->_read = $this->_init_ssdb($read);
        if (empty($write)) {
            $this->_write = $this->_read;
            $this->_same = true;
        } else {
            $this->_write = $this->_init_ssdb($write);
            $this->_same = false;
        }
        return $this;
    }

    private function _init_ssdb($host)
    {
        $host = explode(':', $host);
        $ssdb = null;
        try {
            $ssdb = new SimpleSSDB (
                $host[0],
                $host[1] 
            );
        } catch (Exception $e) {
            trigger_error($e->getMessage());
        }
        return $ssdb;
    }

    public function __call($method, $args)
    {
        $func = $this->isCallable($method);
        if ($func) {
            return call_user_func_array(
                $func,
                $args
            );
        }
    }

    public function isCallable($method)
    {
        if (isset($this->_waction[$method])) {
            return [$this->_write, $method];
        } else {
            return [$this->_read, $method];
        }       
    }

    public function batch()
    {
        $this->_read->batch();
        if (!$this->_same) {
            $this->_write->batch();
        }
        return $this;
    }

    public function exec()
    {
        $result = $this->_read->exec();
        if (!$this->_same) {
            $result = [
                'read'=>$result,
                'write'=>$this->_write->exec()
            ];
        }
        return $result;
    }
}
