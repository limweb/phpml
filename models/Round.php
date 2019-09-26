<?php

//----------------------------------------------
//FILE NAME:  Round.php gen for Servit Framework Model
//DATE:                 2019-01-30(Wed)  16:39:05

//----------------------------------------------
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Servit\Restsrv\Model\BaseModel;

class Round extends BaseModel
{
    protected $table = 'rounds';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
    protected $fillable = ['name'];
    protected $hidden = [];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //integer, real, float, double, string, boolean, object, array, collection, date and datetime.
    protected $casts = [
        //    restcast snippet
    ];

}
