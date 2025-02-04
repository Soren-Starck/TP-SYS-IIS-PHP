<?php
require_once 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (authenticate($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h1>Connexion</h1>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Se connecter</button>
</form>
</body>
</html>