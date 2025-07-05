<?php

require_once '../config/Database.php';
require_once '../models/Vente.php';
require_once '../repository/VenteRepository.php';
require_once '../repository/ClientRepository.php';
require_once '../repository/ArticleVenteRepository.php';
require_once '../services/VenteService.php';
require_once '../services/security.php';

verifierRole(['vendeur', 'gestionnaire']);

$pdo = (new Database())->getPdo();
$venteService = new VenteService(new VenteRepository($pdo));
$clientRepo = new ClientRepository($pdo);
$articleRepo = new ArticleVenteRepository($pdo);

$action = $_GET['action'] ?? 'lister';

switch ($action) {
    case 'formulaire':
        $clients = $clientRepo->recupererTous();
        $articles = $articleRepo->listerTous();
        if (isset($_GET['id'])) {
            $vente = $venteService->recupererParId((int)$_GET['id']);
        }
        include '../views/vendeur/form_vente.php';
        break;

    case 'ajouter_ou_modifier':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $prix = (float)$_POST['prix'];
            $quantite = (int)$_POST['quantite'];
            $articleId = (int)$_POST['article_vente_id'];

            $article = $articleRepo->recupererParId($articleId);
            if (!$article) {
                die("Article non trouvé.");
            }

            $stockDisponible = $article->getQuantiteStock();
            $quantiteInitiale = 0;

            // Si modification, on récupère la vente originale
            if (!empty($id)) {
                $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                $venteExistante = $venteService->recupererParId($id);
                if ($venteExistante && $venteExistante->getArticleVenteId() === $articleId) {
                    $quantiteInitiale = $venteExistante->getQuantite();
                }
            }

            $quantiteDiff = $quantite - $quantiteInitiale;

            if ($quantiteDiff > $stockDisponible) {
                // Rediriger avec message d’erreur
                header('Location: VenteController.php?action=formulaire&erreur=stock_insuffisant');
                exit;
            }

            $montant = $prix * $quantite;

            $data = [
                'id' => $id,
                'date_vente' => $_POST['date_vente'] ?? date('Y-m-d'),
                'quantite' => $quantite,
                'prix' => $prix,
                'montant' => $montant,
                'observation' => $_POST['observation'] ?? '',
                'article_vente_id' => $articleId,
                'client_id' => (int)$_POST['client_id'],
                'vendeur_id' => $_SESSION['utilisateur']['id']
            ];

            if ($id) {
                $venteService->modifierVente($data);
            } else {
                $venteService->ajouterVente($data);
            }

            // Mise à jour du stock (toujours après ajout ou modification)
            $article->setQuantiteStock($article->getQuantiteStock() - $quantiteDiff);
            $article->setMontantVente($article->getMontantVente() - ($prix * $quantiteDiff));
            $articleRepo->modifier($article);

            header('Location: VenteController.php?action=lister');
            exit;
        }
        break;

    case 'lister':
        $ventes = $venteService->listerToutes();
        $clients = $clientRepo->recupererTousAssoc();
        $articles = $articleRepo->recupererTousAssoc();

        include '../views/vendeur/liste_ventes.php';
        break;

    case 'filtrer':
        $date = $_GET['date_vente'] ?? null;
        $clientId = isset($_GET['client_id']) ? (int)$_GET['client_id'] : null;
        $articleId = isset($_GET['article_vente_id']) ? (int)$_GET['article_vente_id'] : null;

        $ventes = $venteService->filtrer($date, $clientId, $articleId);
        $clients = $clientRepo->recupererTousAssoc();
        $articles = $articleRepo->recupererTousAssoc();

        include '../views/vendeur/liste_ventes.php';
        break;

    default:
        echo "Action non reconnue.";
        break;
}
