<?php $page_title = 'Home'; ?>
<?php require_once __DIR__.'/template/header.php';?>
<?php require 'classes/Service.php' ?>
<?php require 'classes/Product.php' ?>

<?php $services = new Service; ?>
<?php 
  $products = new Product; 
  $products->taxRate = 0.5;
?>


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
    <?php foreach($products::all() as $product){ ?>
      <div class="col-md-4">
        <div class="card m-2">
          <h4 class="card-header"><?php echo $product['name'] ?></h4>
          <div class="card-body">
            <p>Price: <?php echo $products->getTotal($product['price']); ?></p>
            </p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>



<a href="contact.php">Contact Us</a>

<?php require_once __DIR__.'/template/footer.php';?>
  

  