<?php
namespace PMVC\PlugIn\ssdb\models;

use PMVC\PlugIn\ssdb\BaseTempSsdb;

class image extends BaseTempSsdb
{
     public function initKey($k)
     {
        if (false===strpos($k,$this->modelId)) {
            return false;
        }
        return $k;
     }
}
