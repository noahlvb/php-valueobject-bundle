<?php
require_once('vendor/autoload.php');

$loader = new \Composer\Autoload\ClassLoader();
$loader->add('Noahlvb\ValueObjectBundle', ['src/']);
$loader->add('Noahlvb\ValueObjectBundle\Tests', ['tests/']);
$loader->register();
$loader->setUseIncludePath(true);
