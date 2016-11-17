<?php
require '../vendor/autoload.php';

session_start();

if(isset($_SESSION['user'])){
  header("location: admin.php");
}

header("location: login.php");
