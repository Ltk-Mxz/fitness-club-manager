<?php
require_once 'models.php';
$pageTitle = isset($_GET['id']) ? 'Modifier un coach' : 'Ajouter un coach';

$coach = [
    'id' => '',
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'telephone' => '',
    'specialite' => '',
    'date_embauche' => '',
    'photo' => ''
];

if (isset($_GET['id'])) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM coachs WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $coach = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gestion de l'upload de la photo
    $photo = $coach['photo'];
    $uploadError = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $uploadDir = 'uploads/coachs/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $filename)) {
            $photo = $filename;
        } else {
            $uploadError = "Erreur lors de l'upload de la photo.";
        }
    }

    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE coachs SET nom=?, prenom=?, email=?, telephone=?, specialite=?, date_embauche=?, photo=? WHERE id=?");
        $stmt->execute([
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['specialite'],
            $_POST['date_embauche'],
            $photo,
            $_POST['id']
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO coachs (nom, prenom, email, telephone, specialite, date_embauche, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['telephone'],
            $_POST['specialite'],
            $_POST['date_embauche'],
            $photo
        ]);
    }
    header('Location: liste_coachs.php');
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
    <h1><?php echo isset($_GET['id']) ? 'Modifier' : 'Ajouter'; ?> un coach</h1>
    <?php if (!empty($uploadError)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($uploadError); ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($coach['id']); ?>" class="form-control">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" value="<?php echo htmlspecialchars($coach['nom']); ?>" required class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" value="<?php echo htmlspecialchars($coach['prenom']); ?>" required class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($coach['email']); ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="telephone" value="<?php echo htmlspecialchars($coach['telephone']); ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Spécialité</label>
            <input type="text" name="specialite" value="<?php echo htmlspecialchars($coach['specialite']); ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Date d'embauche</label>
            <input type="date" name="date_embauche" value="<?php echo htmlspecialchars($coach['date_embauche']); ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" accept="image/*" class="form-control">
            <?php if (!empty($coach['photo'])): ?>
                <img src="uploads/coachs/<?php echo $coach['photo']; ?>" width="50" height="50">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-red w-100">Enregistrer</button>
    </form>
    <a href="liste_coachs.php" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>

<?php include 'footer.php'; ?>
