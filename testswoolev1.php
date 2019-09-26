<?php
//---- test command-----
// wrk -t4 -c400 -d10s http://127.0.0.1:80
// ab -c 1000 -n 1000000 -k http://127.0.0.1:80/

/**
 *swoole\server(tcpip/udp)-->Http(web)->websocker
 */
// use swoole_websocket_server as SwooleWebSocketServer;
use swoole_websocket_server as SwooleWebSocketServer;

class HttpServer
{
    public $serv;
    protected $router = [];
    protected $port = 80;
    private $count = 0;
    protected $bindAddrss = "0.0.0.0";
    protected $static = [
        'css' => 'text/css',
        'js' => 'text/javascript',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpg',
        'mp4' => 'video/mp4',
    ];

    protected $pid_file = 'testsrv.pid';
    public function __construct()
    {
        $serv = new SwooleWebSocketServer($this->bindAddrss, $this->port, SWOOLE_PROCESS);
        $serv->set(
            [
                'worker_num' => 20, // จำนวน worker进程数
                'open_cpu_affinity' => 4, //จำนวน CPU亲和设置
                'daemonize' => false, //守护进程化
                'process_name' => 'test',
                'max_request' => 100000000, //进程的最大任务数
                'task_worker_num' => 20, //Task进程的数量
                'log_file' => 'swoole_log.log', //swoole错误日志文件
                'backlog' => 1024, //Listen队列长度
                'log_level' => 0, //0 => DEBUG (all) 1  =>TRACE  2  =>INFO 3  =>NOTICE  4  =>WARNING 5  =>ERROR
                'document_root' => __DIR__ . '/views',
                'enable_static_handler' => true,
                'mysql' => [
                    'host' => '127.0.0.1',
                    'user' => 'dbuser',
                    'password' => 'dbpass',
                    'database' => 'dbname',
                ],
            ]);
        $this->serv = $serv;
    }

    //route
    public function routes()
    {
        $this->add('/', function () {
            return 'ok' . $this->count;
        });
        $this->add('/a', [new FooController, 'bar']);
        $this->add('/mysql', [new FooController, 'testmysql']);
        $this->add('/chat', [$this, 'chatbox']);
    }

    /*---http server--
    start
    request
    ------------------*/

    /*--- tcpserver----
    connect
    receive
    error
    close
    ------------------*/

    /*---- websocker----
    open
    message
    receive
    handshake
    close
    ------------------*/

    /*---- Task -------
    receive
    task
    finish
    ------------------*/
    public function start()
    {
        $this->routes();
        $this->serv->addlistener("127.0.0.1", 9501, SWOOLE_SOCK_TCP);
        $this->serv->addlistener("127.0.0.1", 9502, SWOOLE_SOCK_TCP);
        $this->serv->listen("127.0.0.1", 9503, SWOOLE_SOCK_TCP);

        $this->serv->on("start", [$this, 'onStart']); // server เริ่มทำงาน
        $this->serv->on("connect", [$this, "onConnect"]); // ได้รับร้องขอจาก client
        $this->serv->on("managerStart", [$this, "onManagerStart"]);
        $this->serv->on('workerStart', [$this, 'onWorkerStart']);
        $this->serv->on("workerStop", [$this, "onWorkerStop"]);
        $this->serv->on("request", [$this, 'onRequest']); //web http
        $this->serv->on("task", [$this, "onTask"]);

        $this->serv->on('open', [$this, 'onOpen']);
        $this->serv->on('message', [$this, 'onMessage']); //websocker
        $this->serv->on('receive', [$this, 'onReceive']); //websocker ได้รับข้อมูลจาก client
        $this->serv->on('handshake', [$this, 'onHandshake']); //websocker

        $this->serv->on("finish", [$this, "onFinish"]);
        $this->serv->on('shutdown', [$this, 'onShutdown']);
        $this->serv->on('close', [$this, 'onClose']); //websocker
        $this->serv->start();
    }

    public function onStart($server)
    {
        // echo __FUNCTION__, PHP_EOL;
        echo gettype($server->setting['task_worker_num']);
        echo PHP_EOL;
        echo "Swoole http server is started at ip: ", $server->host, ':', $server->port, PHP_EOL;
        echo 'include file = ', count(get_included_files()), PHP_EOL;
        printf("Master  PID: %d\n", $server->master_pid);
        printf("Manager PID: %d\n", $server->manager_pid);
        $file = $this->pid_file;
        file_put_contents($file, $server->master_pid);
        echo 'Swoole version: ', swoole_version(), PHP_EOL;

        echo 'IP: http://127.0.0.1:', $server->port, PHP_EOL;
        foreach (swoole_get_local_ip() as $ip) {
            echo 'IP: http://', $ip, ':', $server->port, PHP_EOL;
        }
    }

    /**
     * 监听连接进入事件
     * client连接成功后触发。
     * @param $serv
     * @param $fd
     */
    public function onConnect($serv, $fd, $from_id)
    {
        // echo __FUNCTION__, PHP_EOL;
        echo 'Date:' . date('Y-m-d H:i:s') . "\t swoole_server connect[" . $fd . "]\n";
        // $a = $serv->send($fd, "Hello {$fd}!");
        // var_dump($a); //成功返回true
    }

    /**
     * Server启动在主进程的主线程回调此函数
     * @param $serv
     */
    public function onManagerStart($server)
    {
        // echo __FUNCTION__, PHP_EOL;
        echo "swoole_server manager worker start\n";
        $this->setProcessName($server->setting['process_name'] . '-manager');
        // 引入SP入口文件
        // require_once dirname(__FILE__) . "/config/Bootstrap.php";
    }

    /**
     * worker start 加载业务脚本常驻内存
     * @param $server
     * @param $worker_id
     */
    public function onWorkerStart($server, $worker_id)
    {
        // echo __FUNCTION__, PHP_EOL;
        if ($worker_id >= $server->setting['task_worker_num']) {
            $this->setProcessName($server->setting['process_name'] . '-task');
        } else {
            $this->setProcessName($server->setting['process_name'] . '-event');
        }
        // echo "Start Worker:" . $worker_id, PHP_EOL;
    }

    /**
     * 当一个work进程死掉后，会触发
     * worker 进程停止
     * @param $server
     * @param $worker_id
     */
    public function onWorkerStop($serv, $worker_id)
    {
        // echo __FUNCTION__, PHP_EOL;
        echo 'Date:' . date('Y-m-d H:i:s') . "\t swoole_server[{$serv->setting['process_name']}  worker:{$worker_id} shutdown\n";
        echo 'Worker Stop:' . $worker_id, true, PHP_EOL;
    }

    public function onRequest($request, $response)
    {
        $count = $this->count++;
        $request->serv = $this->serv;
        /*----comment--------------------
        // echo __FUNCTION__, PHP_EOL;
        //------------- เรื่องเวลา------------------
        //interval 2000ms
        // $this->serv->tick(2000, function ($timer_id) {
        //     echo "tick-2000ms\n";
        // });

        //after 3000ms
        // $this->serv->after(3000, function () {
        //     echo "after 3000ms.\n";
        // });
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
        // //ip
        // $ip = $request->server['remote_addr'];
        // //数据库语句
        // $post = $request->post;
        // //时间
        // $date_time = date("Y-m-d H:i:s");
        // //投递一个异步的任务
        // $d = $this->serv->taskwait($post, 200);
         */
        if ($this->getStaticFile($request, $response, $this->static)) {
            return;
        }
        if ($request->server["path_info"] == "/favicon.ico") {
            return;
        }
        $this->execute($request, $response);

        // $response->header("Cache-Control", "no-cache, must-revalidate");
        // $response->header("Expires", "0");
        // $response->header('Content-Type', 'application/json');
        // $response->status(200);
        // $response->end('ok');

        // ob_start();
        // $result = ob_get_contents();
        // ob_end_clean();
        // $response->end($result);
    }

    /***
     * 用来处理任务
     * @param $serv
     * @param $task_id
     * @param $from_id
     * @param $data
     * @return string
     *
     */
    public function onTask(Swoole\Server $serv, $taskId, $fromId, $post)
    {
        // echo __FUNCTION__, PHP_EOL;
        return ["data" => $post, 'ret' => 1];
    }

    public function onOpen(\swoole_websocket_server $server, $request)
    {
        // echo __FUNCTION__, PHP_EOL;
        echo "server: handshake success with fd{$request->fd}\n";
    }

    public function onMessage($serv, $frame)
    {
        // echo __FUNCTION__, PHP_EOL;
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

    /**
     * 监听数据发送事件
     * 接收client发过来的请求
     * @param $serv
     * @param $fd
     * @param $from_id
     * @param $data
     */
    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        // echo __FUNCTION__, PHP_EOL;
        echo "Get Message From Client {$fd}:{$data}\n";
        $serv->send($fd, "Swoole: {$data}");
        $serv->send($fd, "hello, " . $from_id);
        $serv->close($fd);
        exit();

        echo "Get Message From Client {$fd}:{$data}\n";

        // if (!$this->_setting['daemonize']) {
        //     echo "Get Message From Client {$fd}:{$data}\n\n";
        // }
        // $result = json_decode($data, true);
        // switch ($result['action']) {
        //     case 'reload': //重启
        //         $serv->reload();
        //         break;
        //     case 'close': //关闭Server 关闭时
        //         $serv->shutdown();
        //         break;
        //     case 'status': //状态
        //         $serv->send($fd, json_encode($serv->stats()));
        //         break;
        //     default:
        //         $serv->task($data);
        //         break;
        // }
    }
    public function onHandshake(\swoole_http_request $request, \swoole_http_response $response)
    {
        // echo __FUNCTION__, PHP_EOL;

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

    /**
     * 监听连接Finish事件
     * @param $serv
     * @param $task_id
     * @param $data
     */
    public function onFinish(woole\Server $serv, $taskId, $data)
    {
        // echo __FUNCTION__, PHP_EOL;
        return $data;
    }

    public function onShutdown($server)
    {
        // echo __FUNCTION__, PHP_EOL;
        $file = $this->pid_file;
        unlink($file);
    }

    public function onClose($server, $fd)
    {
        // echo __FUNCTION__, PHP_EOL;
        echo "client {$fd} closed\n";
    }

    public function add($route, callable $callfunc)
    {
        $this->router[$route] = $callfunc;
    }

    public function execute($req, $rsp)
    {
        $i = $req->server["path_info"];
        echo 'pathinfo-->', $i, PHP_EOL;
        $obj = isset($this->router[$i]) ? $this->router[$i] : null;
        if ($obj) {
            $type = gettype($obj);
            switch ($type) {
                case 'array':
                    $obj[0]->req = $req;
                    break;
                case 'object':
                default:
                    break;
            }
            $rs = $obj();
            $rsp->end($rs);
        } else {
            $rsp->status(404);
            $rsp->end('404');
        }
    }

    private function getStaticFile(
        swoole_http_request $request,
        swoole_http_response $response,
        array $static
    ): bool {
        $staticFile = __DIR__ . $request->server['request_uri'];
        if (!file_exists($staticFile)) {
            return false;
        }
        $type = pathinfo($staticFile, PATHINFO_EXTENSION);
        if (!isset($static[$type])) {
            return false;
        }
        $response->header('Content-Type', $static[$type]);
        $response->sendfile($staticFile);
        return true;
    }

    /**
     * 设置swoole进程名称
     * @param string $name swoole进程名称
     */
    private function setProcessName($name)
    {
        // echo __FUNCTION__, PHP_EOL;
        if (function_exists('cli_set_process_title')) {
            cli_set_process_title($name);
        } else {
            if (function_exists('swoole_set_process_name')) {
                swoole_set_process_name($name);
            } else {
                trigger_error(__METHOD__ . " failed. require cli_set_process_title or swoole_set_process_name.");
            }
        }
    }

    public function aaa()
    {
        echo 'aaaa';
    }

    private function chatbox()
    {

        $html = <<<HTML
<div id="app">
  <button @click="disconnect" v-if="status === 'connected'">Disconnect</button>
  <button @click="connect" v-if="status === 'disconnected'">Connect</button> {{ status }}
  <br /><br />
  <div v-if="status === 'connected'">
    <form @submit.prevent="sendMessage" action="#">
      <input v-model="message"><button type="submit">Send Message</button>
    </form>
    <ul id="logs">
      <li v-for="log in logs" class="log">
        {{ log.event }}: {{ log.data }}
      </li>
    </ul>
  </div>
</div>
<script src="https://unpkg.com/vue"></script>
<script>

const app = new Vue({
  el: "#app",
  data: {
    message: "",
    logs: [],
    status: "disconnected"
  },
  methods: {
    connect() {
      this.socket = new WebSocket("ws://127.0.0.1:80");
      this.socket.onopen = () => {
        this.status = "connected";
        this.logs.push({ event: "Connected to", data: 'ws://127.0.0.1:80'})


        this.socket.onmessage = ({data}) => {
          this.logs.push({ event: "Recieved message", data });
        };
      };
    },
    disconnect() {
      this.socket.close();
      this.status = "disconnected";
      this.logs = [];
    },
    sendMessage(e) {
      this.socket.send(this.message);
    //   this.logs.push({ event: "Sent message", data: this.message });
      this.message = "";
    }
  }
});

</script>
HTML;
        return $html;

    }

}

class FooController
{
    public function bar()
    {
        return 'Hello Bar';
    }

    public function testmysql()
    {
        $mysql = new Swoole\Coroutine\MySQL();
        $mysql->connect($this->req->serv->setting['mysql']);
        $mysql->setDefer();
        // $mysql->query('select sleep(1)');
        $mysql->query('select * from test'); // สร้าง table เอง
        $mysql_res = $mysql->recv();
        return json_encode($mysql_res);
    }
}

$server = new HttpServer();
$server->start();