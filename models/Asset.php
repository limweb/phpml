<?php

//----------------------------------------------
//FILE NAME:  Asset.php gen for Servit Framework Model
//Created by: Tlen<limweb@hotmail.com>
//DATE: 2019-10-15(Tue)  18:39:35 

//----------------------------------------------
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Servit\Restsrv\Model\BaseModel;

class Asset extends Model
{
        protected	$table='assets';
        protected	$primaryKey='id';
        public	        $timestamps = false;
        protected	$dateFormat = 'U';
        protected	$guarded = array('id');
} 
