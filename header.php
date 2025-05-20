<?php
// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Rediriger vers login.php
if (!isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Fitness Club'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #ffd1c1 0%, #ff8a6b 100%);
            min-height: 100vh;
        }

        .glass {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(7px);
            -webkit-backdrop-filter: blur(7px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 2rem;
            margin-top: 2rem;
        }

        h1,
        .table thead {
            color: #c82333;
            font-weight: 600;
        }

        .table {
            background: rgba(255, 255, 255, 0.7);
            border-radius: 12px;
            overflow: hidden;
        }

        .btn-red {
            background: #c82333;
            color: #fff;
        }

        .btn-red:hover {
            background: #a71d2a;
            color: #fff;
        }

        /* Sidebar ultra stylisée */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 240px;
            background: linear-gradient(135deg, #fff 0%, #f7f7f7 100%);
            box-shadow: 4px 0 24px rgba(200, 35, 51, 0.12), 0 1.5px 0 rgba(255, 255, 255, 0.25) inset;
            z-index: 1000;
            padding-top: 2rem;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-right: 2px solid #ececec;
            transition: background 0.3s;
            overflow-y: auto; /* Rend la sidebar scrollable */
        }

        .sidebar .sidebar-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #222; /* noir */
            margin-bottom: 2.5rem;
            text-align: center;
            letter-spacing: 1px;
            text-shadow: none;
            padding-bottom: 1rem;
            border-bottom: 2px solid #ececec;
        }

        .sidebar .nav-link {
            color: #222; /* noir */
            font-weight: 600;
            margin-bottom: 1.2rem;
            padding: 0.75rem 1.2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            font-size: 1.08rem;
            letter-spacing: 0.5px;
            transition:
                background 0.18s cubic-bezier(.4, 0, .2, 1),
                color 0.18s cubic-bezier(.4, 0, .2, 1),
                box-shadow 0.18s cubic-bezier(.4, 0, .2, 1),
                transform 0.18s cubic-bezier(.4, 0, .2, 1);
            box-shadow: none;
            position: relative;
        }

        .sidebar .nav-link i {
            font-size: 1.3rem;
            margin-right: 0.8rem;
            color: #222; /* noir */
            filter: none;
            transition: color 0.2s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: #ececec;
            color: #111;
            box-shadow: 0 2px 12px #ececec;
            transform: translateX(6px) scale(1.04);
        }

        .sidebar .nav-link.active i,
        .sidebar .nav-link:hover i {
            color: #111;
            text-shadow: none;
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 32px;
            border-radius: 6px;
            background: linear-gradient(180deg, #bbb 0%, #eee 100%);
            box-shadow: 0 0 8px #ececec;
        }

        .sidebar .nav-link:last-child {
            margin-top: auto;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: static;
                width: 100%;
                height: auto;
                flex-direction: row;
                padding: 0.5rem 0.5rem 0.5rem 0.5rem;
                box-shadow: none;
                background: #fff;
                border-right: none;
                border-bottom: 2px solid #ececec;
                backdrop-filter: blur(0);
            }

            .sidebar .nav-link {
                margin-bottom: 0;
                margin-right: 1rem;
                padding: 0.5rem 0.7rem;
                font-size: 1rem;
            }

            .sidebar .sidebar-title {
                display: none;
            }
        }

        .main-content {
            margin-left: 260px;
            transition: margin-left 0.2s;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['user'])): ?>
    <nav class="sidebar">
        <div class="sidebar-title">
            <i class="bi bi-fire"></i> Fitness Club
        </div>
        <a class="nav-link<?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo ' active'; ?>" href="index.php"><i class="bi bi-house"></i> Accueil</a>
        <!-- CRUD Abonnés -->
        <a class="nav-link<?php if (basename($_SERVER['PHP_SELF']) == 'liste_abonnes.php') echo ' active'; ?>" href="liste_abonnes.php"><i class="bi bi-people"></i> Liste abonnés</a>
        <!-- CRUD Coachs -->
        <a class="nav-link<?php if (basename($_SERVER['PHP_SELF']) == 'liste_coachs.php') echo ' active'; ?>" href="liste_coachs.php"><i class="bi bi-person-badge"></i> Liste coachs</a>
        <!-- CRUD Disciplines -->
        <a class="nav-link<?php if (basename($_SERVER['PHP_SELF']) == 'liste_disciplines.php') echo ' active'; ?>" href="liste_disciplines.php"><i class="bi bi-award"></i> Liste disciplines</a>
        <!-- CRUD Équipements -->
        <a class="nav-link<?php if (basename($_SERVER['PHP_SELF']) == 'liste_equipements.php') echo ' active'; ?>" href="liste_equipements.php"><i class="bi bi-hammer"></i> Liste équipements</a>
        <!-- Paiements -->
        <a class="nav-link<?php if (basename($_SERVER['PHP_SELF']) == 'liste_abonnements.php') echo ' active'; ?>" href="liste_abonnements.php"><i class="bi bi-card-list"></i> Liste paiements</a>
        <!-- Impayés -->
        <a class="nav-link<?php if (basename($_SERVER['PHP_SELF']) == 'liste_impayes.php') echo ' active'; ?>" href="liste_impayes.php"><i class="bi bi-exclamation-circle"></i> Impayés</a>
        <!-- Déconnexion -->
        <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </nav>
    <?php endif; ?>
    <div class="main-content">
