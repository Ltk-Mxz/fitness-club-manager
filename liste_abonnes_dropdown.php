<?php
require_once 'models.php';
$pageTitle = "Liste déroulante des abonnés";
$abonnes = getAbonnesDropdown();
include 'header.php';
?>
<div class="container glass">
    <h1>Liste déroulante des abonnés</h1>
    <form>
        <select name="abonne_id" class="form-select">
            <?php foreach ($abonnes as $abonne): ?>
                <option value="<?php echo $abonne['id']; ?>">
                    <?php echo htmlspecialchars($abonne['nom'] . ' ' . $abonne['prenom']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>
<?php include 'footer.php'; ?>