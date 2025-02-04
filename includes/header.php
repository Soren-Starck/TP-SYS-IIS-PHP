<?php
require_once 'auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1><?php echo APP_NAME; ?></h1>
    <nav>
        <a href="index.php">Accueil</a> |
        <a href="create_user.php">Créer un utilisateur</a> |
        <a href="edit_user.php">Modifier un utilisateur</a> |
        <a href="delete_user.php">Supprimer un utilisateur</a> |
        <a href="logout.php">Déconnexion</a>
    </nav>
</header>
<main>