<?php 
$title = 'Create user';
include __DIR__.'/../template/header.php';

if (isset($_SESSION['logged_in'])) {
  header('location: index.php');
}

$errors = [];
$email = '';
$name = '';
$role = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $role = mysqli_real_escape_string($mysqli, $_POST['role']);

    if (empty($email)){array_push($errors, "Email is required");}
    if (empty($name)){array_push($errors, "Name is required");}
    if (empty($password)){array_push($errors, "Password is required");}
    if (empty($role)){array_push($errors, "Role is required");}

    // create a new user
    if (!count($errors)) {
      $password = password_hash($password, PASSWORD_DEFAULT);
      
      $query = "INSERT INTO users (email, name, password, role) VALUES ('$email', '$name', '$password', '$role')";
      $mysqli->query($query);
      if ($mysqli->error) {
        array_push($errors, $mysqli->error);
      }else{
        echo "<script>location.href = 'index.php'</script>";
      }
    }
  }
?>

<?php include __DIR__.'/../template/error.php' ?>
<div class="card">
  <div class="card-body">
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
      <label for="role">Role: </label>
      <select class="form-control" name="role" id="role">
        <option value=""></option>
        <option value="user"
        <?php if ($role === 'user') echo 'selected' ?>
        >User</option>
        <option value="admin"
        <?php if ($role === 'admin') echo 'selected' ?>
        >Admin</option>
      </select>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">Create user</button>      
    </div>
  </form>
  </div>
</div>

<?php
include __DIR__.'/../template/footer.php';
  
