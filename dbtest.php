<?php
$dsn = "mysql:host=facedb;dbname=faces";
$user = "root";
$passwd = "dbroot";

$pdo = new PDO($dsn, $user, $passwd);

$stm = $pdo->query("SELECT VERSION()");

$version = $stm->fetch();

echo $version[0] . PHP_EOL;
