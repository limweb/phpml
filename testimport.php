<?php
    include __DIR__.'/vendor/autoload.php';
    use \Curl\Curl; 

    $jsons = json_decode(file_get_contents(__DIR__.'/users.json'));
    $success = 0;
    $unsuccess = 0;
    $total = 0;
    dump('---import----- จำนวน:',count($jsons->RECORDS));    
    $result = [];
    foreach ($jsons->RECORDS as $key => $person) {
        dump('---log----import--',$total+1,'---id:',$person->registerID);

        $curl = new Curl();
        $curl->post('http://127.0.0.1:8000/upload',[
            "imgData"=>$person->imgProfile,
            "isUrl"=> true,
            "name"=>$person->userFullName,
            "ID"=>$person->registerID
        ]);

        if ($curl->error) {
            $gender =  null; 
            $descriptor = null;
            $isSuccessed = false;
        } else {
            if( gettype($curl->response) == 'object' ){
                $rs = $curl->response;
            } else {
                $rs = json_decode($curl->response);
            }
            $gender = isset($rs->gender) ? $rs->gender : null;
            $descriptor = isset($rs->descriptor) ? $rs->descriptor : null;
            $isSuccessed = isset($rs->isSuccessed) ? $rs->isSuccessed : null;
        }
        
        if( $isSuccessed ){
            $success++;
        }  else {
            $unsuccess++;
        }
        $total++;
        $o = new \stdClass();
        $o->name = $person->userFullName;
        $o->regid =$person->registerID;
        $o->gender = $gender;
        $o->picurl = $person->imgProfile;
        $o->picbase64 = '';
        $o->descriptor = $descriptor;
        $result[] = $o;
    }

    file_put_contents(__DIR__.'/testimpok.txt',json_encode($result));
    echo 'import successed',count($result);