<?php
/**
 * @name IndexController
 * @author hanhui
 * @desc 默认控制器
 */

use App\Models\Users;

class IndexController extends \Yaf\Controller_Abstract
{

    public function indexAction($name = "Stranger")
    {

        $get = $this->getRequest()->getQuery("get", "default value");

        $this->getView()->assign("content", 'hanhui');
        $this->getView()->assign("name", $name);

        return true;

    }

    /**
     * 这里测试的两种状态方法，可以互补。
     * swoole中的request方法可以获取到header、server、cookie等信息
     * yaf中的request方法可以更容易直观地获取到写业务逻辑时所需要的module、controller、method、params等信息
     * 注意这里先设置了swoole http响应404状态，但在客户端会先打印输出的信息再把响应的状态变为404。
     * @return bool
     */
    public function ceshiAction()
    {
        var_dump(Yaf\Registry::get('request')) . PHP_EOL;
        var_dump($this->getRequest()) . PHP_EOL;

        var_dump(Yaf\Registry::get('response')) . PHP_EOL;
        var_dump($this->getResponse()) . PHP_EOL;

        echo 'index ceshi';
        return false;
    }

    public function redisAction()
    {
        $get = Yaf\Registry::get('redis')->get('key');
        $this->getView()->assign("key", $get);
        return true;
    }

    public function redisDBAction()
    {
        $get = Yaf\Registry::get('redis')->get('key');
        var_dump($get);
        return false;
    }


    /**
     *
     * @return bool
     */
    public function medooAction()
    {
        $get = Yaf\Registry::get('db')->get('users', ['id', 'name'], ['id' => 1]);
        var_dump($get);
        return false;
    }

    public function pdoAction()
    {
        $get = Yaf\Registry::get('db')->query("select * from `users` ")->fetchAll(PDO::FETCH_ASSOC);
        var_dump($get);
        return false;
    }

    public function myDBAction()
    {
        $get = Yaf\Registry::get('db')->query("select * from `users` where id=1 limit 1 ")->fetchAll(PDO::FETCH_ASSOC);
        var_dump($get);
        return false;
    }

    public function mysqlAction()
    {
        $get = Yaf\Registry::get('db')->query("select * from `users` where id=1 limit 1 ")->fetchAll(PDO::FETCH_ASSOC);
        echo 'mysql';
        //todo 需要测试用task保存日志
        Yaf\Registry::get('log')->info('mysql data:', $get);
        return false;
    }

    public function coTcpClientAction()
    {

        return false;
    }

    public function taskAction()
    {
        Yaf\Dispatcher::getInstance()->disableView();
        Yaf\Registry::get('http')->task('task');
    }

}
