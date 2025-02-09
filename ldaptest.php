<?php
$ldapconn = ldap_connect("ldap://example.com")
or die("Impossible de se connecter au serveur LDAP");
if ($ldapconn) {
echo "Connexion réussie!";
}
?>