<?php 
$title = 'Edit user';
include __DIR__.'/../template/header.php';

if (!isset($_GET['id']) || !$_GET['id']) {
  die('Missing id parameter');
}

$statment = $mysqli->prepare(
  "SELECT * FROM users
  WHERE id = ?
  LIMIT  1 ");
$statment->bind_param('i', $userId);
$userId = $_GET['id'];
$statment->execute();

$user = $statment->get_result()->fetch_assoc();
//print_r($user);
$name = $user['name'];
$email = $user['email'];
$role = $user['role'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (empty($_POST['email'])){array_push($errors, "Email is required");}
  if (empty($_POST['name'])){array_push($errors, "Name is required");}
  if (empty($_POST['role'])){array_push($errors, "Role is required");}

  if (!count($errors)) {
    $statment = $mysqli->prepare(
      "UPDATE users 
      SET name = ?, email = ?, role = ?, password = ? 
      WHERE id = ?;
      ");
    $statment->bind_param('ssssi', $dbName, $dbEmail, $dbRole, $dbPassword, $dbId);
    $dbName = $_POST['name'];
    $dbRole = $_POST['role']; 
    $dbEmail = $_POST['email']; 
    $_POST['password'] ? $dbPassword = password_hash(PASSWORD_DEFAULT) : $dbPassword = $user['password'];
    $dbId = $_GET['id'];
  
    $statment->execute();
  
    if ($statment->error) {
      array_push($errors, $statment->error);
    }else{
      echo "<script>location.href = 'index.php'</script>";
    }
  }
}
?>

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
      <button type="submit" class="btn btn-success">Update</button>      
    </div>
  </form>
  </div>
</div>

<?php 
include __DIR__.'/../template/footer.php';
  
