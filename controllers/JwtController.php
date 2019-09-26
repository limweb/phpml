<?php

//----------------------------------------------
//FILE NAME:  JwtController.php gen for Servit Framework Controller
//DATE:                 2019-01-28(Mon)  00:10:23

//----------------------------------------------
use \Servit\Restsrv\RestServer\RestController as BaseController;

class JwtController extends BaseController
{
    public function authorize()
    {

        try {
            $token = $this->input->token;
            $jwt = new JwtService();
            $this->jwtdata = $jwt->getJwtobjdata();
            $chk = $jwt->chkauth();
            $data = $this->jwtdata;
            if ($chk && $data) {
                $uid = $data->uid ?: '';
                $uuid = $data->uuid ?: '';
                $user = Account::find($uid);
                if ($user) {
                    return $user->uuid == $uuid;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            $this->server->setStatus(401);
        }
    }

}
