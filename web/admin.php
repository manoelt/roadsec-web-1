<?php
require '../vendor/autoload.php';

session_start();

if(!isset($_SESSION['user'])){
  header("location: login.php");
}

if($_SESSION['user'] !== 'admin'){
  die('WTF? Only admin!');
} ?>

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
      <h2> Welcome, Admin! </h2>
      <div class="col-md-12">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <h2> Choose one: </h2>
          <div class="list-group">
              <a class="list-group-item" href="upload.php">Upload a file</a>
              <a class="list-group-item" href="report.php">Report an issue</a>
              <a class="list-group-item" href="logout.php">Logout</a>
          </div>
        </div>

      </div>
    </div>
  </body>
</html>
