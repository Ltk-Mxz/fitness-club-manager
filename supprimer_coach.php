<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
if (isset($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM coachs WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['flash'] = "Coach supprimé avec succès.";
}
header('Location: liste_coachs.php');
exit;
