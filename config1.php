<?php

require_once 'vendor/autoload.php';

if (!session_id())
{
    session_start();
}

// Call Facebook API

$facebook = new \Facebook\Facebook([
  'app_id'      => '520370032591578',
  'app_secret'     => '6a2a2564ad6b0acf460688398147b1f1',
  'default_graph_version'  => 'v2.10'
]);

?>