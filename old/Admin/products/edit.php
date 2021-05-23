<?php 
$title = 'Edit product';
$icon = 'cart-plus';
include __DIR__.'/../template/header.php';
require_once __DIR__.'/../../classes/Upload.php';

if (!isset($_GET['id']) || !$_GET['id']) {
  die('Missing id parameter');
}

$statment = $mysqli->prepare(
  "SELECT * FROM products
  WHERE id = ?
  LIMIT  1 ");
$statment->bind_param('i', $productId);
$productId = $_GET['id'];
$statment->execute();

$product = $statment->get_result()->fetch_assoc();

$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
$image = $product['image'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (empty($_POST['name'])){array_push($errors, "Name is required");}
  if (empty($_POST['description'])){array_push($errors, "Description is required");}
  if (empty($_POST['price'])){array_push($errors, "Price is required");}

  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    
   $upload = new Upload('uploads/products');
   $upload->file = $_FILES['image'];
   $errors = $upload->upload();

   if (!count($errors)) {
     unlink($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . '/flexCourses/1-project' . $image);
     $image = $upload->filePath;
   }
  }

  if (!count($errors)) {
    $statment = $mysqli->prepare(
      "UPDATE products 
      SET name = ?, description = ?, price = ?, image = ?
      WHERE id = ?
      ");
    $statment->bind_param('ssdsi', $dbName, $dbDescription, $dbPrice, $dbImage, $dbId);
    $dbName = $_POST['name'];
    $dbDescription = $_POST['description']; 
    $dbPrice = $_POST['price']; 
    $dbImage = $image; 
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
  <form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
      <label for="name">Name: </label>
      <input type="text" name="name" class="form-control" value="<?php echo $name ?>" id="name">
  </div>

  <div class="form-group">
      <label for="description">Description: </label>
      <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?php echo $description ?></textarea>
  </div>

  <div class="form-group">
      <label for="price">Price: </label>
      <input type="number" name="price" class="form-control" id="price" value="<?php echo $price ?>">
  </div>
  <div class="form-group">
      <img src="<?php echo $config['app_url'].$image ?>" width="150" alt="">
      <label for="image"></label>
      <input type="file" name="image">
  </div>

  <div class="form-group">
      <button class="btn btn-success">Update</button>
  </div>
</form>
  </div>
</div>

<?php 
include __DIR__.'/../template/footer.php';
  
