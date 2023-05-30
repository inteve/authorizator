<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


/**
 * @param  string $title
 * @return void
 */
function test($title, callable $cb)
{
	$cb();
}
