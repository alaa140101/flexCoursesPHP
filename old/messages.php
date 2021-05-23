<?php $title = 'Messages' ?>
<?php require_once 'template/header.php'; 
      require 'config/app.php';
      require_once 'config/database.php'; ?>

<?php $statment = $mysqli->prepare(
    "SELECT *, m.id as message_id, s.id as service_id FROM messages m LEFT JOIN services s ON m.service_id = s.id
    ORDER BY m.id LIMIT ?");
  $statment->bind_param('i', $limit);
  isset($_GET['limit']) ? $limit = $_GET['limit'] : $limit = '5';
  $statment->execute();
  $messages = $statment->get_result()->fetch_all(MYSQLI_ASSOC); ?>

<?php if(!isset($_GET['id'])){ ?>

<h2>Recieved Messages</h2>
  <table class="table table-dark">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Sender name</th>
        <th scope="col">Sender email</th>
        <th scope="col">Service</th>
        <th scope="col">Document</th>
        <th scope="col">Message</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
  
<?php foreach($messages as $message){  ?>
  <tr>
    <td scope="row"><?php echo $message['message_id'] ?></td>
    <td><?php echo $message['contact_name'] ?></td>
    <td><?php echo $message['email'] ?></td>
    <td><?php echo $message['name'] ?></td>
    <td><?php echo $message['document'] ?></td>
    <td><?php echo $message['message'] ?></td>
    <td>
      <a href="?id=<?php echo $message['message_id'] ?>" class="btn btn-sm btn-primary">view</a>
      <form onsubmit="return confirm('Are you sure?')" action="" style='display: inline-block' method="post">
        <input type="hidden" name="message_id" value="<?php echo $message['message_id'] ?>">
        <button class="btn btn-sm btn-danger">Delete</button>
      </form>
    </td>
  </tr> <?php } ?>
  </tbody>
</table>

<?php }else{
  $messageQuery = "SELECT * FROM messages m 
                  LEFT JOIN services s ON m.service_id = s.id 
                  WHERE m.id=".$_GET['id'].
                  " LIMIT 1";
  $message = $mysqli->query($messageQuery)->fetch_array(MYSQLI_ASSOC); ?>

<div class="card">
  <h5 class="card-header">Message from: <?php echo $message['contact_name'] ?>
  <div class="small"><?php echo $message['email']?> </div>
  </h5>
  <div class="card-body">
    <div>
      Service: <?php echo $message['name'] ?  $message['name'] : 'No service' ?>
    </div>
    <?php echo $message['message'] ?>
  </div>
  <?php if($message['document']) { ?>
  <div class="card-footer">
    Attachment: 
    <a href="<?php
               echo $config['app_url']
               .$config['upload_dir']
               .$message['document']?>">Download Attachment</a>
  </div>
  <?php } ?>
</div>
<?php } 
 if (isset($_POST['message_id'])) {
  $statment = $mysqli->prepare("DELETE FROM messages WHERE id=?");
  
  $statment->bind_param('i', $messageId);
  $messageId = $_POST['message_id'];
  $statment->execute();


  if ($_POST['document']) {
    unlink($config['upload_dir'].$_POST['document']);
  }
  echo "<script> location.href = 'messages.php' </script>";
  die();
} ?>

<?php require_once 'template/footer.php' ?>
