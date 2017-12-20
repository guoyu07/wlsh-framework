<?php
/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-16
 * Time: 下午1:38
 */
class TestClient{

    private $cli;
    private $url;

    public function __construct($url = null)
    {
        $this->url = $url ? $url:'/' ;
        $this->cli = new Swoole\Http\Client('127.0.0.1', 9501);

        $this->cli->setHeaders([
            'Host' => "localhost",
            "User-Agent" => 'Chrome/49.0.2587.3',
            'Accept' => 'text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding' => 'gzip',
        ]);
    }

    public function websocket() {
        $this->cli->on('message', function ($cli, $frame) {
            var_dump($frame->data);
        });

        $this->cli->upgrade("index.php/{$this->url}", function ($cli) {
            //echo $cli->body;
            $data['name'] = 'hello world';
            $data= json_encode($data);
            $cli->push($data);
        });

    }

    public function http() {
        $this->cli->get("index.php/{$this->url}", function ($cli) {
            //echo "Length: " . strlen($cli->body) . "\n";
            echo $cli->body;
            $cli->close();
        });

    }

}