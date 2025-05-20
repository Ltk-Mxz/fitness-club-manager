<?php
session_start();
require_once 'db.php';
$pageTitle = "Connexion admin";
$error = '';

// Si déjà connecté, redirige
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifie l'utilisateur en base
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Identifiant ou mot de passe incorrect';
    }
}

include 'header.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion admin</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Montserrat', Arial, sans-serif;
            /* background: linear-gradient(120deg, #ffd1c1 0%, #ff8a6b 100%); */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .site-title {
            text-align: center;
            font-size: 2.8rem;
            color: #c0392b;
            margin-top: 40px;
            margin-bottom: 30px;
            font-family: 'Montserrat', Arial, sans-serif;
            letter-spacing: 1px;
            font-weight: 700;
        }
        .login-container {
            position: relative;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.35);
            border-radius: 32px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
            padding: 48px 40px 36px 40px;
            max-width: 420px;
            min-width: 340px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-container h2 {
            color: #c0392b;
            font-size: 2.3rem;
            margin-bottom: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .intro-text {
            color: #444;
            font-size: 1.08rem;
            margin-bottom: 22px;
            text-align: center;
            line-height: 1.5;
        }
        .login-container label {
            display: block;
            margin-bottom: 7px;
            font-size: 1.08rem;
            color: #333;
            font-weight: 500;
        }
        /* Harmonisation des inputs */
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
        .login-container .password-wrapper {
            position: relative;
        }
        .login-container .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-70%);
            height: 36px;
            width: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.25rem;
            padding: 0;
            transition: background 0.2s;
        }
        .login-container .toggle-password:hover {
            background: #ffe5e0;
        }
        .login-container .toggle-password span {
            color: #c0392b;
            font-size: 1.25rem;
            line-height: 1;
        }
        .login-container button[type="submit"] {
            width: 100%;
            padding: 15px 0;
            background: #c0392b;
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 1.25rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 8px;
            transition: background 0.2s;
        }
        .login-container button[type="submit"]:hover {
            background: #a93226;
        }
        .error-message {
            color: #e74c3c;
            font-size: 1.1rem;
            margin-bottom: 18px;
            font-weight: 500;
            text-align: center;
        }
        .help-text {
            color: #888;
            font-size: 1.01rem;
            margin-top: 18px;
            text-align: center;
            line-height: 1.4;
        }
        @media (max-width: 500px) {
            .login-container {
                padding: 28px 8px 20px 8px;
                min-width: unset;
                max-width: 98vw;
            }
            .site-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1 class="site-title">Fitness Club</h1>
    </header>
    <div class="login-container">
        <h2 style="text-align: center;">Connexion administrateur</h2>
        <p class="intro-text">
            Espace réservé à l’administrateur du Fitness Club.<br>
            Veuillez saisir vos identifiants admin pour accéder à la gestion du club.
        </p>
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="identifiant">Identifiant admin</label>
            <input type="text" id="identifiant" name="username" required>
            <label for="motdepasse">Mot de passe</label>
            <div class="password-wrapper">
                <input type="password" id="motdepasse" name="password" required>
                <button type="button" class="toggle-password" onclick="togglePassword()">
                    <span id="eye">&#128065;</span>
                </button>
            </div>
            <button type="submit">Se connecter</button>
            <p class="help-text">
                Accès strictement réservé à l’administrateur.<br>
                Mot de passe oublié ? Contactez le support technique.
            </p>
        </form>
    </div>
    <script>
        function togglePassword() {
            const pwd = document.getElementById('motdepasse');
            const eye = document.getElementById('eye');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.textContent = '🙈';
            } else {
                pwd.type = 'password';
                eye.textContent = '👁️';
            }
        }
    </script>
</body>
</html>
<?php include 'footer.php'; ?>
