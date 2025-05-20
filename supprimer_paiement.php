<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
if (isset($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM paiements WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['flash'] = "Paiement supprimé avec succès.";
}
header('Location: liste_abonnements.php');
exit;
