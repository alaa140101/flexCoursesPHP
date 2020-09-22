<?php 
$title = 'Create service';
$icon = 'magic';
include __DIR__.'/../template/header.php';

if (isset($_SESSION['logged_in'])) {
  header('location: index.php');
}

$errors = [];
$name = '';
$description = '';
$price = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);

    if (empty($name)){array_push($errors, "Name is required");}
    if (empty($description)){array_push($errors, "Description is required");}    
    if (empty($price)){array_push($errors, "Price is required");}

    // create a new service
    if (!count($errors)) {
      
      $query = "INSERT INTO services (name, description, price) VALUES ('$name', '$description', '$price')";
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
      <button type="submit" class="btn btn-success">Create service</button>      
    </div>
  </form>
  </div>
</div>

<?php
include __DIR__.'/../template/footer.php';
  
