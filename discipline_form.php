<?php
require_once 'models.php';
$pageTitle = isset($_GET['id']) ? 'Modifier une discipline' : 'Ajouter une discipline';

$discipline = [
    'id' => '',
    'nom' => '',
    'description' => ''
];

if (isset($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM disciplines WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $discipline = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE disciplines SET nom=?, description=? WHERE id=?");
        $stmt->execute([
            $_POST['nom'],
            $_POST['description'],
            $_POST['id']
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO disciplines (nom, description) VALUES (?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $_POST['description']
        ]);
    }
    header('Location: liste_disciplines.php');
    exit;
}

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

<div class="container glass">
    <h1><?php echo isset($_GET['id']) ? 'Modifier' : 'Ajouter'; ?> une discipline</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($discipline['id']); ?>">
        <label>Nom: <input type="text" name="nom" value="<?php echo htmlspecialchars($discipline['nom']); ?>" required></label><br>
        <label>Description:<br>
            <textarea name="description" rows="4" cols="40"><?php echo htmlspecialchars($discipline['description']); ?></textarea>
        </label><br>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="liste_disciplines.php" class="btn btn-red mt-3">Retour à la liste</a>
</div>

<?php include 'footer.php'; ?>
