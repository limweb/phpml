<?php

//----------------------------------------------
//FILE NAME:  LotService.php gen for Servit Framework Service
//DATE:                 2019-01-30(Wed)  18:29:36

//----------------------------------------------
use \Servit\Restsrv\Service\BaseService as BaseService;

class LotService extends BaseService
{

    public static function lotbyround($id)
    {
        return Lot::where('round_id', $id)->get();
    }

    public static function sumbyround($id)
    {
        return Lot::where('round_id', $id)->selectRaw('sum(price) as total');
    }
    public static function sumbyRoundType($roundid)
    {
        return Lot::where('round_id', $roundid)
            ->groupBy('type_id')
            ->leftJoin('types', 'lots.type_id', '=', 'types.id')
            ->selectRaw('sum(price) as total,lots.type_id,types.name,types.lname');
    }

    public static function lotsumarybyround($id, $typeid)
    {
        return Lot::groupBy('num')
            ->where('round_id', $id)
            ->where("type_id", $typeid)
            ->selectRaw('sum(price) as price,num')
            ->get();
        // ->pluck('price', 'num');
    }

}
