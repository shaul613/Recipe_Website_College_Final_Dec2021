<?php

$DB_USER = 'shaul';
$DB_PASSWORD = '';
$DB_HOST = 'localhost';
$DB_NAME = 'recipe';

$dbc = @mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME) OR die('could not connect to MySQL: ' . mysqli_connect_error() );

 ?>
