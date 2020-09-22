<?php $title = 'Password reset' ?>

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

    if (empty($email)){array_push($errors, "Email is required");}

    if (!count($errors)) {
      $userExists = $mysqli->query("SELECT id, email FROM users WHERE email = '$email' LIMIT 1");

      if ($userExists->num_rows) {

        $userId = $userExists->fetch_assoc()['id'];

        $tokenExists = $mysqli->query(
          "DELETE FROM password_resets WHERE user_id='$userId'
          ");
        $token = bin2hex(random_bytes(16));
        $expires_at = date('Y-m-d H:i:s', strtotime('1+ day'));

        $mysqli->query(
          "INSERT INTO password_resets (user_id, token, expires_at)
          VALUES ('$userId', '$token', '$expires_at');
          ");

        $changePasswordUrl = $config['app_url'].'change_password.php?token='.$token;
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'Form: ' . $config['admin_email'] . "\r\n" .
            'Replay-To: ' . $config['admin_email'] . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $htmlMessage = '<html><body>';
        $htmlMessage .= '<p style="color: #ff0000;">' . $changePasswordUrl . '</p>';
        $htmlMessage .= '</html></body>';

        mail($email, 'Password reset link', $htmlMessage, $headers);
        
      }
      $_SESSION['success_message'] = 'Please check your email for reset link';
      header('location: change_password.php');
    }    
  }
?>

<div class="password_reset">
  <h3>Password reset</h3>
  <h5 class="text-info">Please fill in your email to reset the password</h5>
  <hr>
  <?php include 'template/error.php' ?>
  <form action="" method="post">
    <div class="form-group">
      <label for="email">Email:</label>
      <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo $email ?>">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Request password reset link</button>
    </div>
  </form>
</div>
<?php require_once 'template/footer.php' ?>