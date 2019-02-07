<?php

//----------------------------------------------
//FILE NAME:  Player.php gen for Servit Framework Model
//DATE:                 2019-01-30(Wed)  16:37:48

//----------------------------------------------
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Servit\Restsrv\Model\BaseModel;

//use DB;

class Player extends BaseModel
{
    protected $table = 'players';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = array('id');
    protected $fillable = ['id', 'name', 'percent'];
    protected $hidden = [];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //integer, real, float, double, string, boolean, object, array, collection, date and datetime.
    protected $casts = [
        //    restcast snippet
    ];

}
