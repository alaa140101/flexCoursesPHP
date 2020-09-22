<?php 
$title = 'Products';
$icon = 'cart-plus';
include __DIR__.'/../template/header.php';

$products = $mysqli->query(
  "SELECT * FROM products
  ORDER BY  id;
  ")->fetch_all(MYSQLI_ASSOC);
?>

<div class="card">
  <div class="card-header d-flex align-items-center">
    <h5>Products: <?php echo count($products) ?></h5>
    <a href="create.php" class="ml-auto btn btn-success"><i class="fas fa-plus"></i></a>
  </div>
  <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) : ?>
          <tr>
            <td scope="row"><?php echo $product['id'] ?></td>
            <td><?php echo $product['name'] ?></td>
            <td><?php echo $product['description'] ?></td>
            <td><?php echo $product['price'] ?></td>
            <td><img src="<?php echo $config['app_url'].'/'.$product['image']?>" width="50" hight="60" alt=""></td>
            <td class="form-inline p-1">
              <a href="edit.php?id=<?php echo $product['id'] ?>" class="m-1 btn btn-outline-warning"><i class="far fa-edit"></i></a>
              <form onclick="return confirm('Are you sure?')"   method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                <input type="hidden" name="image" value="<?php echo $product['image'] ?>">
                <button class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>      
    </div>
</div>

 <!-- If delete button pressed -->
<?php 
if (isset($_POST['product_id'])) {
    
  $statment = $mysqli->prepare("DELETE FROM products WHERE id=?");
  $statment->bind_param('i', $productId);
  $productId = $_POST['product_id'];
  $statment->execute();

  if ($_POST['image']) {
    unlink($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . 'flexCourses/1-project/'. $_POST['image']);
  }

  echo "<script> location.href = 'index.php' </script>";
  die();
} 
include __DIR__.'/../template/footer.php';
  
