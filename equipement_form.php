<?php
require_once 'models.php';
$pageTitle = isset($_GET['id']) ? 'Modifier un équipement' : 'Ajouter un équipement';

$equipement = [
    'id' => '',
    'nom' => '',
    'photo' => '',
    'etat' => ''
];

if (isset($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM equipements WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $equipement = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $photo = $equipement['photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/equipements/' . $filename);
        $photo = $filename;
    }

    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE equipements SET nom=?, photo=?, etat=? WHERE id=?");
        $stmt->execute([
            $_POST['nom'],
            $photo,
            $_POST['etat'],
            $_POST['id']
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO equipements (nom, photo, etat) VALUES (?, ?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $photo,
            $_POST['etat']
        ]);
    }
    header('Location: liste_equipements.php');
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
    <h1><?php echo isset($_GET['id']) ? 'Modifier' : 'Ajouter'; ?> un équipement</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($equipement['id']); ?>">
        <label>Nom: <input type="text" name="nom" value="<?php echo htmlspecialchars($equipement['nom']); ?>" required></label><br>
        <label>Photo:
            <input type="file" name="photo" accept="image/*">
            <?php if (!empty($equipement['photo'])): ?>
                <img src="uploads/equipements/<?php echo $equipement['photo']; ?>" width="50" height="50">
            <?php endif; ?>
        </label><br>
        <label>État:
            <select name="etat">
                <option value="bon" <?php if ($equipement['etat'] == 'bon') echo 'selected'; ?>>Bon</option>
                <option value="moyen" <?php if ($equipement['etat'] == 'moyen') echo 'selected'; ?>>Moyen</option>
                <option value="mauvais" <?php if ($equipement['etat'] == 'mauvais') echo 'selected'; ?>>Mauvais</option>
            </select>
        </label><br>
        <button type="submit">Enregistrer</button>
    </form>
    <a href="liste_equipements.php" class="btn btn-red mt-3">Retour à la liste</a>
</div>

<?php include 'footer.php'; ?>

</html>
