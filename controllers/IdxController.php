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
    // $this->http->faces = Face::get();
    $this->http->male = Face::whereGender('male')->get();
    $this->http->female = Face::whereGender('female')->get();
    // dump($this->http->faces);
    return $html;
}


/**
*@noAuth
*@url GET /import
*----------------------------------------------
*FILE NAME:  IdxController.php gen for Servit Framework Controller
*DATE:  2019-09-27(Fri)  15:27:54 

*----------------------------------------------
*/
public function import(){
    $html = '
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <div id="container" style="width:80%;margin: 20 0 0 20;" >
    <form action="/api/imports" method="post" enctype="multipart/form-data" >
        <div class="form-group">
          <label for="description">Description</label>
          <input type="text" name="description" id="description" class="form-control" placeholder="Description" aria-describedby="desctxthelp">
          <small id="desctxthelp" class="text-muted">Description</small>
        </div>
        <div class="form-group">
          <label for="fileimport">Files</label>
          <input type="file" name="fileimport" id="fileimport" class="form-control" placeholder="import.json" aria-describedby="fimporthelp">
          <small id="fimporthelp" class="text-muted">file imports.json</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
    ';
    return $html;
}

}

