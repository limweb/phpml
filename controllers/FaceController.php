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

class FaceController  extends BaseController {
    
    
    /**
    *@noAuth
    *@url GET /testface
    *----------------------------------------------
    *FILE NAME:  FaceController.php gen for Servit Framework Controller
    *DATE:  2019-09-26(Thu)  17:54:50 
    
    *----------------------------------------------
    */
    public function testface(){
        try {
            
            return ['ok'];

        } catch (Exception $e) {
            return[
                'status' => '0',
                'success'=> false,
                'msg'=> $e->getMessage(),
            ]; 
        }
    }
    
    
    

}

