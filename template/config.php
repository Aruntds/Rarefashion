<?php

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('555856723972-mh37f7jg27tefrij7gps96ncaurvrkog.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('C6hOrUbzJrdrQc-7mDS5H6bS');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://touchmarkdes.space/demo/rarefashions/template/__dashboard.php');

//
$google_client->addScope('email');

$google_client->addScope('profile');

//start session on web page
session_start();

?>