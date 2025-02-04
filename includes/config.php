<?php
define('LDAP_HOST', 'ldap://votre-serveur-ldap'); // Remplacez par l'adresse de votre serveur LDAP
define('LDAP_DOMAIN', 'votre-domaine.local'); // Domaine Active Directory
define('LDAP_BASE_DN', 'OU=Utilisateurs,DC=votre-domaine,DC=local'); // Base DN de l'OU
define('LDAP_ADMIN_USER', 'admin@votre-domaine.local'); // Utilisateur admin pour les opérations LDAP
define('LDAP_ADMIN_PASSWORD', 'votre-mot-de-passe'); // Mot de passe de l'admin

define('APP_NAME', 'Gestion des Utilisateurs AD');
define('LOG_FILE', __DIR__ . '/../logs/app.log');

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>