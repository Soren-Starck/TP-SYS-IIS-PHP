<?php
session_start();
require_once 'config.php';

function authenticate($username, $password) {
    $ldapconn = ldap_connect(LDAP_HOST);
    if (!$ldapconn) {
        error_log("Connexion LDAP échouée", 3, LOG_FILE);
        return false;
    }

    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

    $ldapbind = @ldap_bind($ldapconn, "$username@" . LDAP_DOMAIN, $password);
    if ($ldapbind) {
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        return true;
    } else {
        error_log("Authentification échouée pour $username", 3, LOG_FILE);
        return false;
    }
}

function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
?>