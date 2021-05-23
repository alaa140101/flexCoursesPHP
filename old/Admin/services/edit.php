<?php 
$title = 'Edit service';
$icon = 'magic';
include __DIR__.'/../template/header.php';

if (!isset($_GET['id']) || !$_GET['id']) {
  die('Missing id parameter');
}

$statment = $mysqli->prepare(
  "SELECT * FROM services
  WHERE id = ?
  LIMIT  1 ");
$statment->bind_param('i', $serviceId);
$serviceId = $_GET['id'];
$statment->execute();

$service = $statment->get_result()->fetch_assoc();

$name = $service['name'];
$description = $service['description'];
$price = $service['price'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (empty($_POST['name'])){array_push($errors, "Name is required");}
  if (empty($_POST['description'])){array_push($errors, "Description is required");}
  if (empty($_POST['price'])){array_push($errors, "Price is required");}

  if (!count($errors)) {
    $statment = $mysqli->prepare(
      "UPDATE services 
      SET name = ?, description = ?, price = ? 
      WHERE id = ?;
      ");
    $statment->bind_param('ssdi', $dbName, $dbDescription, $dbPrice, $dbId);
    $dbName = $_POST['name'];
    $dbDescription = $_POST['description']; 
    $dbPrice = $_POST['price']; 
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
      <label for="name">Name:</label>
      <input class="form-control" type="text" name="name" id="name" placeholder="Service name" value="<?php echo $name ?>">
    </div>
    <div class="form-group">
      <label for="description">Description:</label>
      <textarea class="form-control" name="description" id="description" placeholder="Service description"><?php echo $description ?></textarea>
    </div>
    <div class="form-group">
      <label for="price">Price: </label>
      <input class="form-control" type="number" name="price" id="price" placeholder="Service price" value="<?php echo $price ?>">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">Update</button>      
    </div>
  </form>
  </div>
</div>

<?php 
include __DIR__.'/../template/footer.php';
  
