<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../services/UtilisateurService.php';
require_once __DIR__ . '/../services/ArticleConfectionService.php';
require_once __DIR__ . '/../services/ApprovisionnementService.php';
require_once __DIR__ . '/../repository/FournisseurRepository.php';
require_once __DIR__ . '/../repository/VenteRepository.php';
require_once __DIR__ . '/../services/VenteService.php';

require_once __DIR__ . '/../services/security.php';
verifierRole(['gestionnaire']); // Seul le gestionnaire a accès à ce tableau

// Connexions
$pdo = (new Database())->getPdo();

$serviceUtilisateur = new UtilisateurService($pdo);
$serviceArticle = new ArticleConfectionService($pdo);
$serviceAppro = new ApprovisionnementService($pdo);
$repoFournisseur = new FournisseurRepository($pdo);
$venteService = new VenteService(new VenteRepository($pdo));

// Données globales
$ventes = $venteService->listerToutes();
$nbVentes = count($ventes);
$utilisateurs = $serviceUtilisateur->recupererTous();
$articles = $serviceArticle->rechercherParLibelle();
$approvisionnements = $serviceAppro->recupererTous();
$fournisseurs = $repoFournisseur->recupererTous();

// Statistiques
$nbUtilisateurs = count($utilisateurs);
$nbArticles = count($articles);
$nbApprovisionnements = count($approvisionnements);
$nbFournisseurs = count($fournisseurs);

// Quantité totale approvisionnée
$quantiteTotale = array_sum(array_map(fn($a) => $a->getQuantite(), $approvisionnements));

// Montant total dépensé
$montantTotal = array_sum(array_map(fn($a) => $a->getMontant(), $approvisionnements));

// Dernier approvisionnement
$derniereAppro = null;
if (!empty($approvisionnements)) {
    usort($approvisionnements, fn($a, $b) =>
        $b->getDateAppro()->getTimestamp() <=> $a->getDateAppro()->getTimestamp()
    );
    $derniereAppro = $approvisionnements[0]->getDateAppro();
}

// Inclusion de la vue tableau de bord du gestionnaire
include '../views/gestionnaire/menu.php';
