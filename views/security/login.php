<?php
session_start();

// Si l'utilisateur est déjà connecté, on le redirige selon son rôle
if (isset($_SESSION['utilisateur'])) {
    $role = $_SESSION['utilisateur']['role'];

    switch ($role) {
        case 'gestionnaire':
            header('Location: ../../controllers/GesTdbController.php');
            break;
        case 'responsable_stock':
            header('Location: ../../controllers/ResponsableStockController.php');
            break;
        case 'responsable_production':
            header('Location: ../../controllers/ResponsableProductionController.php');
            break;
        case 'vendeur':
            header('Location: ../../controllers/VendeurController.php');
            break;
        default:
            session_destroy();
            header('Location: login.php');
            exit;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Aiguille d'Or</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #1A1A40;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* éléments décoratifs */
        .background-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            z-index: 0;
        }

        .shape1 {
            width: 300px;
            height: 300px;
            background: #d4af37; /* doré */
            top: -80px;
            left: -80px;
        }

        .shape2 {
            width: 200px;
            height: 200px;
            background: #F5EBDD; /* beige clair */
            bottom: -60px;
            right: -60px;
        }

        .welcome {
            text-align: center;
            color: #F5EBDD;
            font-size: 1.2rem;
            margin-bottom: 30px;
            z-index: 1;
        }

        .login-box {
            background-color: #F5EBDD;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0,0,0,0.15);
            padding: 40px;
            width: 90%;
            max-width: 420px;
            box-sizing: border-box;
            z-index: 1;
            animation: fadeIn 0.8s ease;
        }

        .login-box h1 {
            margin: 0 0 20px;
            text-align: center;
            color: #1A1A40;
            font-size: 2rem;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1A1A40;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #d4af37;
            outline: none;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.5);
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #1A1A40;
            color: #F5EBDD;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #d4af37;
            color: #1A1A40;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 500px) {
            .login-box {
                padding: 30px 20px;
            }

            .welcome {
                font-size: 1rem;
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Arrière-plan -->
    <div class="background-shape shape1"></div>
    <div class="background-shape shape2"></div>

    <!-- Message de bienvenue -->
    <div class="welcome">
        Bienvenue sur l'application de gestion de <strong>L’AIGUILLE D’OR</strong>
    </div>

    <!-- Boîte de connexion -->
    <div class="login-box">
        <h1>Connexion</h1>
        <form action="/aiguille-or/controllers/security/loginController.php" method="post">
            <label for="login">Login</label>
            <input type="text" name="login" id="login" required>

            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>

            <input type="submit" value="Se connecter">
        </form>
    </div>
</body>
</html>

