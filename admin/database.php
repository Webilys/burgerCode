<?php
$dbHost = "localhost";
$dbName = "burger_code";
$dbUser = "priscilla";
$dbUserPassword = "Yoann110712@$";

try {
    //DONNÉES DE BASE DE DONNÉES SUR SERVEUR : 
    // $database = new PDO('mysql:host=db5017023525.hosting-data.io;dbname=dbs13708604; charset=utf8', 'dbu5498364', 'Yoann110712@$');
    $connection = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName . '; charset=utf8', $dbUser, $dbUserPassword);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    die('ERROR:' . $e->getMessage());
}



?>