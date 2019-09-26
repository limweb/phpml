<?php

//----------------------------------------------
//FILE NAME:  Import.php gen for Servit Framework Model
//DATE: 2019-09-26(Thu)  17:40:15 

//----------------------------------------------
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Servit\Restsrv\Model\BaseModel;
//use DB;

class Import extends Model
{
        protected	$table='imports';
        protected	$primaryKey='id';
        protected	$keyType = 'string';
        public	$timestamps = true;
        protected	$dateFormat = 'U';
} 
