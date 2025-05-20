<?php
require_once 'models.php';
$pageTitle = "Enregistrer un paiement";
$abonnes = getAbonnesDropdown();
$mois = date('n');
$annee = date('Y');
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $pdo;
    $datePaiement = date('Y-m-d');
    $moisInt = (int)date('n', strtotime($datePaiement));
    $anneeInt = (int)date('Y', strtotime($datePaiement));
    $stmt = $pdo->prepare("INSERT INTO paiements (abonne_id, date_paiement, montant, type_abonnement, mois, annee, statut) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['abonne_id'],
        $datePaiement,
        $_POST['montant'],
        $_POST['type_abonnement'],
        $moisInt,
        $anneeInt,
        $_POST['statut']
    ]);
    $message = "Paiement enregistré avec succès.";
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
    <h1><i class="bi bi-cash-coin"></i> Enregistrer un paiement</h1>
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Abonné</label>
            <select name="abonne_id" class="form-select" required>
                <?php foreach ($abonnes as $abonne): ?>
                    <option value="<?php echo $abonne['id']; ?>">
                        <?php echo htmlspecialchars($abonne['nom'] . ' ' . $abonne['prenom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Type d'abonnement</label>
            <select name="type_abonnement" class="form-select" required>
                <option value="mensuel">Mensuel</option>
                <option value="annuel">Annuel</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Mois</label>
            <input type="number" name="mois" class="form-control" min="1" max="12" value="<?php echo $mois; ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Année</label>
            <input type="number" name="annee" class="form-control" min="2000" max="2100" value="<?php echo $annee; ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Montant</label>
            <input type="number" name="montant" class="form-control" min="0" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Statut</label>
            <select name="statut" class="form-select" required>
                <option value="paye">Payé</option>
                <option value="impaye">Impayé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-red w-100">Enregistrer</button>
    </form>
    <a href="liste_abonnements.php" class="btn btn-secondary mt-3">Retour à la liste des abonnements</a>
</div>
<?php include 'footer.php'; ?>
