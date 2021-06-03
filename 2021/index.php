<?php $page_title = 'Home'; ?>
<?php require_once __DIR__.'/template/header.php';?>
<?php require 'classes/Service.php' ?>
<?php require 'config/database.php' ?>

<?php $services = new Service; ?>
<?php $products = $mysqli->query("SELECT * FROM products")->fetch_all(MYSQLI_ASSOC); ?>
  <h1>welcome to our website</h1>

  <div class="row">
    <?php foreach($services->all() as $service){ ?>
      <div class="col-md-4">
        <div class="card m-2">
          <h4 class="card-header"><?php echo $service['name'] ?></h4>
          <div class="card-body">
            <p>Price: <?php echo $service['price'] ?></p>
            <p>Work days: <?php foreach($service['days'] as $day){ ?>
            <span><?php echo $day ?></span>
            <?php } ?>
            </p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="row">
  <?php foreach($products as $product) {  ?>
    <div class="col-md-4">
      <div class="card mb-3">
        <img class="card-img-top" src="<?php echo $product['image-url'];?>" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title"><?php echo $product['name'];?></h5>
          <p class="card-text"><?php echo $product['description'];?></p>
          <p class="card-text">Price: <?php echo $product['price'];?></p>
        </div>
      </div>
    </div>
  <?php } ?>
  </div>



<a href="contact.php">Contact Us</a>

<?php require_once __DIR__.'/template/footer.php';?>
  

  