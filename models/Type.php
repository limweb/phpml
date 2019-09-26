<?php

//----------------------------------------------
//FILE NAME:  Type.php gen for Servit Framework Model
//DATE:                 2019-01-30(Wed)  16:41:07

//----------------------------------------------
use Illuminate\Database\Eloquent\SoftDeletes;
use Servit\Restsrv\Model\BaseModel;

class Type extends BaseModel
{
    protected $table = 'types';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = array('id');
    protected $fillable = ['id', 'shostkey', 'name', 'paidper', 'limit', 'cutted'];
    protected $hidden = [];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    //integer, real, float, double, string, boolean, object, array, collection, date and datetime.
    protected $casts = [
        //    restcast snippet
    ];

}
