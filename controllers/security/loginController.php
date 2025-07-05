<?php
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Validator.php';
require_once __DIR__ . '/../../repository/UtilisateurRepository.php';
require_once __DIR__ . '/../../models/Utilisateur.php';

// Gestion de la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $motDePasse = $_POST['mot_de_passe'] ?? '';

    // Validation
    $erreurs = Validator::isEmpty($_POST, ['login', 'mot_de_passe']);

    if (empty($erreurs)) {
        $pdo = (new Database())->getPdo();
        $repo = new UtilisateurRepository($pdo);
        $utilisateur = $repo->recupererParLogin($login);

        // Authentification sans hash
        if ($utilisateur && $motDePasse === $utilisateur->getMotDePasse()) {
            $_SESSION['utilisateur'] = [
                'id' => $utilisateur->getId(),
                'nom' => $utilisateur->getNom(),
                'prenom' => $utilisateur->getPrenom(),
                'role' => $utilisateur->getRole()
            ];

            switch ($utilisateur->getRole()) {
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
                    header('Location: ../../views/security/login.php?erreur=role_invalide');
            }
        } else {
            header('Location: ../../views/security/login.php?erreur=identifiants_incorrects');
        }
    } else {
        // Rediriger avec les erreurs en session ou dans l’URL (à toi de choisir)
        header('Location: ../../views/security/login.php?erreur=champs_vides');
    }
}
