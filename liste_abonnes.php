<?php
require_once 'models.php';
$pageTitle = "Liste des abonnés";
$abonnes = getAbonnes();
include 'header.php';
?>
<div class="container glass">
    <h1><i class="bi bi-people-fill"></i> Liste des abonnés</h1>
    <a href="abonne_form.php" class="btn btn-red mb-3"><i class="bi bi-person-plus-fill"></i> Ajouter un abonné</a>
    <table class="table table-hover align-middle mt-2">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Nom</th>
                <th>Âge</th>
                <th>Type d'abonnement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($abonnes as $abonne): ?>
                <tr>
                    <td>
                        <?php
                        $imgPath = 'uploads/abonnes/' . $abonne['photo'];
                        if (!empty($abonne['photo']) && file_exists($imgPath)) {
                            echo '<img src="' . $imgPath . '" class="rounded-circle border" width="50" height="50">';
                        } else {
                            echo '<img src="uploads/abonnes/default.png" class="rounded-circle border" width="50" height="50">';
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($abonne['nom']); ?></td>
                    <td>
                        <?php
                        $age = '';
                        if (!empty($abonne['date_naissance'])) {
                            $birth = new DateTime($abonne['date_naissance']);
                            $today = new DateTime();
                            $age = $today->diff($birth)->y;
                        }
                        echo $age;
                        ?>
                    </td>
                    <td>
                        <span class="badge bg-danger-subtle text-danger-emphasis">
                            <?php echo isset($abonne['type_abonnement']) ? $abonne['type_abonnement'] : ''; ?>
                        </span>
                    </td>
                    <td>
                        <a href="abonne_form.php?id=<?php echo $abonne['id']; ?>" class="btn btn-sm btn-outline-primary" title="Modifier"><i class="bi bi-pencil"></i></a>
                        <a href="supprimer_abonne.php?id=<?php echo $abonne['id']; ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Supprimer cet abonné ?');"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
