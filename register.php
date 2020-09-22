<?php $title = 'Register' ?>

<?php require 'config/app.php' ?>
<?php require_once 'template/header.php' ?>
<?php require_once 'config/database.php' ?>
<?php 

if (isset($_SESSION['logged_in'])) {
  header('location: index.php');
}

$errors = [];
$email = '';
$name = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);

    if (empty($email)){array_push($errors, "Email is required");}
    if (empty($name)){array_push($errors, "Name is required");}
    if (empty($password)){array_push($errors, "Password is required");}
    if (empty($password_confirmation)){array_push($errors, "Password confirmation is required");}
    if ($password !== $password_confirmation) {
      array_push($errors, "Passwords don't match");
    }

    if (!count($errors)) {
      $userExists = $mysqli->query("SELECT id, email FROM users WHERE email = '$email' LIMIT 1");
      if ($userExists->num_rows) {
        array_push($errors, "Email already existed");
      }
    }

    // create a new user
    if (!count($errors)) {
      $password = password_hash($password, PASSWORD_DEFAULT);
      
      $query = "INSERT INTO users (email, name, password) VALUES ('$email', '$name', '$password')";
      $mysqli->query($query);

      $_SESSION['logged_in'] = true;
      $_SESSION['user_id'] = $mysqli->insert_id;
      $_SESSION['user_name'] = $name;
      $_SESSION['success_message'] = "Welcome to our website, $name";

      header('location: index.php');
    }
  }
?>

<div class="register">
  <h3>Welcome to our website</h3>
  <h5 class="text-info">Please fill in the below to register a new account</h5>
  <hr>
  <?php include 'template/error.php' ?>
  <form action="" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo $email ?>">
    </div>
    <div class="form-group">
      <label for="name">Name:</label>
      <input class="form-control" type="text" name="name" id="name" placeholder="Enter your name" value="<?php echo $name ?>">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" id="password" placeholder="Enter your password">
    </div>
    <div class="form-group">
      <label for="password_confirmation">Confirm password:</label>
      <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">Register</button>
      <a href="<?php echo $config['app_url'].'login.php' ?>">Already have an account? login here</a>
    </div>
  </form>
</div>
<?php require_once 'template/footer.php' ?>