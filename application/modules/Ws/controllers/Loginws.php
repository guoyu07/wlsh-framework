<?php
/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-22
 * Time: 下午3:48
 */

class LoginwsController extends Yaf\Controller_Abstract
{
    private $http;
    private $fd;
    private $data;
    public function init()
    {
        //todo 需要在调试模式下设置请求数据写入swoole日志中，用于实时查看调试数据。
        Yaf\Dispatcher::getInstance()->disableView();
        $this->http = Yaf\Registry::get('http');
        $this->fd = $this->getRequest()->getParam('fd');
        $this->data = $this->getRequest()->getParam('data');

    }

    /**
     * 由于yaf默认使用了addslashes函数过滤，所以这里最后需要一次stripcslashes函数
     */
    public function ceshiAction() {
        //$data = json_decode($this->data, true);
        if( $this->http->exist( $this->fd) )
            $this->http->push( $this->fd, stripcslashes(json_encode($this->data)) );
    }

}