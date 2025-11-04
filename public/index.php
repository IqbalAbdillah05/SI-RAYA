<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

// 🔧 Tambahkan ini supaya Laravel tahu path public sekarang di public_html
$app = require_once __DIR__.'/bootstrap/app.php';
$app->bind('path.public', function () {
    return __DIR__;
});

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
