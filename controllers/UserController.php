<?php

use Servit\Restsrv\RestServer\RestController;

//----------------------------------------------
//FILE NAME:  UserController.php gen for Servit Framework Controller
//DATE:                 2019-01-20(Sun)  14:22:59
//----------------------------------------------
class UserController extends RestController
{

    /**
     *@noAuth
     *@url GET /test
     *----------------------------------------------
     *FILE NAME:  UserController.php gen for Servit Framework Controller
     *DATE:                 2019-01-20(Sun)  14:23:30

     *----------------------------------------------
     */
    public function index()
    {
        // ob_start();
        // echo 'routes:';
        // dump($this->server->routes());
        // echo 'this->server:';
        // dump($this->server);
        // echo 'this->input';
        // dump($this->input->sessions);
        // echo 'this->request:';
        // dump($this->request);
        // echo 'this->response:';
        // dump($this->response);
        // $result = ob_get_contents();
        // ob_end_clean();
        $result = '<h1>OK222</h1>';
        $rs = $this->swooledb->table('rounds')->get();
        // return $rs;
        $test = Test::get();
        $lots = Lot::get();
        return [$result, $lots, $rs, $test];
        // $this->response->end($result);

    }

    /**
     *@noAuth
     *@url GET /abc
     *----------------------------------------------
     *FILE NAME:  UserController.php gen for Servit Framework Controller
     *DATE:                 2019-02-01(Fri)  23:59:48

     *----------------------------------------------
     */
    public function abc()
    {
        try {
            $t = new TestService();
            $lots = Lot::get();
            // $accs = Account::get();
            // $accs = swooleEloquent\Db::table('lots')->limit(2)->get();
            return [
                //'ajax' => $ajax,
                //'page' => $page,
                //'perpage' => $perpage,
                //'skip' => $skip,
                //'total' => $total,
                //'count' => count($datas),
                //'datas' => $datas,
                //'columns' => $columns,
                //'info' => $info,
                //'infos' => $info,
                //'domains' => $domains,
                //'method' => $method,
                // 'accs' => json_encode($accs),
                'lots' => $lots,
                'test1' => TestService::test1(),
                'test2' => TestService::test2(),
                'test2' => $t->test2(),
                'status' => '1',
                'success' => true,
                'data' => 'abc',
                //'sql' => Capsule::getQueryLog(),
                'func' => __CLASS__ . '/' . __FUNCTION__,
            ];
        } catch (Exception $e) {
            return [
                'status' => '0',
                'success' => false,
                'msg' => $e->getMessage(),
                'func' => __CLASS__ . '/' . __FUNCTION__,
            ];
        }
    }

}
