<?php
$title = "contact";
require_once 'template/header.php';
include 'includes/uploader.php';
require  'classes/Services.php' ;

$s = new service;
$s ->taxRate =.05;
$services = $mysqli ->query("select * from services order by name" )->fetch_all(MYSQLI_ASSOC)

?>
<?php isset($_SESSION['sender_name']) ? $sender =$_SESSION['sender_name'] : $sender =''  ?>
<p> <?php echo $sender?></p>
<h1> Contact us </h1>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Your name</label>
        <input type="text" name="name" value="<?php if (isset($_SESSION['contact_form']['name'])) echo $_SESSION['contact_form']['name'] ?>" class="form-control" placeholder="Your name">
        <span class="text-danger"><?php echo $nameError ?></span>
    </div>

    <div class="form-group">
        <label for="email">Your email</label>
        <input type="email" name="email" value="<?php if (isset($_SESSION['contact_form']['email'])) echo $_SESSION['contact_form']['email'] ?>" class="form-control" placeholder="Your email">
        <span class="text-danger"><?php echo $emailError ?></span>

    </div>

    <div class="form-group">
        <label for="document">Your document</label>
        <input type="file" name="document" value="<?php if (isset($_SESSION['contact_form']['document'])) echo $_SESSION['contact_form']['document'] ?>"  >
        <span class="text-danger"><?php echo $documentError ?></span>
    </div>
    <div class="form-group">
        <label for="services">services</label>
        <select name="service_id" id="services" class="form-control">
            <?php foreach ($services as $services){?>
                <option value="<?php echo $services['id'] ?>">
                    <?php echo $services['name'] ?>
                    (<?php echo $s->addTax($services['price']) ?> SAR)
            </option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea name="message" class="form-control"  placeholder="Your message"><?php if (isset($_SESSION['contact_form']['message'])) echo $_SESSION['contact_form']['message'] ?></textarea>
        <span class="text-danger"><?php echo $messageError ?></span>
    </div>

    <button class="btn btn-primary">Send</button>


</form>


<?php require_once 'template/footer.php' ?>