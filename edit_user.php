<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    // Connexion LDAP
    $ldapconn = ldap_connect(LDAP_HOST);
    if (!$ldapconn) {
        error_log("Connexion LDAP échouée", 3, LOG_FILE);
        $error = "Connexion LDAP échouée";
    } else {
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

        // Authentification admin
        $ldapbind = @ldap_bind($ldapconn, LDAP_ADMIN_USER, LDAP_ADMIN_PASSWORD);
        if (!$ldapbind) {
            error_log("Connexion LDAP admin échouée", 3, LOG_FILE);
            $error = "Connexion LDAP admin échouée";
        } else {
            // Recherche de l'utilisateur
            $dn = "CN=$firstName $lastName," . LDAP_BASE_DN;
            $entry = [
                'givenName' => $firstName,
                'sn' => $lastName,
                'mail' => $email,
            ];

            // Mise à jour de l'utilisateur
            if (ldap_modify($ldapconn, $dn, $entry)) {
                $success = "Utilisateur modifié avec succès!";
            } else {
                $error = "Échec de la modification de l'utilisateur.";
                error_log("Échec de la modification de l'utilisateur $username", 3, LOG_FILE);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h1>Modifier un utilisateur</h1>
<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="firstName">Prénom:</label>
    <input type="text" id="firstName" name="firstName" required>
    <br>
    <label for="lastName">Nom:</label>
    <input type="text" id="lastName" name="lastName" required>
    <br>
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <button type="submit">Modifier</button>
</form>
<br>
<a href="index.php">Retour au tableau de bord</a>
</body>
</html>