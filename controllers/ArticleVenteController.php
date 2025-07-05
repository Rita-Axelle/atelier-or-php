<?php
require_once '../config/Database.php';
require_once '../models/ArticleVente.php';
require_once '../services/ArticleVenteService.php';
require_once '../repository/ArticleVenteRepository.php';

require_once __DIR__ . '/../services/security.php';
verifierRole(['gestionnaire', 'responsable_production']);

$pdo = (new Database())->getPdo();
$service = new ArticleVenteService($pdo);
$action = $_GET['action'] ?? 'lister';

switch ($action) {

    case 'lister':
        $libelle = $_GET['libelle'] ?? '';
        $articles = $service->rechercherParLibelle($libelle);
        include '../views/gestionnaire/liste_articles_vente.php';
        break;

    case 'formulaire':
        $article = null;
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $article = $service->recupererParId($id);
        }
        include '../views/gestionnaire/form_article_vente.php';
        break;

    case 'ajouter_ou_modifier':
        $data = [
            'id' => !empty($_POST['id']) ? (int)$_POST['id'] : null,
            'libelle' => $_POST['libelle'] ?? '',
            'prix_vente' => floatval($_POST['prix_vente'] ?? 0),
            'quantite_stock' => intval($_POST['quantite_stock'] ?? 0),
            'etat' => $_POST['etat'] ?? 'actif',
            'categorie' => 'vente',
            'photo' => null,
        ];

        $data['montant_vente'] = $data['prix_vente'] * $data['quantite_stock'];

        // Gestion de la photo
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['photo']['tmp_name'];
            $originalName = basename($_FILES['photo']['name']);
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $filename = uniqid('vente_', true) . '.' . $extension;
            $webPath = 'articles_vente/' . $filename;
            $destination = '../assets/' . $webPath;

            if (move_uploaded_file($tmpName, $destination)) {
                $data['photo'] = $webPath;
            }
        } elseif (!empty($_POST['photo_existante'])) {
            $data['photo'] = $_POST['photo_existante'];
        }

        $article = new ArticleVente($data);

        if (!empty($data['id'])) {
            $service->modifier($article);
        } else {
            $service->ajouter($article);
        }

        header('Location: ArticleVenteController.php?action=lister');
        exit;

    case 'archiver':
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if ($id !== null) {
            $id = intval($id);
            $article = $service->recupererParId($id);
            if ($article) {
                $service->archiver($article);
            }
            header('Location: ArticleVenteController.php?action=lister');
            exit;
        }
        break;

    case 'supprimer':
        $id = $_POST['id'] ?? $_GET['id'] ?? null;
        if ($id !== null) {
            $id = intval($id);
            $service->supprimer($id);
            header('Location: ArticleVenteController.php?action=lister');
            exit;
        }
        break;

    default:
        echo "Action non reconnue.";
}
