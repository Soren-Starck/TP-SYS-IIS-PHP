<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    if (deleteUser($username)) {
        $success = "Utilisateur supprimé avec succès!";
    } else {
        $error = "Échec de la suppression de l'utilisateur.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un utilisateur</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h1>Supprimer un utilisateur</h1>
<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <button type="submit">Supprimer</button>
</form>
<br>
<a href="index.php">Retour au tableau de bord</a>
</body>
</html>