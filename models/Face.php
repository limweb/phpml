<?php

//----------------------------------------------
//FILE NAME:  Face.php gen for Servit Framework Model
//DATE: 2019-09-26(Thu)  17:40:49 

//----------------------------------------------
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Servit\Restsrv\Model\BaseModel;

class Face extends Model
{
        protected	$table='faces';
        protected	$primaryKey='id';
        protected	$keyType = 'string';
        public	$timestamps = true;
        protected	$dateFormat = 'U';
} 
