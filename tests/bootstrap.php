<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test($title, callable $cb)
{
	$cb();
}
