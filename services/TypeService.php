<?php

//----------------------------------------------
//FILE NAME:  TypeService.php gen for Servit Framework Service
//DATE:                 2019-01-30(Wed)  18:25:06

//----------------------------------------------
use \Servit\Restsrv\Service\BaseService as BaseService;

class TypeService extends BaseService
{

    public static function allinput()
    {
        return Type::select('id', 'shostkey', 'name', 'paidper', 'limit', 'cutted')->get();
    }
    public static function all()
    {
        return Type::get();
    }

    public static function insert($arrdata)
    {
        $r = new Type();
        $fills = $r->getFillable();
        foreach ($fills as $key) {
            $r->{$key} = $arrdata[$key];
        }
        $r->save();
        return $r;
    }

    public static function insertOrupdate($arrdata)
    {
        $r = null;
        if (isset($arrdata['id'])) {
            $r = Type::find($arrdata['id']);
        }
        if (!$r) {
            $r = new Type();
        }

        $fills = $r->getFillable();
        foreach ($fills as $key) {
            $r->{$key} = $arrdata[$key];
        }
        $r->save();
        return $r;
    }

}
