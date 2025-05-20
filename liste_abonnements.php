<?php
require_once 'models.php';
$pageTitle = "Liste des abonnements";
$type = $_GET['type'] ?? '';
if ($type === 'mensuel' || $type === 'annuel') {
    $paiements = array_filter(getPaiements(), function($p) use ($type) {
        return $p['type_abonnement'] === $type;
    });
} else {
    $paiements = getPaiements();
}
include 'header.php';
?>
<div class="container glass">
    <h1>Liste des abonnements</h1>
    <div class="mb-3">
        <a href="?type=mensuel" class="btn btn-outline-danger btn-sm<?php if($type==='mensuel') echo ' active'; ?>">Mensuels</a>
        <a href="?type=annuel" class="btn btn-outline-danger btn-sm<?php if($type==='annuel') echo ' active'; ?>">Annuels</a>
        <a href="liste_abonnements.php" class="btn btn-outline-secondary btn-sm<?php if(!$type) echo ' active'; ?>">Tous</a>
    </div>
    <a href="paiement_form.php" class="btn btn-red mb-3"><i class="bi bi-plus-circle"></i> Ajouter un paiement</a>
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Abonné</th>
                <th>Type</th>
                <th>Mois</th>
                <th>Année</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paiements as $paiement): ?>
                <tr>
                    <td>
                        <?php
                        echo htmlspecialchars(
                            (isset($paiement['abonne_nom']) ? $paiement['abonne_nom'] : '') .
                            ' ' .
                            (isset($paiement['abonne_prenom']) ? $paiement['abonne_prenom'] : '')
                        );
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($paiement['type_abonnement']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['mois']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['annee']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['montant']); ?></td>
                    <td><?php echo htmlspecialchars($paiement['statut']); ?></td>
                    <td>
                        <a href="paiement_form.php?id=<?php echo $paiement['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifier"><i class="bi bi-pencil"></i></a>
                        <a href="supprimer_paiement.php?id=<?php echo $paiement['id']; ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Supprimer ce paiement ?');"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
