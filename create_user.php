<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (createUser($username, $password, $firstName, $lastName, $email)) {
        $success = "Utilisateur créé avec succès!";
    } else {
        $error = "Échec de la création de l'utilisateur.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un utilisateur</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h1>Créer un utilisateur</h1>
<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <label for="firstName">Prénom:</label>
    <input type="text" id="firstName" name="firstName" required>
    <br>
    <label for="lastName">Nom:</label>
    <input type="text" id="lastName" name="lastName" required>
    <br>
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <button type="submit">Créer</button>
</form>
</body>
</html>