<?php
/* Database connection settings */
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'login_system';

$mysqli = new mysqli($host, $user, $password, $database) or die($mysqli->error);
