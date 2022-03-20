<?php
require_once 'vendor/autoload.php';

$clientID = '992610191898-r6o3ufkfho4u9kenab1het7gotollual.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrl = 'http://localhost/cimalab/index.php';

$google_client = new Google_Client();
$google_client -> setClientId($clientID);
$google_client -> setClientSecret($clientSecret);
$google_client -> setRedirectUri($redirectUrl);
$google_client -> addScope('email');
$google_client -> addScope('profile');

session_start();
$_SESSION["IsOnLab"] = false;


