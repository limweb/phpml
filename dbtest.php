<?php
$dsn = "mysql:host=172.25.0.4;dbname=faces";
$user = "root";
$passwd = "";

$pdo = new PDO($dsn, $user, $passwd);

$stm = $pdo->query("SELECT VERSION()");

$version = $stm->fetch();

echo $version[0] . PHP_EOL;
