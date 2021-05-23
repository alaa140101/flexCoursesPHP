<?php $page_title = 'Contact'; ?>
<?php 
require_once __DIR__.'/template/header.php';
include_once 'includes/uploader.php';
?>

<?php isset($_SESSION['username']) ? $sender = $_SESSION['username'] : $sender = '';?>
<p><?php echo $sender;?></p>
<h1>Contact Us</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="name">Name: </label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Jone doe" value="<?php if(isset($_SESSION['contact_form']['name'])) echo $_SESSION['contact_form']['name']; ?>">
    <span class="text-danger"><?php echo $nameError; ?></span>
  </div>  
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" value="<?php if(isset($_SESSION['contact_form']['email'])) echo $_SESSION['contact_form']['email']; ?>">
    <span class="text-danger"><?php echo $emailError; ?></span>
  </div>  
  <div class="form-group">
    <label for="document">Upload your file</label>
    <input type="file" class="form-control-file" name="document" id="document" value="<?php echo $document; ?>">
    <span class="text-danger"><?php echo $docError; ?></span>
  </div>
  <div class="form-group">
    <label for="message">Comments: </label>
    <textarea class="form-control" name="message" id="message" rows="3"><?php if(isset($_SESSION['contact_form']['message'])) echo $_SESSION['contact_form']['message'];?></textarea>
    <span class="text-danger"><?php echo $messageError; ?></span>
  </div>
  <button class="btn btn-primary">Send</button>
</form>


<?php require_once __DIR__.'/template/footer.php';?>
  

  