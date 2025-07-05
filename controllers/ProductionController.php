<?php
require_once '../config/Database.php';
require_once '../models/Production.php';
require_once '../models/ArticleVente.php';
require_once '../services/ProductionService.php';
require_once '../repository/ProductionRepository.php';
require_once '../repository/ArticleVenteRepository.php';

require_once __DIR__ . '/../services/security.php';
verifierRole(['responsable_production', 'gestionnaire']);

$pdo = (new Database())->getPdo();
$articleVenteRepo = new ArticleVenteRepository($pdo);
$productionService = new ProductionService(new ProductionRepository($pdo), $articleVenteRepo);

$action = $_GET['action'] ?? 'lister';

switch ($action) {
    case 'formulaire':
        $production = null;
        $articles = $articleVenteRepo->listerActif();

        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $production = $productionService->recupererParId($id);
        }

        include '../views/responsable_production/form_production.php';
        break;

    case 'ajouter_ou_modifier':
        $data = [
            'id' => $_POST['id'] ?? null,
            'date_production' => $_POST['date_production'] ?? date('Y-m-d'),
            'quantite' => $_POST['quantite'] ?? 0,
            'observation' => $_POST['observation'] ?? '',
            'article_vente_id' => $_POST['article_vente_id'] ?? null,
            'responsable_production_id' => $_SESSION['utilisateur']['id']
        ];

        if (!empty($data['id'])) {
            $productionService->modifierProduction($data);
        } else {
            $productionService->ajouterProduction($data);
        }

        header('Location: ProductionController.php?action=lister');
        exit;

    case 'lister':
        $productions = $productionService->listerToutes();
        include '../views/responsable_production/liste_production.php';
        break;

    case 'lister_jour':
        $aujourdhui = new DateTime();
        $productions = $productionService->listerParJour($aujourdhui);
        include '../views/responsable_production/liste_production.php';
        break;

    case 'filtrer_periode_libelle':
        $libelle = $_GET['libelle'] ?? '';
        $date_debut = $_GET['date_debut'] ?? '';
        $date_fin = $_GET['date_fin'] ?? '';

        $debut = $date_debut ? new DateTime($date_debut) : new DateTime('2000-01-01');
        $fin = $date_fin ? new DateTime($date_fin) : new DateTime();

        $productions = $productionService->listerParPeriodeEtLibelle($debut, $fin, $libelle);
        include '../views/responsable_production/liste_production.php';
        break;

    default:
        echo "Action non reconnue.";
}
