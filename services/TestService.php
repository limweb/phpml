<?php

//----------------------------------------------
//FILE NAME:  TestService.php gen for Servit Framework Service
//DATE:                 2019-02-02(Sat)  10:54:55

//----------------------------------------------
use \Servit\Restsrv\Service\BaseService as BaseService;

class TestService extends BaseService
{
    public static function Test1()
    {
        return 'Test1';
    }
    public static function Test2()
    {
        return Round::get();
    }

}
