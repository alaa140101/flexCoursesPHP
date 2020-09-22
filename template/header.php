<?php session_start() ?>
<?php require_once __DIR__.'/../config/app.php'; ?>

<!DOCTYPE html>
<html lang="<?php echo $config['lang'] ?>" dir="<?php echo $config['dir']?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $config['app_name'] . " | " . $title ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="template/style.css">
</head>
<body>
  

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo $config['app_url'] ?>"><?php echo $config['app_name'] ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>contact.php">Contact</a>
      </li>     
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>messages.php">Messages</a>
      </li>     
    </ul>

    <ul class="navbar-nav ml-auto">
    <?php if(!isset($_SESSION['logged_in'])): ?>
      <li class="nav-item">
        <a href="<?php echo $config['app_url'] ?>login.php" class="nav-link">Login</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $config['app_url'] ?>register.php" class="nav-link">Register</a>
      </li>
    <?php else: ?>
      <li class="nav-item">
        <a href="#" class="nav-link"><?php echo $_SESSION['user_name']?></a>
      </li>
      <li class="nav-item">
        <a href="<?php echo $config['app_url'] ?>logout.php" class="nav-link">Logout</a>
      </li>
    <?php endif; ?>
    </ul>

  </div>
</nav>

<div class="container pt-5">
<?php include 'message.php' ?>
  
  
  
 