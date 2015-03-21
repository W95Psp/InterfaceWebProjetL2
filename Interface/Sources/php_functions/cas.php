<?php

require_once '../php_functions/SimpleCAS/Autoload.php';
require_once '../php_functions/HTTP/Request2.php';

$options = array('hostname' => 'cas.univ-montp2.fr',
                 'port'     => 443,
                 'uri'      => 'cas');

$protocol = new SimpleCAS_Protocol_Version2($options);

$client = SimpleCAS::client($protocol);
$client->forceAuthentication();

// if (isset($_GET['logout'])) {
//     $client->logout();
// }

if ($client->isAuthenticated()) {
    echo '<h1>Authentication Successful!</h1>
          <p>The user\'s login is '.$client->getUsername().'</p>
          <a href="?logout">Logout</a>';
}
?>