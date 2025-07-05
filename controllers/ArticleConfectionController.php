<?php
require_once '../config/Database.php';
require_once '../models/ArticleConfection.php';
require_once '../services/ArticleConfectionService.php';
require_once '../repository/ArticleConfectionRepository.php';

require_once __DIR__ . '/../services/security.php';
verifierRole(['gestionnaire']);


$pdo = (new Database())->getPdo();
$service = new ArticleConfectionService($pdo);
$action = $_GET['action'] ?? 'lister';

switch ($action) {
    case 'lister':
        $libelle = $_GET['libelle'] ?? '';
        $articles = $service->rechercherParLibelle($libelle);
        include '../views/gestionnaire/liste_articles_confection.php';
        break;

    case 'formulaire':
        $article = null;
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $article = $service->recupererParId($id);
        }
        include '../views/gestionnaire/form_article_confection.php';
        break;

    case 'ajouter_ou_modifier':
        $data = [
            'id' => $_POST['id'] ?? null,
            'libelle' => $_POST['libelle'] ?? '',
            'prix_achat' => $_POST['prix_achat'] ?? 0,
            'quantite_achat' => $_POST['quantite_achat'] ?? 0,
            'quantite_stock' => $_POST['quantite_stock'] ?? 0,
            'montant_stock' => $_POST['montant_stock'] ?? 0,
            'photo' => $_POST['photo'] ?? null,
            'etat' => $_POST['etat'] ?? 'actif',
        ];

        // Gestion de l’image uploadée
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $nomTemp = $_FILES['photo']['tmp_name'];
            $nomOriginal = basename($_FILES['photo']['name']);
            $extension = pathinfo($nomOriginal, PATHINFO_EXTENSION);

            // Nom unique pour éviter les doublons
            $nomFichier = uniqid('article_', true) . '.' . $extension;

            // Dossier de destination
            $cheminDestination = '../assets/articles_conf/' . $nomFichier;

            // Déplacement du fichier
            if (move_uploaded_file($nomTemp, $cheminDestination)) {
                $data['photo'] = 'articles_conf/' . $nomFichier;
            }
        } elseif (!empty($_POST['photo_existante'])) {
            // En cas de modification sans nouvelle image
            $data['photo'] = $_POST['photo_existante'];
        } else {
            $data['photo'] = null;
        }

        // Création de l’objet article
        $article = new ArticleConfection($data);

        // Enregistrement en base
        if (!empty($data['id'])) {
            $service->modifier($article);
        } else {
            $service->ajouter($article);
        }

        header('Location: ArticleConfectionController.php?action=lister');
        exit;

    case 'archiver':
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if ($id !== null) {
            $id = intval($id);
            $article = $service->recupererParId($id);
            if ($article) {
                $service->archiver($article);
            }
            header('Location: ArticleConfectionController.php?action=lister');
            exit;
        }
        break;

    case 'supprimer':
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if ($id !== null) {
            $id = intval($id);
            $service->supprimer($id);
            header('Location: ArticleConfectionController.php?action=lister');
            exit;
        }
        break;

    case 'details':
        $id = $_GET['id'] ?? null;
        if ($id !== null) {
            $id = intval($id);
            $article = $service->recupererParId($id);
            if ($article) {
                include '../views/gestionnaire/details_article_confection.php';
                exit;
            }
        }
        header('Location: ArticleConfectionController.php?action=lister');
        exit;

    default:
        echo "Action non reconnue.";
}
