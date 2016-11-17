<?php
require '../vendor/autoload.php';

session_start();

if($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
  die('You are not allowed. Only from 127.0.0.1');
}

$client = new MongoDB\Client("mongodb://localhost:27017");

$collection = $client->hackaflag->urls;

if(isset($_GET['id'])) {
  $results = $collection->findOne(array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])) );
  var_dump($results);
  if(!is_null($results)){
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(
      array("_id" => new MongoDB\BSON\ObjectId($_GET['id'])), array('$set' => array('view' => 1))
    );

    $manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
    $result = $manager->executeBulkWrite('hackaflag.urls', $bulk, $writeConcern);

  }
}
