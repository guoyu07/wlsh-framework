<?php

/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author hanhui
 */
class ErrorController extends Yaf\Controller_Abstract
{

    //从2.1开始, errorAction支持直接通过参数获取异常
    public function errorAction($exception): bool
    {
        //1. assign to view engine
        echo 'Error Msg: ' . $exception->getMessage();
        //$this->getView()->assign("message", $exception->getMessage());
        //5. render by Yaf
        return false;
    }
}
