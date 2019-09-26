<?php
// require_once __DIR__ . '/linewebloginv2/src/autoload.php';
define("ROOTPATH", __DIR__);
define('SRVPATH', __DIR__);
define("APP", __DIR__);
define('SWOOLEMODE', $_ENV['SWOOLEMODE']); // 1 = true  or  0 = false
define('APPMODE', 'debug'); // debug or production

define('LOG', 'app.log');
define('DEBUG', $_ENV['DEBUG']);
define('CROS', $_ENV['CROS']);
define('EXPTIME', $_ENV['EXPTIME']); //  60sec * 60 mins * 24 hr * 30 day
define('APP_KEY', $_ENV['APP_KEY']);
define('USEDROLE', $_ENV['USEDROLE']);
define('REFTOKEN', $_ENV['REFTOKEN']); // reference for  GET POST AJAX token field
define('AUTHTYPE', $_ENV['AUTHTYPE']); // session // jwt default jwt
define('PERPAGE', $_ENV['PERPAGE']); // display number rows perpage
