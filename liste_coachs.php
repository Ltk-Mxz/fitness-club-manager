<?php
require_once 'models.php';
$pageTitle = "Liste des coachs";
$coachs = getCoachs();
include 'header.php';
?>
<div class="container glass">
    <h1>Liste des coachs</h1>
    <a href="coach_form.php" class="btn btn-red mb-3"><i class="bi bi-person-plus"></i> Ajouter un coach</a>
    <button onclick="window.print()" class="btn btn-red mb-3"><i class="bi bi-printer"></i> Imprimer</button>
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Nom</th>
                <th>Spécialité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($coachs as $coach): ?>
                <tr>
                    <td>
                        <?php
                        $imgPath = 'uploads/coachs/' . ($coach['photo'] ?? '');
                        if (!empty($coach['photo']) && file_exists($imgPath)) {
                            echo '<img src="' . $imgPath . '" class="rounded-circle border" width="50" height="50">';
                        } else {
                            echo '<img src="uploads/coachs/default.png" class="rounded-circle border" width="50" height="50">';
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($coach['nom']); ?></td>
                    <td><?php echo $coach['specialite']; ?></td>
                    <td>
                        <a href="coach_form.php?id=<?php echo $coach['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifier"><i class="bi bi-pencil"></i></a>
                        <a href="supprimer_coach.php?id=<?php echo $coach['id']; ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Supprimer ce coach ?');"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
