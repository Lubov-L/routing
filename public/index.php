<?php

use Routing\App\RMVC\App;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/web.php';


App::run();