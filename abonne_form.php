<?php
require_once 'models.php';
$pageTitle = isset($_GET['id']) ? 'Modifier un abonné' : 'Ajouter un abonné';

$abonne = [
    'id' => '',
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'telephone' => '',
    'date_naissance' => '',
    'adresse' => '',
    'code_postal' => '',
    'ville' => '',
    'pays' => '',
    'photo' => '',
    'type_abonnement' => ''
];

if (isset($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM abonnes WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $abonne = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gestion de l'upload de la photo
    $photo = $abonne['photo'];
    $uploadError = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $uploadDir = 'uploads/abonnes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $filename)) {
            $photo = $filename;
        } else {
            $uploadError = "Erreur lors de l'upload de la photo.";
        }
    }

    // Insertion ou mise à jour
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE abonnes SET nom=?, prenom=?, email=?, telephone=?, date_naissance=?, adresse=?, code_postal=?, ville=?, pays=?, photo=?, type_abonnement=? WHERE id=?");
        $stmt->execute([
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['date_naissance'],
            $_POST['adresse'],
            $_POST['code_postal'],
            $_POST['ville'],
            $_POST['pays'],
            $photo,
            $_POST['type_abonnement'],
            $_POST['id']
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO abonnes (nom, prenom, email, telephone, date_naissance, adresse, code_postal, ville, pays, photo, type_abonnement) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['date_naissance'],
            $_POST['adresse'],
            $_POST['code_postal'],
            $_POST['ville'],
            $_POST['pays'],
            $photo,
            $_POST['type_abonnement']
        ]);
    }
    $_SESSION['flash'] = !empty($_POST['id']) ? "Abonné modifié avec succès !" : "Abonné ajouté avec succès !";
    header('Location: liste_abonnes.php');
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

<div class="container glass" style="max-width:500px;">
    <h1><?php echo isset($_GET['id']) ? 'Modifier' : 'Ajouter'; ?> un abonné</h1>
    <?php if (!empty($uploadError)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($uploadError); ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($abonne['id']); ?>">
        <label class="form-label">Nom</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($abonne['nom']); ?>" required>
        <label class="form-label">Prénom</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($abonne['prenom']); ?>" required>
        <label class="form-label">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($abonne['email']); ?>">
        <label class="form-label">Téléphone</label>
        <input type="text" name="telephone" value="<?php echo htmlspecialchars($abonne['telephone']); ?>">
        <label class="form-label">Date de naissance</label>
        <input type="date" name="date_naissance" value="<?php echo htmlspecialchars($abonne['date_naissance']); ?>">
        <label class="form-label">Adresse</label>
        <input type="text" name="adresse" value="<?php echo htmlspecialchars($abonne['adresse']); ?>">
        <label class="form-label">Code postal</label>
        <input type="text" name="code_postal" value="<?php echo htmlspecialchars($abonne['code_postal']); ?>">
        <label class="form-label">Ville</label>
        <input type="text" name="ville" value="<?php echo htmlspecialchars($abonne['ville']); ?>">
        <label class="form-label">Pays</label>
        <input type="text" name="pays" value="<?php echo htmlspecialchars($abonne['pays']); ?>">
        <label class="form-label">Type d'abonnement</label>
        <select name="type_abonnement" class="form-select">
            <option value="mensuel" <?php if ($abonne['type_abonnement'] == 'mensuel') echo 'selected'; ?>>Mensuel</option>
            <option value="annuel" <?php if ($abonne['type_abonnement'] == 'annuel') echo 'selected'; ?>>Annuel</option>
        </select>
        <label class="form-label">Photo</label>
        <input type="file" name="photo" accept="image/*">
        <?php if (!empty($abonne['photo'])): ?>
            <img src="uploads/abonnes/<?php echo $abonne['photo']; ?>" width="50" height="50">
        <?php endif; ?>
        <button type="submit" class="btn btn-red w-100">Enregistrer</button>
    </form>
    <a href="liste_abonnes.php" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>

<?php include 'footer.php'; ?>

</html>
