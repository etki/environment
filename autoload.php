<?php

use Etki\Environment\Support\Autoloader;

require_once __DIR__ . '/src/Support/Autoloader.php';

$autoloader = new Autoloader;
$autoloader->add('Etki\Environment', __DIR__ . '/src');
$autoloader->register();
