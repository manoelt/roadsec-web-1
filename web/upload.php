<?php
require '../vendor/autoload.php';

session_start();

if(!isset($_SESSION['user'])){
  header("location: login.php");
}

if($_SESSION['user'] !== 'admin'){
  die('WTF? Only admin!');
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    if($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
      die('You are not allowed. Only from 127.0.0.1');
    }

    $ok = 1;
    $dir  = "uploads/";
    $_file = $dir . basename($_FILES["file"]["name"]);

    if(strlen(basename($_FILES["file"]["name"])) < 10) {
      $ok = 0;
      $error = 'WTF! More than 10 chars';
    }

    if ($_FILES["file"]["size"] > 700000) {
        $error.= "TOOOOOOO LAAAAAARRGE";
        $ok = 0;
    }

    if (file_exists($_file)) {
      $error .= "Again? Already exist.";
      $ok = 0;
    }

    $extension = @explode('.', $_FILES['file']['name']);
    $extension = @end($extension);

    if($extension === '' || $extension === 'php' || $extension === 'htaccess' || $extension == 'html' || $extension == 'xhtml') {
      $error.= "Improper extension.";
      $ok = 0;
    }

    if($ok) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $_file)) {
            echo "The file ". htmlentities(basename( $_FILES["file"]["name"]), ENT_QUOTES). " has been uploaded.";
            die();
        } else {
            $error.= "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin only</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <?php if(isset($error)) {
        echo "<div class='alert alert-danger' role='alert'>$error</div>";
      } ?>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <h3>Upload File System</h3>
          <p> This is a feature to upload files to our server. Be careful! </p>
          <h3> Follow the rules: </h3>
          <ul>
            <li>.php .html .xhtml .htaccess is not allowed!</li>
            <li>Only from 127.0.0.1 you could upload a file!</li>
            <li>Filename must have more than 10 chars!</li>
            <li>Max size: 700000 bytes</li>
            <li>Your file will be at /uploads dir</li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" id="file">
            <input type="submit" value="Send" name="submit">
          </form>
        </div>
      </div>

    </div>
  </body>
</html>
