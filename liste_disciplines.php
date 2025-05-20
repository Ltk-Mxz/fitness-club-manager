<?php
require_once 'models.php';
$pageTitle = "Liste des disciplines";
$disciplines = getDisciplines();
include 'header.php';
?>
<div class="container glass">
    <h1>Liste des disciplines</h1>
    <a href="discipline_form.php" class="btn btn-red mb-3"><i class="bi bi-plus-circle"></i> Ajouter une discipline</a>
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($disciplines as $discipline): ?>
                <tr>
                    <td><?php echo htmlspecialchars($discipline['nom']); ?></td>
                    <td><?php echo htmlspecialchars($discipline['description']); ?></td>
                    <td>
                        <a href="discipline_form.php?id=<?php echo $discipline['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifier"><i class="bi bi-pencil"></i></a>
                        <a href="supprimer_discipline.php?id=<?php echo $discipline['id']; ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Supprimer cette discipline ?');"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
