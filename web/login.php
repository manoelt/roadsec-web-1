<?php
require '../vendor/autoload.php';

session_start();

if(isset($_SESSION['user'])){
  header("location: admin.php");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  var_dump($_POST);
  if( is_array($_POST['pass']) && (
    isset($_POST['pass']['$ne']) ||
    isset($_POST['pass']['$eq']) ||
    isset($_POST['pass']['$gt']) ||
    isset($_POST['pass']['$gte']) ||
    isset($_POST['pass']['$lt']) ||
    isset($_POST['pass']['$in']) ||
    isset($_POST['pass']['$nin']) ||
    isset($_POST['pass']['$regex'])
  ) ){
    die("Not so easy. Attack detected. Blocked \$eq, \$gt, \$lt, \$ne, \$gte, \$in, \$nin, \$regex");
  }

  $client = new MongoDB\Client("mongodb://localhost:27017");
  $collection = $client->hackaflag->users;

  $results = $collection->findOne(array("user" => $_POST['user'], "pass" => $_POST['pass']));
  var_dump($results);
  if(!is_null($results)){
    $_SESSION['user'] = $results->user;
    header("location: admin.php");
  } else {
    $error = "Failed.";
  }
}?>
<!DOCTYPE html>
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

        <form class="form-login" method="post" action="login.php">
          <h2 class="form-login-heading">Login</h2>
          <label for="inputEmail" class="sr-only">Username</label>
          <input type="text" id="user" name="user" class="form-control" placeholder="User" required autofocus>
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
        </form>

      </div> <!-- /container -->

    </body>
  </html>
