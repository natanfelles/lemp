#!/usr/bin/env php
<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Command.php';

use Symfony\Component\Console\Application;


$app         = new Application();
$cmd_dir     = __DIR__ . '/Commands/';
$cmd_dir_len = strlen($cmd_dir);

foreach (glob($cmd_dir . '*.php') as $filepath)
{
	require $filepath;
	$class = substr($filepath, $cmd_dir_len, strlen($filepath) - $cmd_dir_len - 4);
	$app->add(new $class);
}

$app->run();
