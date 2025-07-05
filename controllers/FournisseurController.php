<?php
require_once '../config/Database.php';
require_once '../services/FournisseurService.php';
require_once '../models/Fournisseur.php';
require_once __DIR__ . '/../services/security.php';

verifierRole(['gestionnaire']);


$pdo = (new Database())->getPdo();
$service = new FournisseurService($pdo);

$action = $_GET['action'] ?? 'lister';

switch ($action) {
    case 'lister':
        $fournisseurs = $service->recupererTous();
        include '../views/gestionnaire/liste_fournisseurs.php';
        break;

    case 'formulaire':
        $fournisseur = null;
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $fournisseur = $service->recupererParId($id);
        }
        include '../views/gestionnaire/form_fournisseur.php';
        break;

    case 'ajouter_ou_modifier':
        $data = [
            'id' => $_POST['id'] ?? null,
            'nom' => $_POST['nom'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'telephone_portable' => $_POST['telephone_portable'] ?? '',
            'telephone_fixe' => $_POST['telephone_fixe'] ?? '',
            'adresse' => $_POST['adresse'] ?? '',
            'etat' => $_POST['etat'] ?? 'actif'
        ];

        // Gestion de l’image uploadée
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $nomTemp = $_FILES['photo']['tmp_name'];
            $nomOriginal = basename($_FILES['photo']['name']);
            $extension = pathinfo($nomOriginal, PATHINFO_EXTENSION);

            // Nom unique
            $nomFichier = uniqid('fournisseur_', true) . '.' . $extension;

            // Chemin de destination
            $cheminDestination = '../assets/fournisseurs/' . $nomFichier;

            if (move_uploaded_file($nomTemp, $cheminDestination)) {
                $data['photo'] = 'fournisseurs/' . $nomFichier;
            }
        } elseif (!empty($_POST['photo_existante'])) {
            // En cas de modification sans nouvelle image
            $data['photo'] = $_POST['photo_existante'];
        } else {
            $data['photo'] = null;
        }

        if (!empty($data['id'])) {
            $service->modifier($data);
        } else {
            $service->ajouter($data);
        }


        header('Location: FournisseurController.php?action=lister');
        exit;

    case 'archiver':
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $service->archiver($id);
        }
        header('Location: FournisseurController.php?action=lister');
        exit;


    case 'supprimer':
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
            $service->supprimer($id);
        }
        header('Location: FournisseurController.php?action=lister');
        exit;

    default:
        echo "Action fournisseur non reconnue.";
        break;
}
