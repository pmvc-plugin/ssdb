[![Latest Stable Version](https://poser.pugx.org/pmvc-plugin/ssdb/v/stable)](https://packagist.org/packages/pmvc-plugin/ssdb) 
[![Latest Unstable Version](https://poser.pugx.org/pmvc-plugin/ssdb/v/unstable)](https://packagist.org/packages/pmvc-plugin/ssdb) 
[![Build Status](https://travis-ci.org/pmvc-plugin/ssdb.svg?branch=master)](https://travis-ci.org/pmvc-plugin/ssdb)
[![License](https://poser.pugx.org/pmvc-plugin/ssdb/license)](https://packagist.org/packages/pmvc-plugin/ssdb)
[![Total Downloads](https://poser.pugx.org/pmvc-plugin/ssdb/downloads)](https://packagist.org/packages/pmvc-plugin/ssdb) 

PMVC SSDB Plugin 
===============
   * ssdb
      * https://github.com/ideawu/ssdb/tree/master/api/php
   * ssdb php api doc
      * http://ssdb.io/docs/zh_cn/php/

## Install with Composer
### 1. Download composer
   * mkdir test_folder
   * curl -sS https://getcomposer.org/installer | php

### 2. Install by composer.json or use command-line directly
#### 2.1 Install SSDB by adding a dependency to pmvc-plugin/ssdb to the require section of your project's composer.json configuration file. 
   * vim composer.json
```
{
    "require": {
        "pmvc-plugin/ssdb": "dev-master"
    }
}
```
   * php composer.phar install

#### 2.2 Or use composer command-line
   * php composer.phar require pmvc-plugin/ssdb


