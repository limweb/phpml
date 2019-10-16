<?php
// wrk -t4 -c400 -d10s http://127.0.0.1:80
// ab -c 1000 -n 1000000 -k http://127.0.0.1:80/
require './vendor/autoload.php';
use Swoole\Runtime;
use swoole_websocket_server as SwooleWebSocketServer;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
require_once __DIR__ . '/init.php';
$swooleconfig = require_once ROOTPATH . '/configs/swoole_config.php';

class HttpServer
{
    public $http;
    public $restserver;
    protected $port = 80;
    protected $bindAddrss = "0.0.0.0";
    protected $static = [
        'css' => 'text/css',
        'js' => 'text/javascript',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpg',
        'mp4' => 'video/mp4',
        'stream'=>'application/octet-stream',
        'json'=>'application/json',
    ];
    protected $swooledbconfig = [];

    protected $db;
    protected $pid_file = 'testsrv.pid';
    public function __construct()
    {
        require_once __DIR__ . '/configs/config.php';
        require_once __DIR__ . '/configs/sysmodels.php';
        $server = new \Servit\Restsrv\RestServer\RestnewServer($sysconfig, 'debug');
        $server->useCors = true;
        $server->includeDir(__DIR__ . '/models/');
        $server->includeDir(__DIR__ . '/services/'); // can add anather dir if you want
        $server->includeDir(__DIR__ . '/libs/'); // can add anather dir if you want
        if (SWOOLEMODE) {
            require_once __DIR__ . '/configs/swoole_dbconfig.php';
            $this->swooledbconfig = $swooledbconfig;
            Runtime::enableCoroutine();
            swoole_set_process_name("CrmMysqlServer");
            $server->includeDir(__DIR__ . '/swoolemodels/');
        }
        include __DIR__ . '/route/routes.php';
        $this->restserver = $server;

        $http = new SwooleWebSocketServer($this->bindAddrss, $this->port, SWOOLE_PROCESS);
        $http->set(
            array(
                'worker_num' => 4, //worker进程数
                'open_cpu_affinity' => 4, //CPU亲和设置
                'daemonize' => false, //守护进程化
                'max_request' => 10000, //进程的最大任务数
                'max_package_length' => 200000000,
                'task_worker_num' => 4, //Task进程的数量
                'log_file' => APP . '/log.log', //swoole错误日志文件
                'backlog' => 1024, //Listen队列长度
                'log_level' => 0, //0 => DEBUG (all) 1  =>TRACE  2  =>INFO 3  =>NOTICE  4  =>WARNING 5  =>ERROR
                'dbconfig' => $this->swooledbconfig,
                // 'http_parse_post' => false,
                'document_root' => __DIR__ . '/views',
                'upload_tmp_dir'=> __DIR__.'/upload_tmp',
                'enable_static_handler' => true,
            )
        );
        // $http->faces =json_decode(file_get_contents(__DIR__.'/faces.json'));
        $this->http = $http;
    }

    public function start()
    {
        $http = $this->http;
        $http->on("start", [$this, 'onStart']);
        $http->on("request", [$this, 'onRequest']);
        $http->on("task", array($this, "onTask"));
        $http->on('WorkerStart', array($this, 'onWorkerStart'));
        $http->on('open', function ($server, $request) {
        });
        $http->on('message', array($this, 'onMessage')); //websocker
        $http->on('receive', array($this, 'onReceive')); //websocker
        $http->on('handshake', array($this, 'onHandshake')); //websocker

        $http->on("finish", array($this, "onFinish"));
        $http->on('shutdown', [$this, 'onShutdown']);

        $http->start();
    }

    public function onMessage($serv, $frame)
    {
        echo __FUNCTION__, PHP_EOL;
        echo "receive from {$frame->fd}:{$frame->data}, opcode:{$frame->opcode}, fin:{$frame->finish}\n";
        $serv->push($frame->fd, "this is :{$frame->data}");

        $connections = $serv->connections;
        // echo '----connection--------';
        // var_dump($connections);
        // echo '----data--------';
        // var_dump($frame->data);
        // $sender = $data['sender'] ?? 0;

        foreach ($connections as $fd) {
            if ($serv->exist($fd) && $fd != $frame->fd) {
                $serv->push($fd, $frame->data, $frame->opcode);
            }
        }

    }

    public function onReceive($serv, $fd, $from_id, $data)
    {
        echo __FUNCTION__, PHP_EOL;
        echo "Get Message From Client {$fd}:{$data}\n";
        $serv->send($fd, "Swoole: {$data}");
        $serv->send($fd, "hello, " . $from_id);
        $serv->close($fd);
    }
    public function onHandshake(\swoole_http_request $request, \swoole_http_response $response)
    {
        echo __FUNCTION__, PHP_EOL;

        $secWebSocketKey = $request->header['sec-websocket-key'];
        $patten = '#^[+/0-9A-Za-z]{21}[AQgw]==$#';

        if (0 === preg_match($patten, $secWebSocketKey) || 16 !== strlen(base64_decode($secWebSocketKey))) {
            $response->end();
            return false;
        }

        echo $request->header['sec-websocket-key'];

        $key = base64_encode(sha1($request->header['sec-websocket-key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));

        $headers = [
            'Upgrade' => 'websocket',
            'Connection' => 'Upgrade',
            'Sec-WebSocket-Accept' => $key,
            'Sec-WebSocket-Version' => '13',
        ];

        // WebSocket connection to 'ws://127.0.0.1:9502/'
        // failed: Error during WebSocket handshake:
        // Response must not include 'Sec-WebSocket-Protocol' header if not present in request: websocket
        if (isset($request->header['sec-websocket-protocol'])) {
            $headers['Sec-WebSocket-Protocol'] = $request->header['sec-websocket-protocol'];
        }

        foreach ($headers as $key => $val) {
            $response->header($key, $val);
        }

        $response->status(101);
        $response->end();
        echo "connected!" . PHP_EOL;
        return true;
    }
    public function onStart($server)
    {
        echo "Swoole http server is started at http://", $server->host, ':', $server->port, PHP_EOL;
        echo 'include file = ', count(get_included_files()), PHP_EOL;
        printf("Master  PID: %d\n", $server->master_pid);
        printf("Manager PID: %d\n", $server->manager_pid);
        $file = $this->pid_file;
        file_put_contents($file, $server->master_pid);
    }

    public function onRequest($request, $response)
    {

        $redis = new Redis();    
        $redis->pconnect('redis','6379');
        $this->http->redis = $redis;

        if(!isset($this->http->faces)){
            $this->http->faces = [];
            // $this->http->faces = Face::get();
            // dump('----faces total---',$this->http->faces->count());
        }
        if(!isset($this->http->male)){
            $this->http->male = [];
            $redis->set('male', Face::where('gender','male')->get()->toJson());
            // $male =  json_decode($this->http->redis->get('male'));
            // dump('----male---',count($male));
        }
        if(!isset($this->http->female)){
            $this->http->female =[];
            $redis->set('female', Face::where('gender','female')->get()->toJson());
            // $female =  json_decode($this->http->redis->get('female'));
            // dump('----female---',count($female));
        }

        // \SwooleEloquent\Db::init($this->swooledbconfig);
        // $this->swooledb = new \SwooleEloquent\Db();
        // $accs = swooleEloquent\Db::table('rounds')->limit(112)->get();
        // $accs = $this->swooledb->table('rounds')->limit(2)->get();
        // $response->end($accs);

        // dump($request->server, $_SERVER);
        // $db = new \SwooleEloquent\Db();
        // $test = $db->select('select * from test');

        // $test = $db->table('test')->get();
        // $response->end(json_encode($test));
        // $test = $db->table('test')->first();
        // $db->disConnection();
        // $test = Test::get();
        // var_dump($this->DB);
        // //ip
        // $ip = $request->server['remote_addr'];
        // //数据库语句
        // $post = $request->post;
        // //时间
        // $date_time = date("Y-m-d H:i:s");
        // //投递一个异步的任务
        // $d = $this->http->taskwait($post, 200);
        
        if ($this->getStaticFile($request, $response, $this->static)) {
            return;
        }

        if ($request->server["path_info"] == "/favicon.ico") {
            return;
        }
        if( file_exists(__DIR__.'/views/'.$request->server["path_info"])){
            return;
        } 

        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        if ($request->server['request_method'] === 'OPTIONS') {
            $response->status(200);
            return false;
        }

        $this->restserver->handle($request, $response, $this->http, $this->swooledbconfig);
        $response->header("Cache-Control", "no-cache, must-revalidate");
        $response->header("Expires", "0");
        $response->header('Content-Type', $this->restserver->format);
        $response->status($this->restserver->getStatusCode());
        $response->end($this->restserver->getResult());
        // ob_start();
        // $result = ob_get_contents();
        // ob_end_clean();
        // $response->end($result);
    }

    public function onTask(Swoole\Server $serv, $taskId, $fromId, $post)
    {

        return array("data" => $post, 'ret' => 1);
    }

    public function onWorkerStart($server, $worker_id)
    {
        // var_dump(get_included_files());
    }
    public function onFinish(woole\Server $serv, $taskId, $data)
    {
        return $data;
    }

    private function getStaticFile(
        swoole_http_request $request,
        swoole_http_response $response,
        array $static
    ): bool {
        $staticFile = __DIR__ .'/views/'. $request->server['request_uri'];
        if (!file_exists($staticFile)) {
            return false;
        }
        $type = pathinfo($staticFile, PATHINFO_EXTENSION);

        if(!$type && file_exists($staticFile)){
            $type = 'stream';
        }

        if (!isset($static[$type])) {
            return false;
        }
        $response->header('Content-Type', $static[$type]);
        $response->sendfile($staticFile);
        return true;
    }

    public function onShutdown($server)
    {
        $file = $this->pid_file;
        unlink($file);
    }
}

$server = new HttpServer();
$server->start();
