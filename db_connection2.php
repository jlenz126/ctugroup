<?php

$DB_HOST = 'localhost';
$DB_USER = 'pizza_user';
$DB_PASS = 'pizza';
$DB_NAME = 'pizza_restaurant';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error){
    die("Connection failed: " . $conn->connection_error);
}