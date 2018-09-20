<?php
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed
$fb = new Facebook\Facebook([
  'app_id' => '879788445536807', // Replace {app-id} with your app id
  'app_secret' => 'Berruezin23',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/php/php/facebook/fb-callback.php', $permissions);
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>