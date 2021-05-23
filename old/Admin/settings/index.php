<?php 
$title = 'Setting';
$icon = 'cogs';
include __DIR__.'/../template/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  $statment = $mysqli->prepare(
    'UPDATE  settings SET admin_email = ?, app_name = ?
    WHERE id = 1');
  $statment->bind_param('ss', $dbAdminEmail, $dbAppName);
  $dbAdminEmail = $_POST['admin_email'];
  $dbAppName = $_POST['app_name'];

  $statment->execute();

  echo "<script>location.href = 'index.php' </script>";
}
?>

<div class="card">
  <div class="card-header">
    <h2>Update settings</h2>
  </div>
  <div class="card-body">
    <form action="" method="post" class="list-group list-group-flush">
      <div class="form-group">
        <label for="app_name">Application name</label>
        <input type="text" name="app_name" id="app_name" class="form-control" value="<?php echo $config['app_name']?>">
      </div>
      <div class="form-group">
        <label for="admin_email">Admin email</label>
        <input type="email" name="admin_email" id="admin_email" class="form-control" value="<?php echo $config['admin_email']?>">
      </div>
      <div class="form-group">
        <button class="btn btn-success" type='submit'>Update</button>
      </div>
    </form>
  </div>
</div>

<?php
include __DIR__.'/../template/footer.php';