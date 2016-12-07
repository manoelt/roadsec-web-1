<?php
require '../vendor/autoload.php';

session_start();

if($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
  die('You are not allowed. Only from 127.0.0.1');
}

$client = new MongoDB\Client("mongodb://mongo:27017");

$collection = $client->hackaflag->urls;

$results = $collection->find(array("view" => 0));
$content = '<html><body>';
foreach ($results as $url) {
  $content .= '<div class="r"><a href="'.htmlentities($url['url']).'" class="link">Report '.$url->_id.'</a><a href="http://127.0.0.1/hide.php?id='.$url->_id.'" class="link">Hide</a></div>';
}
$content .= '</body><script src="js/jquery.js"></script></html>';

echo $content;
