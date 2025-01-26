<?php

require_once 'vendor/autoload.php';

use App\Application;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

(new Application())->run();