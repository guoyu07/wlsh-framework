<?php
/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-9
 * Time: 下午5:17
 */
class HttpServer{
    private $http;
    private $tcp;
    private $table;
    private $configFile;
    private $yafObj;
    protected static $instance = null;

    public static function getInstance() {
        if (empty(self::$instance) || !(self::$instance instanceof HttpServer)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
    }

    public function setConfigIni($configIni)
    {
        if (!is_file($configIni)) {
            trigger_error('Server Config File Not Exist!', E_USER_ERROR);
        }
        $this->configFile = $configIni;
    }

    public function start() {
        $this->http = new swoole_http_server('0.0.0.0', 9501);
        $this->http->set([
            'worker_num' => 16,
            'daemonize' => false,
            'max_request' => 300000,
            'dispatch_mode' => 2,
            'task_worker_num' => 16,
            'log_file' => ROOT_PATH . '/log/swoole.log',
            'heartbeat_check_interval' => 660,
            'heartbeat_idle_time' => 1200,
            //'ssl_cert_file' => '/tmp/ssl.crt',
            //'ssl_key_file' => '/tmp/ssl.key',
            //'open_http2_protocol' => true
        ]);

        $this->table = new swoole_table(1024);
        $this->table->column('name', swoole_table::TYPE_STRING, 128);
        $this->table->create();

        $this->http->on('start', [$this, 'onStart']);
        $this->http->on('managerStart', [$this, 'onManagerStart']);
        $this->http->on('workerStart', [$this, 'onWorkerStart']);
        $this->http->on('request', [$this, 'onRequest']);
        $this->http->on('task', [$this, 'onTask']);
        $this->http->on('close', [$this, 'onClose']);
        $this->http->on('finish', [$this, 'onFinish']);
        $this->http->start();
    }

    public function onStart($http) {
        echo "Swoole http server is started at http://127.0.0.1:9501\n";
        $myfile = fopen(ROOT_PATH . '/log/swoolePid.log', 'w');
        fwrite($myfile, json_encode(['masterPid'=>$http->master_pid]));
        fclose($myfile);
    }

    public function onManagerStart($http) {

    }

    public function onWorkerStart($http, $worker_id) {
        Yaf\Loader::import(ROOT_PATH . '/vendor/autoload.php');
        //实例化yaf
        $this->yafObj = new Yaf\Application($this->configFile);
        ob_start();
        $this->yafObj->bootstrap()->run();
        ob_end_clean();

        $redis = new Redis();
        $redis->connect(Yaf\Application::app()->getConfig()->cache->host, Yaf\Application::app()->getConfig()->cache->port);
        Yaf\Registry::set('redis', $redis);

        $database = new \Medoo\Medoo([
            'database_type' => Yaf\Application::app()->getConfig()->database->driver,
            'database_name' => Yaf\Application::app()->getConfig()->database->database,
            'server' => Yaf\Application::app()->getConfig()->database->host,
            //'socket' => '/var/run/mysqld/mysqld.sock',
            'username' => Yaf\Application::app()->getConfig()->database->username,
            'password' => Yaf\Application::app()->getConfig()->database->password,
            'charset' => Yaf\Application::app()->getConfig()->database->charset
        ]);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Yaf\Registry::set('db', $database);

    }

    public function onRequest($request, $response) {
        //请求过滤,会请求2次
        if(in_array('/favicon.ico', [$request->server['path_info'], $request->server['request_uri']])){
            return $response->end();
        }
        //注册全局信息
        Yaf\Registry::set('SWOOLE_HTTP_REQUEST', $request);
        Yaf\Registry::set('swoole_http_response', $response);
        Yaf\Registry::set('http', $this->http);

        $requestObj = new Yaf\Request\Http($request->server['request_uri']);
        ob_start();
        try {
            $this->yafObj->getDispatcher()->dispatch($requestObj);
        } catch (Yaf\Exception $e) {
            var_dump($e);
        }
        $result = ob_get_contents();
        ob_end_clean();
        $response->end($result);

        // Yaf\Registry::del('SWOOLE_HTTP_REQUEST');
        // Yaf\Registry::del('SWOOLE_HTTP_RESPONSE');
    }

    public function onTask($http, $task_id, $reactor_id, $data) {
        //$get = Yaf\Registry::get('db')->query("select * from `users` ")->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($get);
        //$get = Yaf\Registry::get('redis')->get('key');
        //echo $get;
       return true;


    }

    public function onClose($http, $fd) {
       // echo "client-{$fd} is closed" . PHP_EOL;
        //echo '==============='. date("Y-m-d H:i:s", time()). '欢送' . $fd . '离开==============' . PHP_EOL;
    }

    public function onFinish($http, $task_id, $data) {
       // Yaf\Registry::get('swoole_http_response')->end($data);
    }

}
