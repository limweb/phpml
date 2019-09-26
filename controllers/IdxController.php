<?php

//----------------------------------------------
//FILE NAME:  IdxController.php gen for Servit Framework Controller
//DATE: 2019-09-26(Thu)  17:56:13 

//----------------------------------------------
use	\Servit\Restsrv\RestServer\RestException;
use	\Servit\Restsrv\RestServer\RestController as BaseController;
use	Illuminate\Database\Capsule\Manager as Capsule;
use	Servit\Restsrv\Libs\Request; 
use	Servit\Restsrv\Libs\Linenotify;
use	Carbon\Carbon;
use \Servit\Restsrv\traits\DbTrait;

class IdxController  extends BaseController {
    

/**
*@noAuth
*@url GET /face1
*----------------------------------------------
*FILE NAME:  IdxController.php gen for Servit Framework Controller
*DATE:  2019-09-26(Thu)  17:56:24 

*----------------------------------------------
*/
public function face1(){
    $html = '            
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
    <script defer src="/js/face-api.min.js"></script>
    <script defer src="/js/script.js"></script>
    <style>
        html { 
        /* background: url(/dist/img/bg.jpg) no-repeat center center fixed;  */
        background: #0000;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            position: absolute;
            top:83px;
        }
    </style>
    </head>
    <body style="display: flex;flex-direction: column;">
            <center>
                <img src="/dist/img/logo.png" />
            </center>
            <video id="video" width="620" height="560" autoplay muted></video>
    </body>
    </html>';
    return $html;
}




}

