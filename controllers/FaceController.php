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
    
    // private $distinc = 0.25;
    private $distinc = 0.3;

    /**
    *@noAuth
    *@url POST /testface
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *DATE:  2019-09-26(Thu)  17:54:50 
    
    *----------------------------------------------
    */
    public function testface(){
        try {
            // dump('ok',count($this->http->faces));
            $input = json_decode($this->request->rawContent());
            $gender = isset($input->gender) ? $input->gender : '';
            // dump('--testface---gender-->',$gender);
            $qryface = isset($input->queryFace) ? json_decode(json_encode($input->queryFace),true) : '';
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
                //         if($result < $this->distinc){
                //             $rs[$k] = $result;
                //         }
                //     }
                // }

                if($gender == 'male'){
                    $male =  json_decode($this->http->redis->get('male'));
                    // dump('count-male-->',count($male));
                    foreach($male as $k=> $people){ //แยกคน
                            $faces = $people->descriptor; // ข้อมูลหน้า
                            $sum = 0;
                            if($faces){
                                foreach($faces as $key=>$val)  {
                                    $sum += pow($val-$qryface[$key],2);
                                }
                                $result = sqrt($sum);
                                if($result < $this->distinc){
                                    $rs[$k] = $result;
                                }
                            }
                        }
                }

                if($gender == 'female'){
                   $female =  json_decode($this->http->redis->get('female'));
                   foreach($female as $k=> $people){ //แยกคน
                            $faces = $people->descriptor; // ข้อมูลหน้า
                            $sum = 0;
                            if($faces){
                                foreach($faces as $key=>$val)  {
                                    $sum += pow($val-$qryface[$key],2);
                                }
                                $result = sqrt($sum);
                                if($result < $this->distinc){
                                    $rs[$k] = $result;
                                }
                            }
                        }
                }

            }
            $o= new stdClass();
            // dump('rs-->',$rs);
            if(count($rs)>0){
                $a = array_values($rs);
                $min = min($a);
                $index = array_search($min, $rs,true);
                if($gender == 'male'){
                    $p = $male[$index];
                    $o->gender = 'male';
                }
                if($gender == 'female'){
                    $p = $female[$index];
                    $o->gender = 'female';
                }
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
    *@url POST /testfaces
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *DATE:  2019-09-26(Thu)  17:54:50 
    
    *----------------------------------------------
    */
    public function testfaces(){
        try {
            // dump('ok',count($this->http->faces));
            $input = json_decode($this->request->rawContent());
            $gender = isset($input->gender) ? $input->gender : '';
            $qryface = isset($input->queryFace) ? json_decode(json_encode($input->queryFace),true) : '';
            $rs = [];
            // return Face::get();
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
                // ;
                //         }
                //         $result = sqrt($sum);
                //         // dump('result-->',$result);
                //         if($result < $this->distinc){
                //             $rs[$k] = $result;
                //         }
                //     }
                // }
                $distinc = $this->distinc;
                if($gender == 'male'){
                    $male =  json_decode($this->http->redis->get('male'));
                    // dump('---count of male---',count($male));
                    // $male = Face::where('gender','male')->get();
                    foreach($male as $k=> $people){ //แยกคน
                            $faces = $people->descriptor; // ข้อมูลหน้า
                            $sum = 0;
                            if($faces){
                                foreach($faces as $key=>$val)  {
                                    $sum += pow($val-$qryface[$key],2);
                                }
                                $result = sqrt($sum);
                                if($result < $distinc){
                                    $people->distinc = $result;
                                    $rs[] = $people;
                                }
                            }
                        }
                }

                if($gender == 'female'){
                    $female =  json_decode($this->http->redis->get('femail'));
                    // dump('---count of female---',count($female));
                    // $female = Face::where('gender','female')->get();
                   foreach($female as $k=> $people){ //แยกคน
                        $faces = $people->descriptor; // ข้อมูลหน้า
                        $sum = 0;
                        if($faces){
                            foreach($faces as $key=>$val)  {
                                $sum += pow($val-$qryface[$key],2);
                            }
                            $result = sqrt($sum);
                            if($result < $distinc){
                                $people->distinc = $result;
                                $rs[] = $people;
                            }
                        }
                    }
                }

            }
            
            if (!function_exists('my_sort')) {
                function my_sort($a,$b){
                    if ($a->distinc==$b->distinc) return 0;
                    return ($a->distinc<$b->distinc)?-1:1;
                }
            }

            // $a= json_decode('[{"val":1},{"val":3},{"val":2},{"val":6},{"val":4},{"val":5}]');
            usort($rs,"my_sort");

            // foreach($a as $key => $val ){
            //     echo $val->val,PHP_EOL;
            // }

            $rs = array_slice($rs,0,10);
            // var_dump($rs);
            // $o= new stdClass();
            // if(count($rs)>0){
            //     $a = array_values($rs);
            //     $min = min($a);
            //     $index = array_search($min, $rs,true);
            //     $p = $this->http->faces[$index];
            //     $o->name = $p->name;
            //     $o->distinc = $min;
            //     $o->id = $p->id;
            //     $o->idx = $index;
            // } else {
            //     $o->name = '';
            //     $o->distinc = '';
            //     $o->id = '';
            //     $o->idx = '';
            // }
            // dump('---results----',count($rs));
            return $rs;
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
            $result = [];
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
                // $f = new Face();
                // $f->name = $person->userFullName;
                // $f->regid =$person->registerID;
                // $f->category = $imp->desc;
                // $f->gender = $gender;
                // $f->picurl = $person->imgProfile;
                // $f->import_id = $imp->id;
                // $f->picbase64 = '';
                // $f->descriptor = $descriptor;
                // $f->save();

                $o = new \stdClass();
                $o->name = $person->userFullName;
                $o->regid =$person->registerID;
                $o->category = $imp->desc;
                $o->gender = $gender;
                $o->picurl = $person->imgProfile;
                $o->import_id = $imp->id;
                $o->picbase64 = '';
                $o->descriptor = $descriptor;
                
                $result[] = $o;

            }
            $imp->successed = $success;
            $imp->unsuccess = $unsuccess;
            $imp->save();

            return [
                'message' => $imp->desc,
                'successed' => $success,
                'unsuccess' => $unsuccess,
                'result' => count($result),
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
        // $msg = 'bf total-->'.count($this->http->faces);
        // $this->http->faces = [];
        // $this->http->faces = Face::get();
        // $this->http->male = Face::whereGender('male')->get();
        // $this->http->female = Face::whereGender('female')->get();
        // return $msg.'<br/> af total-->'.count($this->http->faces).'</br>male-->'.count($this->http->male).'<br/>female-->'.count($this->http->female);

        $redis = new Redis();    
        $redis->pconnect('redis','6379');
        $redis->set('male', Face::where('gender','male')->get()->toJson());
        $redis->set('female', Face::where('gender','female')->get()->toJson());
        return 'refresh successed';
        
    }
    
    
    
    /**
    *@noAuth
    *@url POST /addmember
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *DATE:  2019-10-04(Fri)  14:53:24 
    
    *----------------------------------------------
    */
    public function addmember(){
        try {
            
            $member = json_decode($this->request->rawContent());
            $gender = $member->gender;
            $qryface = $member->queryFace;
            $user = $member->user;
            
            $file = 'img_'.date('Ymdhms').'.jpg';
            $imgurl = $member->imgurl;
            $path = __DIR__.'/../views/uploads/'.$file;
            $imgdata = file_get_contents($imgurl);
            $status = file_put_contents($path, $imgdata);
            // dump($member);            
            // dump($user);
            $f = new Face();
            $f->name = $user->firstname. ' '.$user->lastname;
            $f->regid = 'test';
            $f->category = 'test';
            $f->gender = $gender;
            $f->picurl = $file;
            $f->import_id =1;
            $f->picbase64 = base64_encode($imgdata);
            $f->descriptor = $qryface;
            $rs = $f->save();
            $redis = new Redis();    
            $redis->pconnect('redis','6379');
            $male = Face::where('gender','male')->get();
            $redis->set('male',json_encode($male));
            $female = Face::where('gender','female')->get();
            $redis->set('female',json_encode($female));

            return [
                'status' => $status,
                'success'=> $rs,
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
    *@url GET /testredis
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *Created by: Tlen<limweb@hotmail.com>
    *DATE:  2019-10-10(Thu)  15:53:16 
    
    *----------------------------------------------
    */
    public function testredis(){
        $male =  json_decode($this->http->redis->get('male'));
        $female =  json_decode($this->http->redis->get('female'));
        dump($male,$female);
    }
    
    
    
    /**
    *@noAuth
    *@url GET /inputfrmoutput
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *Created by: Tlen<limweb@hotmail.com>
    *DATE:  2019-10-10(Thu)  18:07:00 
    
    *----------------------------------------------
    */
    public function inputfrmoutput(){
            $output = file_get_contents(__DIR__.'/../output/output.json');
            $faces = json_decode($output);
            $i = 0;
            $total = count($faces);
            foreach ($faces as $face) {
                
                if( gettype($face)=='object' &&  isset($face->userFullName) && $face->userFullName){
                    $i++;
                    $f = new Face();
                    $f->name = $face->userFullName;
                    $f->regid = $face->registerID;
                    $f->category = '-1';
                    $f->gender = $face->gender;
                    $f->picurl = $face->imgProfile;
                    $f->picbase64 = '';
                    $f->descriptor = $face->descriptor;
                    $f->import_id = '-1';
                    $f->save();
                }
            }

            return 'import total'.$total.' and import'.$i;
    }

    
    /**
    *@noAuth
    *@url POST /addmemassets
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *Created by: Tlen<limweb@hotmail.com>
    *DATE:  2019-10-15(Tue)  18:23:56 
    
    *----------------------------------------------
    */
    public function addmemassets(){
        try {
            $member = json_decode($this->request->rawContent());
            // dump('---member--',$member);
            // {"gender":"male","name":"dusit_korpajarasoontorn","distinc":0_3719635906401922,"id":"10118","idx":5806,"access":1,"created_at":1571139351242,"updated_at":1571139351242}: ""
            $asset = new Asset();
            $asset->name = $member->name;
            $asset->gender = $member->gender;
            $asset->acces = $member->access;
            $asset->created_at = date('Y-m-d H:i:s',$member->created_at/1000 );
            $asset->updated_at = date('Y-m-d H:i:s', $member->updated_at/1000);
            $asset->save();
            return [
                'member' => $member,
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
    
    

}
