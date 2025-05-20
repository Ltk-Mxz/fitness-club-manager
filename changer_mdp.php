<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$pageTitle = "Changer le mot de passe";
include 'header.php';
?>
<style>
/* Style global pour tous les inputs, selects et textarea */
input[type="text"], input[type="email"], input[type="number"], input[type="date"], input[type="password"], select, textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #c0392b;
    border-radius: 8px;
    margin-bottom: 12px;
    font-size: 1rem;
    background: #fff;
    box-sizing: border-box;
    transition: border 0.2s;
}
input[type="file"] {
    border: none;
    background: none;
    margin-bottom: 12px;
}
input[type="text"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="date"]:focus, input[type="password"]:focus, select:focus, textarea:focus {
    border-color: #ff8a6b;
    outline: none;
}
</style>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new = $_POST['new_password'] ?? '';
    require_once 'db.php';
    $hash = password_hash($new, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password=? WHERE username=?");
    $stmt->execute([$hash, $_SESSION['user']]);
    $_SESSION['flash'] = "Mot de passe modifié avec succès.";
    header('Location: profil.php');
    exit;
}
?>
<div class="container glass" style="max-width:400px;">
    <h1><i class="bi bi-key"></i> Changer le mot de passe</h1>
    <form method="post">
        <label>Nouveau mot de passe :</label>
        <input type="password" name="new_password" class="form-control mb-3" required placeholder="Nouveau mot de passe">
        <button type="submit" class="btn btn-red w-100">Changer</button>
    </form>
</div>
<?php include 'footer.php'; ?>
