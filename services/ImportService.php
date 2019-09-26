<?php

//----------------------------------------------
//FILE NAME:  ImportService.php gen for Servit Framework Service
//DATE: 2019-09-26(Thu)  17:44:12 

//----------------------------------------------
use \Servit\Restsrv\RestServer\RestException as TestException;
use \Servit\Restsrv\Traits\DbTrait as DbTrait;
use \Servit\Restsrv\Service\BaseService as BaseService;
use \Servit\Restsrv\Service\BasedbService as BasedbService;
use Illuminate\Database\Capsule\Manager as Capsule;

class ImportService  extends BaseService
{

    public static function all()
    {
        return Import::get();
    }

    public static function alliddesc()
    {
        return Import::orderBy('id', 'desc')->get();
    }

    public static function insert($arrdata)
    {
        $r = new Import();
        $fills = $r->getFillable();
        foreach ($fills as $key) {
            if (isset($arrdata[$key])) {
                $r->{$key} = $arrdata[$key];
            }
        }
        $r->save();
        return $r;
    }

    public static function insertOrupdate($arrdata)
    {
        $r = null;
        if (isset($arrdata['id'])) {
            $r = Import::find($arrdata['id']);
        }
        if (!$r) {
            $r = new Import();
        }

        $fills = $r->getFillable();
        foreach ($fills as $key) {
            if (isset($arrdata[$key])) {
                $r->{$key} = $arrdata[$key];
            }
        }
        $r->save();
        return $r;
    }

    public static function delete($id)
    {
        $r = Import::find($id);
        if ($r) {
            return $r->delete();
        } else {
            return 0;
        }
    }
    
    
} 

