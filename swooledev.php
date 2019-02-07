<?php
require './vendor/autoload.php';
$startServiceCommand = '/usr/bin/php ./swooleserver.php start';
$cmd = new \Phpdic\SwooleAutoRestart\swooleAutoRestart(__DIR__, $startServiceCommand, [], 1000, true);
$cmd->listen();
