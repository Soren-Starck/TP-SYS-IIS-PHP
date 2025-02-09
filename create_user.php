<?php
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $cn = "$prenom $nom";
    $dn = "CN=$cn," . LDAP_BASE_DN;
    $entry = [
        "cn" => $username,
        "givenName" => $prenom,
        "sn" => $nom,
        "mail" => $email,
        "sAMAccountName" => $username,
        "userPassword" => "{MD5}" . base64_encode(pack("H*", md5($password))),
        "objectClass" => ["top", "person", "organizationalPerson", "user"]
    ];

    $ldap_conn = ldap_connect(LDAP_HOST);
    if (!$ldap_conn) {
        die("Erreur : Impossible de se connecter à LDAP.");
    }

    $ldap_bind = ldap_bind($ldap_conn, LDAP_ADMIN_USER, LDAP_ADMIN_PASSWORD);
    if (!$ldap_bind) {
        die("Erreur d'authentification LDAP : " . ldap_error($ldap_conn));
    }

    if (ldap_add($ldap_conn, $dn, $entry)) {
        echo "Utilisateur ajouté avec succès.<br>";
        header("Refresh: 1; url=dashboard.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout : " . ldap_error($ldap_conn) . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Ajouter un Utilisateur</title>
</head>
<body>
<form method="POST">
    <label>Prénom:</label> <input type="text" name="prenom" required><br>
    <label>Nom:</label> <input type="text" name="nom" required><br>
    <label>Nom d'utilisateur:</label> <input type="text" name="username" required><br>
    <label>Email:</label> <input type="email" name="email" required><br>
    <label>Mot de passe:</label> <input type="password" name="password" required><br>
    <button type="submit">Ajouter</button>
</form>
</body>
</html>
