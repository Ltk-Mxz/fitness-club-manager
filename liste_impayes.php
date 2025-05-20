<?php
require_once 'models.php';
$pageTitle = "Liste des impayés mensuels";
$mois = (int)date('n');
$annee = (int)date('Y');
$impayes = getImpayes($mois, $annee);
include 'header.php';
?>
<div class="container glass">
    <h1>Liste des impayés du mois <?php echo $mois . '/' . $annee; ?></h1>
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Abonné</th>
                <th>Mois</th>
                <th>Année</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($impayes as $impaye): ?>
                <tr>
                    <td>
                        <?php
                        echo htmlspecialchars(
                            (isset($impaye['abonne_nom']) ? $impaye['abonne_nom'] : '') .
                            ' ' .
                            (isset($impaye['abonne_prenom']) ? $impaye['abonne_prenom'] : '')
                        );
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($impaye['mois']); ?></td>
                    <td><?php echo htmlspecialchars($impaye['annee']); ?></td>
                    <td><?php echo htmlspecialchars($impaye['montant']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>
