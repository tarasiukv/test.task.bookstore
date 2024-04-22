<?php

/**
 * database configuration
 */
$db = 'mysql';
$host = 'localhost';
$dbname = 'bookstore';
$user = 'root';
$pass = '';

/**
 * don't change these
 */

return $config = [
    'db' => [
        'host' => $host,
        'dbname' => $dbname,
        'user' => $user,
        'pass' => $pass,
        'connection_string' => "$db:host=$host;dbname=$dbname"
    ]
];