<?php 
session_start();
require_once __DIR__.'/../config/app.php'?>
<!DOCTYPE html>
<html lang="<?php echo $config['lang'];?>" dir="<?php echo $config['dir'];?>">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $config['app_name'] . " | " . $page_title;?></title>
</head>
<body>
<div class="container">
