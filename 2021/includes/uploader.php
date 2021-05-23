<?php 
$uploadDir  = 'uploads';
// $_SESSION['username'] = '';


  function filterString($field) {
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    return $field;
  }

  function filterEmail($field) {
    
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);

    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
      return $field;
    }else{
      return FALSE;
    }
  }

  function canUpload($file) {
    $allowed = [
      'jpg' => 'image/jpeg',
      'png' => 'image/png',
      'gif' => 'image/gif'
    ];

    $maxFileSize = 1000 * 1024;

    $fileMimeType = mime_content_type($file['tmp_name']);
    $fileSize = $file['size'];
    
    if (!in_array($fileMimeType, $allowed)) return "File type not allowed";
    if($fileSize > $maxFileSize) return "File size should be less than". $maxFileSize;

    return true;
  }

  $nameError = $emailError = $docError = $messageError = '';
  $name = $email = $doc = $message = '';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {    

    $name = filterString($_POST['name']);
    
    if (!$name) {
      $_SESSION['contact_form']['name'] = '';
      $nameError = 'Your name is required';
    }else{
      $_SESSION['contact_form']['name'] = $name;
    }

    $email = filterEmail($_POST['email']);
    if (!$email) {
      $_SESSION['contact_form']['email'] = '';
      $emailError = 'Not valid email input';
    }else{
      $_SESSION['contact_form']['email'] = $email;
    }

    $message = filterString($_POST['message']);
    if (!$message) {
      $_SESSION['contact_form']['message'] = '';
      $messageError = 'Your message is required';
    }else{
      $_SESSION['contact_form']['message'] = $message;
    }

   if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
    
    $uploadable = canUpload($_FILES['document']);

    if ($uploadable === true) {     
      
      if (!is_dir($uploadDir)) {
        umask(0);
        mkdir($uploadDir, 0775);
      }

      $fileName = time().$_FILES['document']['name'];

      if (file_exists($uploadDir.'/'.$fileName)) {
        $docError = 'File already exists';
      }else{
        move_uploaded_file($_FILES['document']['tmp_name'], $uploadDir.'/'.$fileName);
      }

    }else{
      $docError = $uploadable;
    }
   }
   if (!$nameError && !$emailError && !$docError && !$messageError) {
     echo 'your form is submitted';
     // unset($_SESSION['contact_form']);
     session_destroy();
     header('Location: index.php');
     exit();
    //  die();
   }
  }
