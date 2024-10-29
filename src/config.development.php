<?php

/**
 * PHPMaker 2024 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "vm3.adrianmercado.com.ar", "port" => "3306", "user" => "am_test_user", "password" => "IV20pRY3VkAcIcs", "dbname" => "am_test"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "smtp.gmail.com", // SMTP server
        "SERVER_PORT" => 587, // SMTP server port
        "SECURE_OPTION" => "tls",
        "SERVER_USERNAME" => "soporte@grupoadrianmercado.com", // SMTP server user name
        "SERVER_PASSWORD" => "edes msej zdrf ciab
", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "Q5i7qaDCZ59/7SpzXcCKrKNXT2gbeP2U/M7nXQie9Hs=", // JWT secret key
        "ALGORITHM" => "HS512", // JWT algorithm
        "AUTH_HEADER" => "X-Authorization", // API authentication header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
