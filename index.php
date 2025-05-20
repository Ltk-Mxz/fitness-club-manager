<?php
require_once 'models.php';
$pageTitle = "Dashboard";

// Récupération des indicateurs
$nbAbonnes = count(getAbonnes());
$nbCoachs = count(getCoachs());
$nbEquipements = count(getEquipements());
$mois = (int)date('n');
$annee = (int)date('Y');
$nbImpayes = count(getImpayes($mois, $annee));

include 'header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Fitness Club</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Montserrat', Arial, sans-serif;
            /* background: linear-gradient(120deg, #ffd1c1 0%, #ff8a6b 100%); */
        }
        .site-title {
            text-align: center;
            font-size: 2.5rem;
            color: #c0392b;
            margin-top: 38px;
            margin-bottom: 18px;
            font-family: 'Montserrat', Arial, sans-serif;
            letter-spacing: 1px;
            font-weight: 700;
        }
        .dashboard-container {
            background: rgba(255,255,255,0.35);
            border-radius: 28px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
            max-width: 1200px;
            margin: 40px auto 0 auto;
            padding: 40px 36px 32px 36px;
            text-align: center;
        }
        .welcome {
            font-size: 1.18rem;
            color: #444;
            margin-bottom: 28px;
        }
        .dashboard-links {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-top: 18px;
        }
        .dashboard-links a {
            display: block;
            padding: 14px 0;
            background: #c0392b;
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            font-size: 1.13rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .dashboard-links a:hover {
            background: #a93226;
        }
        @media (max-width: 600px) {
            .dashboard-container {
                padding: 22px 6px 18px 6px;
                max-width: 98vw;
            }
            .site-title {
                font-size: 2rem;
            }
        }
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 32px;
            justify-content: center;
            margin-top: 32px;
            width: 100%;
        }
        .stat-card {
            background: rgba(255,255,255,0.7);
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(200,35,51,0.07);
            padding: 32px 28px 24px 28px;
            min-width: 180px;
            text-align: center;
            margin-bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .stat-card .stat-icon {
            font-size: 2.3rem;
            color: #c0392b;
            margin-bottom: 10px;
        }
        .stat-card .stat-value {
            font-size: 2.1rem;
            font-weight: 700;
            color: #c0392b;
        }
        .stat-card .stat-label {
            font-size: 1.08rem;
            color: #444;
            margin-top: 6px;
        }
        @media (max-width: 900px) {
            .dashboard-container {
                max-width: 98vw;
                padding: 22px 6px 18px 6px;
            }
            .stats-row {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 18px;
            }
        }
        @media (max-width: 600px) {
            .stats-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .stat-card {
                min-width: unset;
                padding: 22px 10px 16px 10px;
            }
        }
        .chart-container {
            background: rgba(255,255,255,0.7);
            border-radius: 18px;
            margin: 32px auto 0 auto;
            max-width: 700px;
            padding: 24px 18px;
        }
    </style>
    <!-- Bootstrap Icons CDN for icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1 class="site-title">Fitness Club</h1>
    <div class="dashboard-container">
        <div class="welcome">
            Bienvenue sur votre espace membre !<br>
            Voici les statistiques principales du club :
        </div>
        <div class="stats-row">
            <?php
                $nbAbonnes = count(getAbonnes());
                $nbCoachs = count(getCoachs());
                $nbEquipements = count(getEquipements());
                $nbDisciplines = count(getDisciplines());
                $mois = (int)date('n'); // <-- Doit rester comme ça
                $annee = (int)date('Y');
                $nbImpayes = count(getImpayes($mois, $annee));
                // LOG: paramètres utilisés pour getPaiements
                error_log("DEBUG Paiements: mois=$mois, annee=$annee, statut=paye");
                $paiements = getPaiements($mois, $annee, 'paye');
                // LOG: résultat brut de la requête
                error_log("DEBUG Paiements résultat: " . print_r($paiements, true));
                $totalPaiements = 0;
                foreach ($paiements as $p) {
                    if (isset($p['montant'])) $totalPaiements += floatval($p['montant']);
                }
                // LOG: total calculé
                error_log("DEBUG Paiements total: $totalPaiements");
            ?>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="stat-value"><?php echo $nbAbonnes; ?></div>
                <div class="stat-label">Abonnés</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-person-badge"></i></div>
                <div class="stat-value"><?php echo $nbCoachs; ?></div>
                <div class="stat-label">Coachs</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-hammer"></i></div>
                <div class="stat-value"><?php echo $nbEquipements; ?></div>
                <div class="stat-label">Équipements</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-award"></i></div>
                <div class="stat-value"><?php echo $nbDisciplines; ?></div>
                <div class="stat-label">Disciplines</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
                <div class="stat-value"><?php echo number_format($totalPaiements, 0, '', ' '); ?> FCFA</div>
                <div class="stat-label">Paiements ce mois</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-exclamation-circle"></i></div>
                <div class="stat-value"><?php echo $nbImpayes; ?></div>
                <div class="stat-label">Impayés (<?php echo $mois . '/' . $annee; ?>)</div>
            </div>
        </div>
    </div>
    <div class="chart-container">
        <h3 style="color:#c0392b;">Historique des paiements (12 derniers mois)</h3>
        <canvas id="paiementsChart" height="90"></canvas>
    </div>
    <script>
        <?php
        $labels = [];
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $mois = (int)date('n', strtotime("-$i months"));
            $annee = (int)date('Y', strtotime("-$i months"));
            $labels[] = date('M Y', strtotime("-$i months"));
            $total = 0;
            foreach(getPaiements($mois, $annee, 'paye') as $p) {
                if (isset($p['montant'])) $total += floatval($p['montant']);
            }
            $data[] = $total;
        }
        ?>
        const ctx = document.getElementById('paiementsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Montant payé (FCFA)',
                    data: <?php echo json_encode($data); ?>,
                    borderColor: '#c0392b',
                    backgroundColor: 'rgba(192,57,43,0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>
<?php include 'footer.php'; ?>
