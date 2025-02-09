<?php
define('LDAP_HOST', 'ldap://votre-serveur-ldap');
define('LDAP_DOMAIN', 'votre-domaine.local');
define('LDAP_BASE_DN', 'OU=Utilisateurs,DC=votre-domaine,DC=local');
define('LDAP_ADMIN_USER', 'admin@votre-domaine.local');
define('LDAP_ADMIN_PASSWORD', 'votre-mot-de-passe');

define('APP_NAME', 'Gestion des Utilisateurs AD');
define('LOG_FILE', __DIR__ . '/../logs/app.log');

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>