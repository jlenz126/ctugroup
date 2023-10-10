<?php

$DB_HOST = 'localhost'; // Change to your MySQL host name (often 'localhost' is enough)
$DB_USER = 'gtthompson84'; // Change to your MySQL user name
$DB_PASS = 'XXXXXXX'; // Change to your MySQL password
$DB_NAME = 'login'; // Change to your database name

// Creating the connection
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Checking the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
