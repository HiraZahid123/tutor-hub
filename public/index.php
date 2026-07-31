<?php

// Temporary WAF / 403 Diagnostic Log
if (strpos($_SERVER['REQUEST_URI'] ?? '', 'register-tutor') !== false) {
    $postClean = $_POST;
    if (isset($postClean['bio'])) $postClean['bio'] = substr($postClean['bio'], 0, 20) . '...';
    if (isset($postClean['teaching_experience'])) $postClean['teaching_experience'] = substr($postClean['teaching_experience'], 0, 20) . '...';
    $logData = date('Y-m-d H:i:s') . ' | URI: ' . ($_SERVER['REQUEST_URI'] ?? '') . ' | Method: ' . ($_SERVER['REQUEST_METHOD'] ?? '') . ' | POST: ' . json_encode($postClean) . ' | Files: ' . json_encode(array_keys($_FILES ?? [])) . "\n";
    file_put_contents(__DIR__ . '/waf_test.log', $logData, FILE_APPEND);
}

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
