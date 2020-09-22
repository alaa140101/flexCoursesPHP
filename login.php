<?php $title = 'Login' ?>

<?php require 'config/app.php' ?>
<?php require_once 'template/header.php' ?>
<?php require_once 'config/database.php' ?>

<?php 
if (isset($_SESSION['logged_in'])) {
  header('location: index.php');
}

$errors = [];
$email = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);

    if (empty($email)){array_push($errors, "Email is required");}
    if (empty($password)){array_push($errors, "Password is required");}

    if (!count($errors)) {
      $userExists = $mysqli->query("SELECT id, email,password, name, role FROM users WHERE email = '$email' LIMIT 1");

      if (!$userExists->num_rows) {
        array_push($errors, "Email dosen't exist");
      }else{
        
        $foundUser = $userExists->fetch_assoc();

        if (password_verify($password, $foundUser['password'])) {
          // log in
          $_SESSION['logged_in'] = true;
          $_SESSION['user_id'] = $foundUser['id'];
          $_SESSION['user_name'] = $foundUser['name'];
          $_SESSION['user_role'] = $foundUser['role'];
          
          if ($foundUser['role'] == 'admin') {
            header('location: admin');
          }else{
          $_SESSION['success_message'] = "Welcome back, $foundUser[name]";
          header('locatoin: index.php');
          }

        }else{
          array_push($errors, "Wrong password");
        }
      }
    }

    // create a new user
    // if (!count($errors)) {
    //   $password = password_hash($password, PASSWORD_DEFAULT);
      
    //   $query = "INSERT INTO users (email, name, password) VALUES ('$email', '$name', '$password')";
    //   $mysqli->query($query);

    //   $_SESSION['logged_in'] = true;
    //   $_SESSION['user_id'] = $mysqli->insert_id;
    //   $_SESSION['user_name'] = $name;
    //   $_SESSION['success_message'] = "Welcome back, $name";

    //   header('locatoin: index.php');
    // }
  }
?>

<div class="login">
  <h3>Welcome back</h3>
  <h5 class="text-info">Please fill in the below to login your account</h5>
  <hr>
  <?php include 'template/error.php' ?>
  <form action="" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo $email ?>">
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input class="form-control" type="password" name="password" id="password" placeholder="Enter your password">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">Login</button>
      <a href="<?php echo $config['app_url'].'password_reset.php' ?>">Forgot your password</a>
    </div>    
  </form>
</div>
<?php require_once 'template/footer.php' ?>