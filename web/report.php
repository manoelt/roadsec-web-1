<?php
require '../vendor/autoload.php';

session_start();

if(!isset($_SESSION['user'])){
  header("location: login.php");
}

if($_SESSION['user'] !== 'admin'){
  die('WTF? Only admin!');
}

if(isset($_GET['url'])) {
  $_url = $_GET['url'];
  if(stristr($_url, "http://127.0.0.1") === false){
    die("We only accept url from http://127.0.0.1");
  }

  $manager = new MongoDB\Driver\Manager("mongodb://mongo:27017");

  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->insert(array("url" => $_url, "view" => 0));
  $manager->executeBulkWrite('hackaflag.urls', $bulk);

  $ok = "URL saved, we are checking.";

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
      }
      if(isset($ok)) {
        echo "<div class='alert alert-success' role='alert'>$ok</div>";
      } ?>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <h3>Report an issue</h3>
          <p> This is a feature to report a problem to our sysadmin! We first check automatically. </p>
          <h3> Follow the rules: </h3>
          <ul>
            <li>We only accept url from http://127.0.0.1 </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <form action="report.php" method="GET">
            <input type="text" name="url" id="url">
            <input type="submit" value="Send" name="submit">
          </form>
        </div>
      </div>

    </div>
  </body>
</html>
