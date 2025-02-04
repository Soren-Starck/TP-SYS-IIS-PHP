<?php
require_once 'includes/auth.php';
require_once 'includes/header.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}
?>

    <h1>Tableau de bord</h1>
    <p>Bienvenue, <?php echo $_SESSION['username']; ?>!</p>
    <a href="create_user.php">Créer un utilisateur</a> |
    <a href="edit_user.php">Modifier un utilisateur</a> |
    <a href="delete_user.php">Supprimer un utilisateur</a> |
    <a href="logout.php">Se déconnecter</a>

<?php require_once 'includes/footer.php'; ?>