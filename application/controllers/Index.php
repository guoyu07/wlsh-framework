<?php
/**
 * @name IndexController
 * @author hanhui
 * @desc 默认控制器
 */

use App\Models\Users;

/**
 * Class IndexController
 *
 */
class IndexController extends Yaf\Controller_Abstract
{
    /**
     * @var Swoole\Http\Response
     */
    private $response;

    /**
     * @var Redis
     */
    private $redis;

    /**
     * @var Medoo\Medoo
     */
    private $db;

    public function init()
    {
        $this->response = Yaf\Registry::get('response');
        $this->redis    = Yaf\Registry::get('redis');
        $this->db       = Yaf\Registry::get('db');

    }

    public function indexAction(?string $name = "Stranger"): bool
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
     * 且yaf获取get,post参数时设置了安全过滤
     * @return bool
     */
    public function ceshiAction(): bool
    {
       // var_dump(Yaf\Registry::get('request')->get['hanhui']) . PHP_EOL;
       // var_dump($this->getRequest()->getParam('hanhui')) . PHP_EOL;

        //var_dump(Yaf\Registry::get('response')) . PHP_EOL;
        //var_dump($this->getResponse()) . PHP_EOL;

        echo 'index "hh" ceshi';
        return false;
    }

    public function redisAction(): bool
    {
        $get = $this->redis->get('key');
        $this->getView()->assign("key", $get);
        return true;
    }

    public function redisDBAction(): bool
    {
        $get = $this->redis->get('key');
        var_dump($get);
        return false;
    }


    /**
     *
     * @return bool
     */
    public function medooAction(): bool
    {
        $get = $this->db->get('users', ['id', 'name'], ['id' => 1]);
        var_dump($get);
        return false;
    }

    public function pdoAction(): bool
    {
        $get = $this->db->query("select * from `users` ")->fetchAll(PDO::FETCH_ASSOC);
        var_dump($get);
        return false;
    }

    /**
     * 由于Swoole\Http\Responser负责响应输出，所以wlsh框架中Yaf\Response\Http等此类中一些设置方法无效。
     * @return bool
     */
    public function myDBAction(): bool
    {
        $get = $this->db->query("select * from `users` where id=1 limit 1 ")->fetchAll(PDO::FETCH_ASSOC);
        $this->response->header('Content-Type', 'application/json;charset=utf-8');
        //(new \Yaf\Response\Http())->setHeader('Content-Type', 'application/json;charset=utf-8');
        echo json_encode($get);
        return false;
    }

    public function pgDBAction(): bool
    {
        $get = Yaf\Registry::get('pg')->query("select * from users where id=1")->fetchAll(PDO::FETCH_ASSOC);
        $this->response->header('Content-Type', 'application/json;charset=utf-8');
        //(new \Yaf\Response\Http())->setHeader('Content-Type', 'application/json;charset=utf-8');
        echo json_encode($get);
        return false;
    }

    public function mysqlAction(): bool
    {
        $get = $this->db->query("select * from `users` where id=1 limit 1 ")->fetchAll(PDO::FETCH_ASSOC);
        echo 'mysql';
        //todo 需要测试用task保存日志
        Yaf\Registry::get('log')->info('mysql data:', $get);
        return false;
    }

    public function coTcpClientAction(): bool
    {
        echo getmygid() . PHP_EOL;
        echo getmyuid() . PHP_EOL;
        echo getmyinode() . PHP_EOL;
        echo getmypid() . PHP_EOL;
        sleep(3);
        return false;
    }

    public function taskAction()
    {
        Yaf\Dispatcher::getInstance()->disableView();
        $result = Yaf\Registry::get('http')->taskwait('task');
        echo $result;
        return false;
    }

    public function opcacheAction(): bool
    {
        $this->response->header('Content-Type', 'text/html;charset=utf-8');
        $this->response->status(404);
        //var_dump(opcache_get_status());
        var_dump(opcache_get_status()['opcache_statistics']);
        return false;

    }

    public function setCookAction()
    {
        $this->response->cookie("csa", 'csvalue');
        echo 'set cookie';
        return false;
    }

}
