<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$pageTitle = "Mon profil";
include 'header.php';
?>
<div class="container glass">
    <h1>Mon profil</h1>
    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user']); ?> !</p>
</div>
<?php include 'footer.php'; ?>
