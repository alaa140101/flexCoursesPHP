<?php 

  $connection = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'db_name' => 'app'
  ];

  $mysqli = new mysqli(
    $connection['host'],
    $connection['user'],
    $connection['password'],
    $connection['db_name']
  );

  if ($mysqli->connect_error) {
    die("Not connected to the database" . $mysqli->connect_error);
  }
?>