<?php
/**
 * @name IndexController
 * @author hanhui
 * @desc 默认控制器
 */
use App\Models\Users;
class IndexController extends \Yaf\Controller_Abstract {

	public function indexAction($name = "Stranger") {

		$get = $this->getRequest()->getQuery("get", "default value");

		$this->getView()->assign("content", 'hanhui');
		$this->getView()->assign("name", $name);

		return true;

	}

    public function ceshiAction(){
        echo 'ceshi001';
        return false;
    }

	public function redisAction(){
	    $get = Yaf\Registry::get('redis')->get('key');
	    $this->getView()->assign("key", $get);
	    return true;
    }

    public function redisDBAction(){
        $get = Yaf\Registry::get('redis')->get('key');
        var_dump($get);
        return false;
    }



    /**
     *
     * @return bool
     */
    public function medooAction() {
        $get = Yaf\Registry::get('db')->get('users', ['id', 'name'], ['id'=>1]);
        var_dump($get);
        return false;
    }

    public function pdoAction() {
        $get = Yaf\Registry::get('db')->query("select * from `users` ")->fetchAll(PDO::FETCH_ASSOC);
        var_dump($get);
        return false;
    }

    public function myDBAction() {
        $get = Yaf\Registry::get('db')->query("select * from `users` where id=1 limit 1 ")->fetchAll(PDO::FETCH_ASSOC);
        var_dump($get);
        return false;
    }

    public function taskAction() {
        Yaf\Dispatcher::getInstance()->disableView();
        Yaf\Registry::get('http')->task('task');
    }

}
