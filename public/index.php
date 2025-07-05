<?php
session_start();

// Si l'utilisateur est déjà connecté
if (isset($_SESSION['utilisateur'])) {
    $role = $_SESSION['utilisateur']['role'];

    switch ($role) {
        case 'gestionnaire':
            header('Location: ../views/gestionnaire/menu.php');
            break;
        case 'responsable_stock':
            header('Location: ../views/responsable_stock/menu.php');
            break;
        case 'responsable_production':
            header('Location: ../views/responsable_production/menu.php');
            break;
        case 'vendeur':
            header('Location: ../views/vendeur/menu.php');
            break;
        default:
            // Rôle inconnu, on détruit la session et on redirige vers login
            session_destroy();
            header('Location: ../views/security/login.php');
    }
    exit;
}

// Sinon, on affiche la page de login
header('Location: ../views/security/login.php');
exit;
