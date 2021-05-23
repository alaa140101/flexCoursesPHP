<?php $title = 'Change password' ?>

<?php require 'config/app.php' ?>
<?php require_once 'template/header.php' ?>
<?php require_once 'config/database.php' ?>

<?php 
if (isset($_SESSION['logged_in'])) {
  header('location: index.php');
}

if (!isset($_GET['token']) || $_GET['token'] == null) {
  die('Token parameter is missing');
}

$now = date('Y-m-d H:i:s');
$stmt = $mysqli->prepare(
  "SELECT * FROM password_resets
  WHERE token = ? and expires_at > '$now'
  ");
$stmt->bind_param('s', $token);
$token = $_GET['token'];

$stmt->execute();

$result = $stmt->get_result();

if (!$result->num_rows) {
  die('Token is not valid');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $password = mysqli_real_escape_string($mysqli, $_POST['password']);
  $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);

  if (empty($password)){array_push($errors, "Password is required");}
  if (empty($password_confirmation)){array_push($errors, "Password confirmation is required");}
  if ($password !== $password_confirmation) {
    array_push($errors, "Passwords don't match");
  }

  if (!count($errors)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $userId = $result->fetch_assoc()['user_id'];
    $mysqli->query(
      "UPDATE users SET password = '$hashed_password' 
      WHERE id = '$userId';
      ");
    $mysqli->query(
      "DELETE FROM password_resets
      WHERE user_id = '$userId';
      ");
    $_SESSION['success_message'] = 'Your password has been changed, please login';

    header('location: login.php');
    die();
  }    
}
?>

<div class="new_password">
  <h3>Create a new password</h3>
  <h5 class="text-info">Please fill in your new password</h5>
  <hr>
  <?php include 'template/error.php' ?>
  <form action="" method="post">
    <div class="form-group">
        <label for="password">New password:</label>
        <input class="form-control" type="password" name="password" id="password" placeholder="Enter your new password">
    </div>
    <div class="form-group">
      <label for="password_confirmation">Confirm password:</label>
      <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Change password</button>
    </div>
  </form>
</div>
<?php require_once 'template/footer.php' ?>