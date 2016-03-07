<?php
namespace PMVC\PlugIn\ssdb\dbs;
use PMVC\PlugIn\ssdb\TempSsdb;

class image extends TempSsdb
{
     public function initKey($k)
     {
        if (false===strpos($k,$this->groupId)) {
            return false;
        }
        return $k;
     }
}
