<?php
namespace PMVC\PlugIn\ssdb\dbs;

use PMVC\PlugIn\ssdb\BaseTempSsdb;

class image extends BaseTempSsdb
{
     public function initKey($k)
     {
        if (false===strpos($k,$this->groupId)) {
            return false;
        }
        return $k;
     }
}
