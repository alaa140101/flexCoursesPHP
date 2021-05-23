<?php $title = 'Home' ?>

<?php require 'config/app.php' ?>
<?php require_once 'template/header.php' ?>
<?php require 'classes/Services.php' ?>
<?php require 'classes/Products.php' ?>
<?php require_once 'config/database.php' ?>



<?php $products = $mysqli->query('SELECT * FROM products;')->fetch_all(MYSQLI_ASSOC) ?>


<div class="row">
  <?php foreach($products as $product) { ?>    
    <div class="col-md-4">
      <div class="card mb-3">
        <div class="custom-card-image" style="background-image: url(<?php echo $config['app_url'].$product['image'] ?>)"></div>                
        <div class="card-body text-center">
          <h4 class="card-title"><?php echo $product['name'] ?></h4>
            <div><?php echo $product['description'] ?></div>
            <div class="text-success"><?php echo $product['price'] ?> SAR</div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<?php $mysqli->close() ?>
<?php require_once 'template/footer.php' ?>