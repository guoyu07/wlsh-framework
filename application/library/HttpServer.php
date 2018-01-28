<?php

/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-9
 * Time: 下午5:17
 */
class HttpServer
{
    private $http;
    private $tcp;
    private $table;
    private $configFile;
    private $yafObj;
    protected static $instance = null;

    public static function getInstance()
    {
        if (empty(self::$instance) || !(self::$instance instanceof HttpServer)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    public function setConfigIni($configIni)
    {
        if (!is_file($configIni)) {
            trigger_error('Server Config File Not Exist!', E_USER_ERROR);
        }
        $this->configFile = $configIni;
    }

    public function start()
    {
        $this->http = new Swoole\WebSocket\Server('0.0.0.0', 9501);
        $this->http->set([
            'worker_num' => 16,
            'daemonize' => false,
            'max_request' => 300000,
            'max_coro_num' => 100000,
            'dispatch_mode' => 2,
            'task_worker_num' => 16,
            'log_file' => ROOT_PATH . '/log/swoole.log',
            'heartbeat_check_interval' => 660,
            'heartbeat_idle_time' => 1200,
            'trace_event_worker' => true,
            'request_slowlog_timeout' => 1,
            'request_slowlog_file' => ROOT_PATH . '/log/slow.log',
            //'ssl_cert_file' => '/tmp/ssl.crt',
            //'ssl_key_file' => '/tmp/ssl.key',
            //'open_http2_protocol' => true
        ]);

        $this->table = new Swoole\Table(1024);
        $this->table->column('name', Swoole\Table::TYPE_STRING, 128);
        $this->table->create();

        $this->http->on('start', [$this, 'onStart']);
        $this->http->on('managerStart', [$this, 'onManagerStart']);
        $this->http->on('workerStart', [$this, 'onWorkerStart']);
        $this->http->on('open', [$this, 'onOpen']);
        $this->http->on('message', [$this, 'onMessage']);
        $this->http->on('request', [$this, 'onRequest']);
        $this->http->on('task', [$this, 'onTask']);
        $this->http->on('close', [$this, 'onClose']);
        $this->http->on('finish', [$this, 'onFinish']);
        $this->http->start();
    }

    public function onStart(Swoole\WebSocket\Server $http)
    {
        echo "Swoole http server is started at http://127.0.0.1:9501\n";
        $myfile = fopen(ROOT_PATH . '/log/swoolePid.log', 'w');
        fwrite($myfile, json_encode(['masterPid' => $http->master_pid]));
        fclose($myfile);
    }

    public function onManagerStart(Swoole\WebSocket\Server $http)
    {

    }

    public function onWorkerStart(Swoole\WebSocket\Server $http, $worker_id)
    {
        if ($http->taskworker) {
            swoole_set_process_name('taskProcess');
        } else {
            swoole_set_process_name('workerProcess');
        }
        //var_dump(get_included_files()); //此数组中的文件表示进程启动前就加载了，所以无法reload
        Yaf\Loader::import(ROOT_PATH . '/vendor/autoload.php');

        //实例化yaf
        $this->yafObj = new Yaf\Application($this->configFile, ini_get('yaf.environ'));
        ob_start();
        $this->yafObj->bootstrap()->run();
        ob_end_clean();

        Yaf\Registry::set('http', $http);

        //添加log日志模块,使用ini_get获取yaf配置节，达到动态分类显示日志，如：开发环境日志，测试环境日志，生产环境日志等
        $log = new Monolog\Logger(ini_get('yaf.environ'));
        $log->pushHandler(new Monolog\Handler\StreamHandler(ROOT_PATH . '/log/swoole.log', Monolog\Logger::DEBUG));
        Yaf\Registry::set('log', $log);

        //添加redis连接池
        $redis = new Redis();
        $redis->connect(Yaf\Application::app()->getConfig()->cache->host, Yaf\Application::app()->getConfig()->cache->port);
        Yaf\Registry::set('redis', $redis);

        //添加mysql数据库连接池
        $database = new \Medoo\Medoo([
            'database_type' => Yaf\Application::app()->getConfig()->database->driver,
            'database_name' => Yaf\Application::app()->getConfig()->database->database,
            'server' => Yaf\Application::app()->getConfig()->database->host,
            //'socket' => '/var/run/mysqld/mysqld.sock',
            'username' => Yaf\Application::app()->getConfig()->database->username,
            'password' => Yaf\Application::app()->getConfig()->database->password,
            'charset' => Yaf\Application::app()->getConfig()->database->charset,
            'port' => Yaf\Application::app()->getConfig()->database->port,
            'prefix' => Yaf\Application::app()->getConfig()->database->prefix,
            'logging' => true,
            'option' => [
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                //PDO::ATTR_PERSISTENT => true
            ],
            'command' => [
                'SET SQL_MODE=ANSI_QUOTES'
            ]
        ]);
        Yaf\Registry::set('db', $database);


    }

    //todo 待实现websocket连接token安全认证
    public function onOpen(Swoole\WebSocket\Server $http, Swoole\Http\Request $request)
    {
        echo '===============' . date("Y-m-d H:i:s", time()) . '欢迎' . $request->fd . '进入==============' . PHP_EOL;
    }

    //todo 待试验用param参数实现快速回复发送人与广播所有人用table功能对比
    //实现websocket路由转接
    public function onMessage(Swoole\WebSocket\Server $http, Swoole\WebSocket\Frame $frame)
    {
        $data = json_decode($frame->data, true);
        $result = [];
        $result['fd'] = $frame->fd;
        $result['data'] = $frame->data;

        $requestObj = new Yaf\Request\Http($data['uri'], '/');
        var_dump($result);
        $requestObj->setParam($result);

        ob_start();
        try {
            $this->yafObj->getDispatcher()->dispatch($requestObj);
        } catch (Yaf\Exception $e) {
            var_dump($e);
        }
        ob_end_clean();

    }

    public function onRequest(Swoole\Http\Request $request, Swoole\Http\Response $response)
    {
        //请求过滤,会请求2次
        if (in_array('/favicon.ico', [$request->server['path_info'], $request->server['request_uri']])) {
            return $response->end();
        }

        //todo 这里需要过滤掉ws模块与tcp模块
        $path_info = explode('/', $request->server['path_info']);
        if (isset($path_info[1]) && !empty($path_info[1])) {
            if (lcfirst($path_info[1]) == 'ws') {
                $response->status(404);
                return $response->end('404 Not Found');
            }
        }

        //注册全局信息
        Yaf\Registry::set('request', $request);
        Yaf\Registry::set('response', $response);

        $requestObj = new Yaf\Request\Http($request->server['request_uri'], '/');

        ob_start();
        try {
            $this->yafObj->getDispatcher()->dispatch($requestObj);
        } catch (Yaf\Exception $e) {
            var_dump($e->getMessage());
            $response->status(404);
        }
        $result = ob_get_contents();
        ob_end_clean();

        $response->end($result);

        //todo 这里还需要测试每一个客户端请求进来时会不会造成内存溢出
        // Yaf\Registry::del('request');
        // Yaf\Registry::del('response');
        // Yaf\Registry::del('http');
    }

    /**
     * http协议中使用task方法,只限用于在worker操作方法中调用task时不依赖task方法返回的结果,如:redis,mysql等插入操作且不需返回插入后的状态.
     * websocket协议中用task方法,可直接在task方法中调用push方法返回数据给客户端,这样swoole服务模式就变为worker中方法是
     * 异步到task方法中同步执行模式,worker中可更多地处理请求以提高websocket服务器性能.
     * @param $http
     * @param $task_id
     * @param $src_worker_id
     * @param $data
     * @return bool
     */
    public function onTask(Swoole\WebSocket\Server $http, $task_id, $worker_id, $data)
    {
        //$get = Yaf\Registry::get('redis')->get('key');
        //echo $get;
        $result = Yaf\Registry::get('db')->query("select * from `users` where id=1 limit 1 ")->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($result);

    }

    public function onClose(Swoole\WebSocket\Server $http, $fd)
    {
        // echo "client-{$fd} is closed" . PHP_EOL;
        //echo '==============='. date("Y-m-d H:i:s", time()). '欢送' . $fd . '离开==============' . PHP_EOL;
    }

    public function onFinish(Swoole\WebSocket\Server $http, $task_id, $data)
    {
        // Yaf\Registry::get('swoole_http_response')->end($data);
    }

    //todo 增加inotify修改文件可即时生效

}
