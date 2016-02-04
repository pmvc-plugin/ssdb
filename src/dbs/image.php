<?php
namespace PMVC\PlugIn\ssdb;

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
