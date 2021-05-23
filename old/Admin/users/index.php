<?php 
$title = 'Users';
$icon = 'users';
include __DIR__.'/../template/header.php';
$users = $mysqli->query(
  "SELECT * FROM users
  ORDER BY  id;
  ")->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
  <div class="card-header">
    <a href="create.php" class="btn btn-success">Create a new user</a>
    <br>
    <h5 class="card-title m-3">Users: <?php echo count($users) ?></h5>
  </div>
  <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Email</th>
            <th scope="col">Name</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) : ?>
          <tr>
            <td scope="row"><?php echo $user['id'] ?></td>
            <td><?php echo $user['email'] ?></td>
            <td><?php echo $user['name'] ?></td>
            <td><?php echo $user['role'] ?></td>
            <td class="form-inline p-1">
              <a href="edit.php?id=<?php echo $user['id'] ?>" class="m-1 btn btn-outline-warning">Edit</a>
              <form onclick="return confirm('Are you sure?')"   method="post">
                <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                <button class="btn btn-outline-danger">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>      
    </div>
</div>

<?php 
if (isset($_POST['user_id'])) {
    
  $statment = $mysqli->prepare("DELETE FROM users WHERE id=?");
  $statment->bind_param('i', $userId);
  $userId = $_POST['user_id'];
  $statment->execute();

  echo "<script> location.href = 'index.php' </script>";
  die();
} 
include __DIR__.'/../template/footer.php';
  
