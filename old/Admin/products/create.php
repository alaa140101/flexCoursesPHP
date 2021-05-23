<?php
$title = 'Create product';
$icon = 'cart-plus';
include __DIR__.'/../template/header.php';
require_once __DIR__.'/../../classes/Upload.php';

$errors = [];
$name = $description = $price = $image = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
  $price = mysqli_real_escape_string($mysqli, $_POST['price']);
  $description = mysqli_real_escape_string($mysqli, $_POST['description']);

   if(empty($name)){array_push($errors, "*Name is required");}
   if(empty($price)){array_push($errors, "*Price is required");}
   if(empty($description)){array_push($errors, "*Description is required");}
   if(empty($_FILES['image']['name'])){array_push($errors, "*Image is required");}

   $upload = new Upload('uploads/products');
   $upload->file = $_FILES['image'];
   $errors = $upload->upload();


   if(!count($errors)){

     $query = "insert into products (name, description, price, image) values ('$name', '$description', '$price', '$upload->filePath')";
     $mysqli->query($query);
     if($mysqli->error){
       array_push($errors, $mysqli->error);
     }else{
       echo "<script> location.href='index.php' </script>";
     }
    }
  }
?>
<?php include __DIR__.'/../template/error.php' ?>
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
      <label for="image">Image</label>
      <input type="file" name="image">
  </div>

  <div class="form-group">
      <button class="btn btn-success">Create</button>
  </div>
</form>

<?php
include __DIR__.'/../template/footer.php';