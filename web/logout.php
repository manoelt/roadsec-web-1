<?php
require '../vendor/autoload.php';

session_start();

if(session_destroy()) {
  header("Location: login.php");
}
