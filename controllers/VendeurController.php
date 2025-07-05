<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../repository/VenteRepository.php';
require_once __DIR__ . '/../repository/ClientRepository.php';
require_once __DIR__ . '/../repository/ArticleVenteRepository.php';
require_once __DIR__ . '/../services/VenteService.php';

require_once __DIR__ . '/../services/security.php';
// Vérification du rôle
verifierRole(['vendeur', 'gestionnaire']);

$pdo = (new Database())->getPdo();
$venteService = new VenteService(new VenteRepository($pdo));
$clientRepo = new ClientRepository($pdo);
$articleRepo = new ArticleVenteRepository($pdo);

// Statistiques et données générales
$ventes = $venteService->recupererToutesParVendeur($_SESSION['utilisateur']['id']);
$nbVentes = count($ventes);
$ventes = $venteService->listerToutes();
$nbClients = count($clientRepo->recupererTous());
$nbArticles = count($articleRepo->listerActif());
$montantTotal = $venteService->calculerMontantTotal();

// Calcul du montant total vendu
$montantTotal = array_sum(array_map(fn($v) => $v->getMontant(), $ventes));

// Dernière vente
$derniereVente = null;
if (!empty($ventes)) {
    usort($ventes, fn($a, $b) => strtotime($b->getDateVente()->format('Y-m-d')) - strtotime($a->getDateVente()->format('Y-m-d')));
    $derniereVente = $ventes[0]->getDateVente()->format('d/m/Y');
}

// Vue du menu vendeur avec tableau de bord
include '../views/vendeur/menu.php';
