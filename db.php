<?php
$host = 'localhost';    // DB host
$user = 'root';         // DB user
$pass = '';             // DB password
$db   = 'payroll_cast'; // DB name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}
