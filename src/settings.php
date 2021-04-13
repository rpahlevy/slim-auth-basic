<?php

// load .env
$dotenv = new Dotenv\Dotenv(__DIR__ .'/../');
$dotenv->load();

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'debugMode' => true,

        // Database
        'db' => [
            'connection' => getenv('DB_CONNECTION'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
        ],
    ],
];
