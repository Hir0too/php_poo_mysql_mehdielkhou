<?php
// Inclure le fichier de connexion
include('connection.php');

// Créer une instance de la classe Connection
$connection = new Connection();

// Créer la base de données "poog4"
$connection->createDatabase('poog4');

// Requêtes pour créer les tables
$query0 = "
CREATE TABLE Cities (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cityName VARCHAR(30) NOT NULL
)";

$query = "
CREATE TABLE Clients (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) UNIQUE,
    password VARCHAR(80),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    idCity INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (idCity) REFERENCES Cities(id)
)
";

// Sélectionner la base de données "poog4"
$connection->selectDatabase('poog4');

// Créer les tables avec les requêtes définies
$connection->createTable($query0);
$connection->createTable($query);
?>
