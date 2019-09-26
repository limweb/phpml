<?php

//----------------------------------------------
//FILE NAME:  PlayerService.php gen for Servit Framework Service
//DATE:                 2019-01-30(Wed)  18:19:21

//----------------------------------------------
use \Servit\Restsrv\Service\BaseService as BaseService;

class PlayerService extends BaseService
{

    public static function allinput()
    {
        return Player::select('id', 'name', 'percent')->get();
    }

    public static function all()
    {
        return Player::get();
    }

    public static function insert($arrdata)
    {
        $r = new Player();
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
            $r = Player::find($arrdata['id']);
        }
        if (!$r) {
            $r = new Player();
        }

        $fills = $r->getFillable();
        foreach ($fills as $key) {
            $r->{$key} = $arrdata[$key];
        }
        $r->save();
        return $r;
    }

}
