<?php
require_once 'includes/auth.php';
require_once 'includes/config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Function to fetch all users from LDAP
function getAllUsers()
{
    $ldapconn = ldap_connect(LDAP_HOST);
    if (!$ldapconn) {
        error_log("Connexion LDAP échouée", 3, LOG_FILE);
        return false;
    }

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    // Bind with admin user to perform search
    $ldapbind = ldap_bind($ldapconn, LDAP_ADMIN_USER, LDAP_ADMIN_PASSWORD);
    if (!$ldapbind) {
        error_log("Authentification échouée pour " . LDAP_ADMIN_USER, 3, LOG_FILE);
        ldap_close($ldapconn);
        return false;
    }

    // Search for all users under the Base DN
    $search = ldap_search($ldapconn, LDAP_BASE_DN, "(objectClass=user)");
    if (!$search) {
        error_log("Échec de la recherche LDAP", 3, LOG_FILE);
        ldap_close($ldapconn);
        return false;
    }

    // Get the entries
    $entries = ldap_get_entries($ldapconn, $search);
    ldap_close($ldapconn);

    return $entries;
}

// Get users from LDAP
$users = getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Utilisateurs</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h1>Liste des utilisateurs</h1>

<?php if ($users && $users['count'] > 0): ?>
    <table border="1">
        <thead>
        <tr>
            <th>Nom d'utilisateur</th>
            <th>Nom complet</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <?php if (isset($user['samaccountname'])): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['samaccountname'][0]); ?></td>
                    <td>
                        <?php
                        // Check if 'displayname' is set before attempting to access it
                        echo isset($user['displayname'][0]) ? htmlspecialchars($user['displayname'][0]) : 'Nom complet non défini';
                        ?>
                    </td>
                    <td>
                        <?php
                        // Check if 'mail' is set before attempting to access it
                        echo isset($user['mail'][0]) ? htmlspecialchars($user['mail'][0]) : 'Email non défini';
                        ?>
                    </td>
                    <td>
                        <a href="tpLdap/edit_user.php?username=<?php echo urlencode($user['samaccountname'][0]); ?>">Modifier</a>
                        |
                        <a href="tpLdap/delete_user.php?username=<?php echo urlencode($user['samaccountname'][0]); ?>"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun utilisateur trouvé.</p>
<?php endif; ?>

</body>
</html>
