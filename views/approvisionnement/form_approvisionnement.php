<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../services/ApprovisionnementService.php';

$pdo = (new Database())->getPdo();
$service = new ApprovisionnementService($pdo);

$action = $_GET['action'] ?? 'lister';

switch ($action) {
    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->ajouter($_POST);
            header('Location: ../responsableStock/liste_approvisionnements.php?success=1');
            exit;
        } else {
            include '../responsableStock/form_approvisionnement.php';
        }
        break;

    case 'modifier':
        $id = (int)($_GET['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['id'] = $id;
            $service->modifier($_POST);
            header('Location: ../responsableStock/liste_approvisionnements.php?updated=1');
            exit;
        } else {
            $appro = $service->recupererParId($id);
            include '../responsableStock/form_approvisionnement.php';
        }
        break;

    case 'supprimer':
        $id = (int)($_GET['id'] ?? 0);
        $service->supprimer($id);
        header('Location: ../responsableStock/liste_approvisionnements.php?deleted=1');
        exit;

    case 'rechercher':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $approvisionnements = $service->rechercher($_POST);
            include '../responsableStock/liste_approvisionnements.php';
        } else {
            include '../responsableStock/recherche_approvisionnement.php';
        }
        break;

    case 'form':
        include '../responsableStock/form_approvisionnement.php';
        break;

    default:
        $approvisionnements = $service->recupererTous();
        include '../responsableStock/liste_approvisionnements.php';
        break;
}