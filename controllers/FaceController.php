<?php

//----------------------------------------------
//FILE NAME:  FaceController.php gen for Servit Framework Controller
//DATE: 2019-09-26(Thu)  17:47:31 

//----------------------------------------------
use	\Servit\Restsrv\RestServer\RestException;
use	\Servit\Restsrv\RestServer\RestController as BaseController;
use	Illuminate\Database\Capsule\Manager as Capsule;
use	Servit\Restsrv\Libs\Request; 
use	Servit\Restsrv\Libs\Linenotify;
use	Carbon\Carbon;
use \Servit\Restsrv\traits\DbTrait;
use \Curl\Curl;

class FaceController  extends BaseController {
    
    
    /**
    *@noAuth
    *@url GET /testface
    *@url POST /testface
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *DATE:  2019-09-26(Thu)  17:54:50 
    
    *----------------------------------------------
    */
    public function testface(){
        try {
            // dump('ok',count($this->http->faces));
            $gender = isset($_POST->gender) ? $_POST->gender : '';
            $qryface = isset($_POST->queryFace) ? json_decode(json_encode($_POST->queryFace),true) : '';
            $rs = [];
            if($qryface){
                // dump('count->http->faces:',count($this->http->faces));
                // $f = new Face();
                // $f->name = 'Thongchai Lim';
                // $f->regid = '';
                // $f->category = '';
                // $f->gender = "male";
                // $f->picurl = '';
                // $f->picbase64 = '';
                // $f->descriptor = $qryface;
                // $f->save();

                // foreach($this->http->faces as $k=> $people){ //แยกคน
                //     // dump('name--->'.$people->name);
                //     // dump('name--->'.$people->descriptor);
                //     // $faces = json_decode($people->descriptors,true); // ข้อมูลหน้า
                //     $faces = $people->descriptor; // ข้อมูลหน้า
                //     // dump('faces--->',$faces);
                //     $sum = 0;
                //     if($faces){
                //         foreach($faces as $key=>$val)  {
                //             $sum += pow($val-$qryface[$key],2);
                ;
                //         }
                //         $result = sqrt($sum);
                //         // dump('result-->',$result);
                //         if($result < 0.4){
                //             $rs[$k] = $result;
                //         }
                //     }
                // }

                if($gender == 'male'){
                    foreach($this->http->male as $k=> $people){ //แยกคน
                            $faces = $people->descriptor; // ข้อมูลหน้า
                            $sum = 0;
                            if($faces){
                                foreach($faces as $key=>$val)  {
                                    $sum += pow($val-$qryface[$key],2);
                                }
                                $result = sqrt($sum);
                                if($result < 0.4){
                                    $rs[$k] = $result;
                                }
                            }
                        }
                }

                if($gender == 'female'){
                   foreach($this->http->female as $k=> $people){ //แยกคน
                            $faces = $people->descriptor; // ข้อมูลหน้า
                            $sum = 0;
                            if($faces){
                                foreach($faces as $key=>$val)  {
                                    $sum += pow($val-$qryface[$key],2);
                                }
                                $result = sqrt($sum);
                                if($result < 0.4){
                                    $rs[$k] = $result;
                                }
                            }
                        }
                }

            }
            $o= new stdClass();
            if(count($rs)>0){
                $a = array_values($rs);
                $min = min($a);
                $index = array_search($min, $rs,true);
                $p = $this->http->faces[$index];
                $o->name = $p->name;
                $o->distinc = $min;
                $o->id = $p->id;
                $o->idx = $index;
            } else {
                $o->name = '';
                $o->distinc = '';
                $o->id = '';
                $o->idx = '';
            }
            return [$o];
        } catch (Exception $e) {
            return[
                'status' => '0',
                'success'=> false,
                'msg'=> $e->getMessage(),
            ]; 
        }
    }


    
    /**
    *@noAuth
    *@url GET /allfaces
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *DATE:  2019-09-27(Fri)  14:38:45 
    
    *----------------------------------------------
    */
    public function allfaces(){
        try {
            $male = Face::whereGender('male')->whereNotNull('descriptor')->get();
            $female = Face::whereGender('female')->whereNotNull('descriptor')->get();
            return [
                'datas' => ['male'=>$male,'female'=>$female],
                'status' => '1',
                'success'=> true,
            ];
        } catch (Exception $e) {
            return[
                'status' => '0',
                'success'=> false,
                'msg'=> $e->getMessage(),
            ]; 
        }
    }
    
    
    
    /**
    *@noAuth
    *@url POST /imports
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *DATE:  2019-09-27(Fri)  15:25:53 
    *----------------------------------------------
    */
    public function imports(){
        try {
            $desc = $_POST['description'];
            // dump('----post------',$_FILES['fileimport']['tmp_name'],$desc);
            $jsons = json_decode(file_get_contents($_FILES['fileimport']['tmp_name']));
            // dump($jsons);
            $imp = new Import();
            $imp->desc = $desc;
            $success = 0;
            $unsuccess = 0;
            $total = 0;
            $imp->save();
            dump('---import-----',$desc,' จำนวน:',count($jsons->RECORDS));    
            foreach ($jsons->RECORDS as $key => $person) {
                dump('---log----import--',$total+1,'---id:',$person->registerID);

                $curl = new Curl();
                $curl->post('http://trainer:8000/upload',[
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
                $f = new Face();
                $f->name = $person->userFullName;
                $f->regid =$person->registerID;
                $f->category = $imp->desc;
                $f->gender = $gender;
                $f->picurl = $person->imgProfile;
                $f->import_id = $imp->id;
                $f->picbase64 = '';
                $f->descriptor = $descriptor;
                $f->save();

            }
            $imp->successed = $success;
            $imp->unsuccess = $unsuccess;
            $imp->save();

            return [
                'message' => $imp->desc,
                'successed' => $success,
                'unsuccess' => $unsuccess,
                'total' => $total,
                'status' => '1',
                'success'=> true,
            ];
        } catch (Exception $e) {
            return[
                'status' => '0',
                'success'=> false,
                'msg'=> $e->getMessage(),
            ]; 
        }
    }
    
    
    /**
    *@noAuth
    *@url GET /refreshdb
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *DATE:  2019-09-27(Fri)  16:15:37 
    
    *----------------------------------------------
    */
    public function refreshdb(){
        $msg = 'bf total-->'.count($this->http->faces);
        $this->http->faces = [];
        $this->http->faces = Face::get();
        $this->http->male = Face::whereGender('male')->get();
        $this->http->female = Face::whereGender('female')->get();
        return $msg.'<br/> af total-->'.count($this->http->faces).'</br>male-->'.count($this->http->male).'<br/>female-->'.count($this->http->female);

    }
    
    
    
    

}

