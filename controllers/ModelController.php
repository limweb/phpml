<?php


//----------------------------------------------
//FILE NAME:  ModelController.php gen for Servit Framework Controller
//DATE: 2019-09-26(Thu)  18:14:07 

//----------------------------------------------
use	\Servit\Restsrv\RestServer\RestException;
use	\Servit\Restsrv\RestServer\RestController as BaseController;
use	Illuminate\Database\Capsule\Manager as Capsule;
use	Servit\Restsrv\Libs\Request; 
use	Servit\Restsrv\Libs\Linenotify;
use	Carbon\Carbon;
use \Servit\Restsrv\traits\DbTrait;

class ModelController extends BaseController {
    
    
    /**
    *@noAuth
    *@url GET /face_expression_model-shard1
    *----------------------------------------------
    *FILE NAME:  ModelController.php gen for Servit Framework Controller
    *DATE:  2019-09-26(Thu)  18:14:24 
    
    *----------------------------------------------
    */
    public function faceexpressionmodelshard1(){
        return 'ok';
        // return file_get_contents(__DIR__.'/../views/models/face_expression_model-shard1');
    }
    

}

