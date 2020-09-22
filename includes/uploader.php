<?php
require_once __DIR__ . '/../config/database.php';
$uploadDir = "uploads";

// فلترة النصوص لمنع الحقن
function filterString($field)
{

    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    if (empty($field)) {
        return false;
    } else {
        return $field;
    }

}

// فلترة الايميل.....
function filterEmail($field)
{
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return $field;
    } else {
        return false;
    }
}

function canUpload($file)
{
    $allowed = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
    ];
    $maxFileSize = 10 * 1024;
    // التحقق من الملفات المزيفة........
    $fileMimeType = mime_content_type($file['tmp_name']);

    $fileSize = $file['size'];

    echo $fileMimeType;

    if (!in_array($fileMimeType, $allowed)) {
        return "File type not allowed";
    };

    //التحقق من حجم الملف.....
    if ($fileSize < $maxFileSize) {
        return 'حجم الملف أكبر من : ' . $maxFileSize;
    }
    return true;
}


// كيف نتعامل مع الحقول المرسلة من النموذج و الملفات.......
/*if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    //echo "<pre>";print_r($_POST); print_r($_FILES); echo "</pre>";
}*/

$nameError = $emailError = $documentError = $messageError = '';
$name = $email = $message = '';

//كيف تستطيع التحقق من أنواع الملفات قبل قبولها......
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = filterString($_POST['name']);
    if (!$name) {
        $_SESSION['contact_form']['name'] = '';
        $nameError = 'Your name is required';
    } else {
        $_SESSION['contact_form']['name'] = $name;

    }

    $email = filterString($_POST['email']);
    if (!$email) {
        $_SESSION['contact_form']['email'] = '';
        $emailError = 'Your email is invalid ';
    } else {
        $_SESSION['contact_form']['email'] = $email;
    }

    $message = filterString($_POST['message']);
    if (!$message) {
        $_SESSION['contact_form']['message'] = '';

        $messageError = 'You must enter message';
    } else {
        $_SESSION['contact_form']['email'] = $message;

    }

    // التحقق من الاميل .....
    /*if(!filterEmail($_POST['email'])){
        die("اميلك خطاء");
    }*/
    // التحقق من الملف المرفوع
    if (isset($_FILES ['document']) && $_FILES['document']['error'] == 0) {
        $canUpload = canUpload($_FILES['document']);
        if ($canUpload === true) {
            echo " You can upload";
            // الرفع الي مجلد محدد
            $uploadDir = "uploads";
            // اذا لم يكن المجلد موجود انشاء مجلد جديد
            if (!is_dir($uploadDir)) {
                umask(0);
                mkdir($uploadDir, 0775);
            }
            // رفع الملف الي المجلد
            $fileName = time() . $_FILES['document']['name'];

            move_uploaded_file($_FILES['document']['tmp_name'], $uploadDir . '/' . $fileName);


        } else {
            $documentError = $canUpload;
        }


    }
    // ف حال عدم وجود اخطاء ارسل الملف بنجاح
   if (!$nameError && !$emailError && !$messageError && !$documentError) {

     $fileName ? $filePath = $uploadDir . '/' . $fileName : $filePath = '';
          $statement = $mysqli->prepare("insert into messages 
          (contact_name, email, document, message , service_id)
          values (?, ?, ?, ?, ?)");
          // string s , integer i , double d , binary b تعرف نوع المتعير
       $statement ->bind_param('ssssi',$dbContactName , $dbEmail, $dbDocument, $dbMessage , $dbServicesId);

       $dbContactName = $name;
       $dbEmail = $email;
       $dbDocument = $fileName;
       $dbMessage = $message;
       $dbServicesId = $_POST['service_id'];

       $statement ->execute();

//        $insertMessage =
//            "insert into messages (contact_name, email, document, message , service_id)" .
//            "values('$name','$email','$fileName','$message'," . $_POST["service_id"] . ")";
//        $mysqli->query($insertMessage);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'Form: ' . $email . "\r\n" .
            'Replay-To: ' . $email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $htmlMessage = '<html><body>';
        $htmlMessage .= '<p style="color: #ff0000;">' . $message . '</p>';
        $htmlMessage .= '</html></body>';

        //if(mail($config['admin_email'], 'لديك رسالة جديدة', $htmlMessage, $headers)){
        header('Location: contact.php');
        die();
    } else {
        echo "خطاء في الارسال";
    }
}