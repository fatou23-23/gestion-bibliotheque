<?php
$host = 'localhost'; // Adresse du serveur
$dbname = 'projet_bibliothèque'; // Nom de la base
$username = 'root'; // Utilisateur de la base
$password = ''; // Mot de passe de l'utilisateur

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
