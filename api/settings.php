<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database connection settings
        "db" => [
            "host" => "DESKTOP-R0TQF3D",
            "dbname" => "horasExtras",
            "user" => "sa",
            "pass" => "21202839"
        ],
        // Database connection settings
        "dbERP" => [
            "host" => "SERVER",
            "dbname" => "DADOSP11",
            "user" => "SIGA",
            "pass" => "FVADHW"
        ],
       
    ],
];
