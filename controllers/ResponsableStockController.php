<?php
session_start();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../services/ApprovisionnementService.php';
require_once __DIR__ . '/../repository/FournisseurRepository.php';
require_once __DIR__ . '/../repository/ArticleConfectionRepository.php';

require_once __DIR__ . '/../services/security.php';

// Vérification du rôle
verifierRole(['responsable_stock', 'gestionnaire']);

// Connexion à la base
$pdo = (new Database())->getPdo();
$service = new ApprovisionnementService($pdo);
$repoFournisseur = new FournisseurRepository($pdo);
$repoArticle = new ArticleConfectionRepository($pdo);

// Statistiques pour le tableau de bord
$approvisionnements = $service->recupererTous();
$nbApprovisionnements = count($approvisionnements);
$nbFournisseurs = count($repoFournisseur->recupererTous());
$nbArticles = count($repoArticle->recupererTousAssoc());

// Calcule la quantité totale approvisionnée
$quantiteTotale = array_sum(array_map(function ($a) {
    return $a->getQuantite();
}, $approvisionnements));

// (optionnel) dernières dates d'approvisionnement
$derniereAppro = !empty($approvisionnements)
    ? max(array_map(fn($a) => $a->getDateAppro(), $approvisionnements))
    : null;


// Inclusion de la vue avec les données prêtes à l’emploi
include '../views/responsable_stock/menu.php';
