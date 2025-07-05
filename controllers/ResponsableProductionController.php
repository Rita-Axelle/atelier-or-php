<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../services/ProductionService.php';
require_once __DIR__ . '/../repository/ProductionRepository.php';
require_once __DIR__ . '/../repository/ArticleVenteRepository.php';

require_once __DIR__ . '/../services/security.php';

// Vérification du rôle
verifierRole(['responsable_production', 'gestionnaire']);




// Initialisation des composants
$pdo = (new Database())->getPdo();
$productionRepository = new ProductionRepository($pdo);
$articleVenteRepository = new ArticleVenteRepository($pdo);
$serviceProduction = new ProductionService($productionRepository, $articleVenteRepository);
$repoArticle = new ArticleVenteRepository($pdo);

// Récupération des productions
$productions = $serviceProduction->listerToutes();
$nbProductions = count($productions);

// Nombre total d'articles de vente
$nbArticlesVente = count($repoArticle->listerTous());

// Quantité totale produite
$quantiteTotale = array_sum(array_map(fn($p) => $p['quantite'], $productions));


// Date de la dernière production (si disponible)
$derniereProduction = null;
if (!empty($productions)) {
    usort($productions, fn($a, $b) => strtotime($b['date_production']) <=> strtotime($a['date_production']));
    $derniereProduction = $productions[0]['date_production'];;
}

// Inclusion de la vue du menu responsable de production
include '../views/responsable_production/menu.php';
