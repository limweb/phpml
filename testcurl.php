<?php 
include __DIR__.'/vendor/autoload.php';
use \Curl\Curl;
$curl = new Curl();
$curl->post('http://trainer:8000/upload',[
        "imgData"=>"https://walk.eventthai.com/assets/images/profile/6f567dff02b849bd8c542a27d5478009-avatar.jpg",
        "isUrl"=> true,
        "name"=>"BANYAT KHATNAK",
        "ID"=>"25233"
]);

$rs = json_decode($curl->response);
echo $rs->gender,PHP_EOL;
echo $rs->isSuccessed,PHP_EOL;
var_dump($rs);