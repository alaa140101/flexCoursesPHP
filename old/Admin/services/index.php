<?php 
$title = 'Services';
$icon = 'magic';
include __DIR__.'/../template/header.php';
$services = $mysqli->query(
  "SELECT * FROM services
  ORDER BY  id;
  ")->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
  <div class="card-header">
    <a href="create.php" class="btn btn-success">Create a new service</a>
    <br>
    <h5 class="card-title m-3">Services: <?php echo count($services) ?></h5>
  </div>
  <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($services as $service) : ?>
          <tr>
            <td scope="row"><?php echo $service['id'] ?></td>
            <td><?php echo $service['name'] ?></td>
            <td><?php echo $service['description'] ?></td>
            <td><?php echo $service['price'] ?></td>
            <td class="form-inline p-1">
              <a href="edit.php?id=<?php echo $service['id'] ?>" class="m-1 btn btn-outline-warning">Edit</a>
              <form onclick="return confirm('Are you sure?')"   method="post">
                <input type="hidden" name="service_id" value="<?php echo $service['id'] ?>">
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
if (isset($_POST['service_id'])) {
    
  $statment = $mysqli->prepare("DELETE FROM services WHERE id=?");
  $statment->bind_param('i', $serviceId);
  $serviceId = $_POST['service_id'];
  $statment->execute();

  echo "<script> location.href = 'index.php' </script>";
  die();
} 
include __DIR__.'/../template/footer.php';
  
