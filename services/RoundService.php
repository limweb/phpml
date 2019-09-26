<?php

//----------------------------------------------
//FILE NAME:  RoundService.php gen for Servit Framework Service
//DATE:                 2019-01-30(Wed)  17:57:17

//----------------------------------------------
use \Servit\Restsrv\Service\BaseService as BaseService;

class RoundService extends BaseService
{

    public static function insert($arrdata)
    {
        $r = new Round();
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
            $r = Round::find($arrdata['id']);
        }
        if (!$r) {
            $r = new Round();
        }

        $fills = $r->getFillable();
        foreach ($fills as $key) {
            $r->{$key} = $arrdata[$key];
        }
        $r->save();
        return $r;
    }

    public static function all()
    {
        return Round::get();
    }

    public static function active()
    {
        return Round::where('status', 1)->get();
    }

}
