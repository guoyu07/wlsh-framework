<?php
/**
 * @name IndexController
 * @author hanhui
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
use App\Models\Users;
class IndexController extends \Yaf\Controller_Abstract {

	/** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/YafUnit/index/index/index/name/hanhui 的时候, 你就会发现不同
     * http://localhost:81/public/index.php/index/index/index/name/hanhui
     */
	public function indexAction($name = "Stranger") {

		$get = $this->getRequest()->getQuery("get", "default value");

		$this->getView()->assign("content", 'hanhui');
		$this->getView()->assign("name", $name);

		return true;

	}

	public function redisAction(){
	    $get = Yaf\Registry::get('redis')->get('key');
	    $this->getView()->assign("key", $get);
	    return true;
    }

    public function ceshiAction(){
	    echo 'ceshi001';
	    return false;
    }

    public function myDBAction() {
        $get = Yaf\Registry::get('db')->get('users', ['id', 'name'], ['id'=>1]);
        //echo 321;
        //$get = Yaf\Registry::get('db')->query("select * from `users` ")->fetchAll(PDO::FETCH_ASSOC);

        var_dump($get);
        return false;
    }

    public function taskAction() {
        Yaf\Dispatcher::getInstance()->disableView();
        Yaf\Registry::get('http')->task('task');
    }



}
