<?php
/**
 * @name Bootstrap
 * @author hanhui
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
use Yaf\Dispatcher;
class Bootstrap extends Yaf\Bootstrap_Abstract {
    private $config;

    public function _initLoader(){
      // Yaf\Loader::import(ROOT_PATH . '/vendor/autoload.php');
    }

    public function _initConfig() {
		//把配置保存起来
        $this->config = Yaf\Application::app()->getConfig();
		Yaf\Registry::set('config', $this->config);
	}

    /**
     * 日志
     * @param \Yaf\Dispatcher $dispatcher
     */
    public function _initLogger(Dispatcher $dispatcher)
    {
        //SocketLog
        if (Yaf\ENVIRON === 'develop') {
            if ($this->config->socketlog->enable) {
                //载入
                Yaf\Loader::import('Common/Logger/slog.function.php');
                //配置SocketLog
                slog($this->config->socketlog->toArray(),'config');
            }
        }
    }

    public function _initPlugin(Dispatcher $dispatcher) {
        //注册一个插件
        //$objSamplePlugin = new SamplePlugin();
        //$dispatcher->registerPlugin($objSamplePlugin);
    }

    public function _initRoute(Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
	}

    /**
     * LocalName
     */
    public function _initLocalName() {

    }

    /**
     * Twig View
     * @param \Yaf\Dispatcher $dispatcher
     */
    public function _initTwig(Dispatcher $dispatcher)
    {
        $twig = new Twig\Adapter(ROOT_PATH . "/application/views/",$this->config->get("twig")->toArray());
        $dispatcher::getInstance()->setView($twig);
    }

    //载入缓存类rEDIS
    public function _initCache()
    {

    }
    /**
     * 公用函数载入
     */
    public function _initFunction()
    {
        Yaf\Loader::import('Common/functions.php');
    }


}
