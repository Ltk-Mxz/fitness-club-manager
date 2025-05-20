<?php
require_once 'models.php';
$pageTitle = "Liste des équipements";
$equipements = getEquipements();
include 'header.php';
?>
<div class="container glass">
    <h1>Liste des équipements</h1>
    <a href="equipement_form.php" class="btn btn-red mb-3"><i class="bi bi-plus-circle"></i> Ajouter un équipement</a>
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Nom</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipements as $equipement): ?>
                <tr>
                    <td>
                        <?php if (!empty($equipement['photo'])): ?>
                            <img src="uploads/equipements/<?php echo $equipement['photo']; ?>" width="50" height="50">
                        <?php else: ?>
                            <img src="uploads/equipements/default.png" width="50" height="50">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($equipement['nom']); ?></td>
                    <td><?php echo htmlspecialchars($equipement['etat']); ?></td>
                    <td>
                        <a href="equipement_form.php?id=<?php echo $equipement['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifier"><i class="bi bi-pencil"></i></a>
                        <a href="supprimer_equipement.php?id=<?php echo $equipement['id']; ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Supprimer cet équipement ?');"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
