<?php
$host = 'localhost'; // ou l'adresse IP du serveur MariaDB
$dbname = 'test'; // nom de votre base de données
$username = 'root'; // nom d'utilisateur MariaDB
$password = 'legO2005'; // mot de passe pour l'utilisateur
try {
 // Création d'une instance PDO pour la connexion à la base de données
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// Configuration du mode d'erreur de PDO pour les exceptions
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Connexion réussie à MariaDB avec PDO!";
} catch (PDOException $e) {
echo "Échec de la connexion : " . $e->getMessage();
}
?>