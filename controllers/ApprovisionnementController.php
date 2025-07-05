<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../services/ApprovisionnementService.php';
require_once __DIR__ . '/../repository/ArticleConfectionRepository.php';
require_once __DIR__ . '/../repository/FournisseurRepository.php';

require_once __DIR__ . '/../services/security.php';

verifierRole(['responsable_stock', 'gestionnaire']);

$pdo = (new Database())->getPdo();
$service = new ApprovisionnementService($pdo);
$repoArticle = new ArticleConfectionRepository($pdo);
$repoFournisseur = new FournisseurRepository($pdo);

$action = $_GET['action'] ?? 'lister';

switch ($action) {
    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $quantite = (int)$data['quantite'];
            $prix = (float)$data['prix'];
            $montant = $quantite * $prix;

            $data['montant'] = $montant;

            $service->ajouter($data);

            // Mise à jour du stock
            $article = $repoArticle->recupererParId((int)$data['article_confection_id']);
            if ($article) {
                $article->setQuantiteStock($article->getQuantiteStock() + $quantite);
                $article->setMontantStock($article->getMontantStock() + $montant);
                $repoArticle->modifier($article);
            }

            header('Location: ApprovisionnementController.php?action=lister&success=1');
            exit;
        } else {
            $articles = $repoArticle->recupererTousAssoc();
            $fournisseurs = $repoFournisseur->recupererTousActifsAssoc();
            include '../views/responsable_stock/form_appro.php';
        }
        break;

    case 'modifier':
        $id = (int)($_GET['id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['id'] = $id;

            $quantite = (int)$_POST['quantite'];
            $prix = (float)$_POST['prix'];
            $montant = $quantite * $prix;
            $_POST['montant'] = $montant;

            $service->modifier($_POST);

            header('Location: ApprovisionnementController.php?action=lister&success=1');
            exit;
        } else {
            $appro = $service->recupererParId($id);
            $articles = $repoArticle->recupererTousAssoc();
            $fournisseurs = $repoFournisseur->recupererTousAssoc();
            include '../views/responsable_stock/form_appro.php';
        }
        break;

    case 'supprimer':
        $id = (int)($_GET['id'] ?? 0);
        $service->supprimer($id);
        header('Location: ApprovisionnementController.php?action=lister&deleted=1');
        exit;

    case 'archiver':
        $id = (int)($_GET['id'] ?? 0);
        $service->archiver($id);
        header('Location: ApprovisionnementController.php?action=lister&archived=1');
        exit;

    case 'form':
        $articles = $repoArticle->recupererTousAssoc();
        $fournisseurs = $repoFournisseur->recupererTousAssoc();

        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $appro = $service->recupererParId($id); // 💡 Cette ligne est essentielle pour que $appro existe dans la vue
        }

        include '../views/responsable_stock/form_appro.php';
        break;

    case 'lister':
        $criteres = [
            'date_appro' => $_GET['date'] ?? null,
            'article_confection_id' => $_GET['article'] ?? null,
            'fournisseur_id' => $_GET['fournisseur'] ?? null,
        ];

        $criteres = array_filter($criteres);
        $approvisionnements = !empty($criteres)
            ? $service->rechercher($criteres)
            : $service->recupererTous();

        $articles = $repoArticle->recupererTousAssoc();
        $fournisseurs = $repoFournisseur->recupererTousActifsAssoc();

        include '../views/responsable_stock/liste_appro.php';
        break;

    default:
        echo "Action non reconnue.";
        break;
}
