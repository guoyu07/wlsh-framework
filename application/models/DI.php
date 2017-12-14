<?php
/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-7
 * Time: 下午3:50
 */
namespace App\Models;

class DI
{
    static protected $arr;

    public function setInstance(string $name, $obj)
    {
       DI::$arr[$name] = $obj;
    }

    public function getInstance(string $name) {
       return DI::$arr[$name];
    }
}