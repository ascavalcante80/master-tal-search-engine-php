<?php

// Connexion à MySQL

$user = "root";
$pass = "20060907jl";
$bd = "coogle";
$serveur = "localhost";

$sql = new PDO("mysql:host=$serveur;dbname=$bd", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) ;


// Gestion des erreurs

try {

    // Connexion à MySQL
    $sql = new PDO("mysql:host=$serveur;dbname=$bd", $user, $pass);

}
catch (PDOException $e) {

    echo "Erreur de connexion à la base de données " . $e->getMessage() ;

    die();
}
?>
