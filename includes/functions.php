<?php
require_once 'config.php';

function createUser($username, $password, $firstName, $lastName, $email)
{
    $ldapconn = ldap_connect(LDAP_HOST);
    if (!$ldapconn) {
        error_log("Connexion LDAP échouée", 3, LOG_FILE);
        return false;
    }

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    $ldapbind = ldap_bind($ldapconn, LDAP_ADMIN_USER, LDAP_ADMIN_PASSWORD);
    if (!$ldapbind) {
        error_log("Authentification échouée pour " . LDAP_ADMIN_USER, 3, LOG_FILE);
        return false;
    }

    $dn = "CN=$firstName $lastName,OU=Users,DC=epul3a,DC=local";
    $userInfo = [
        "cn" => "$firstName $lastName",
        "sn" => $lastName,
        "givenName" => $firstName,
        "sAMAccountName" => $username,
        "userPrincipalName" => "$username@epul3a.local",
        "mail" => $email,
        "displayName" => "$firstName $lastName",
        "userPassword" => $password,
        "objectClass" => ["top", "person", "organizationalPerson", "user"]
    ];

    if (ldap_add($ldapconn, $dn, $userInfo)) {
        $disable = ["userAccountControl" => 514];
        ldap_modify($ldapconn, $dn, $disable);

        ldap_close($ldapconn);
        return true;
    } else {
        error_log("Échec de la création de l'utilisateur : " . ldap_error($ldapconn), 3, LOG_FILE);
        ldap_close($ldapconn);
        return false;
    }
}


function deleteUser($username)
{
    $ldapconn = ldap_connect(LDAP_HOST);
    if (!$ldapconn) {
        error_log("Connexion LDAP échouée", 3, LOG_FILE);
        return false;
    }

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    $ldapbind = @ldap_bind($ldapconn, LDAP_ADMIN_USER, LDAP_ADMIN_PASSWORD);
    if (!$ldapbind) {
        error_log("Connexion LDAP admin échouée", 3, LOG_FILE);
        return false;

    }

    $dn = "CN=$username," . LDAP_BASE_DN;
    if (ldap_delete($ldapconn, $dn)) {
        error_log("Utilisateur $username supprimé avec succès", 3, LOG_FILE);
        return true;
    } else {
        error_log("Échec de la suppression de l'utilisateur $username", 3, LOG_FILE);
        return false;
    }
}

?>