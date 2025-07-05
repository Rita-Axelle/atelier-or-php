<?php
require_once '../config/Database.php';
require_once '../models/Client.php';
require_once '../repository/ClientRepository.php';
require_once '../services/ClientService.php';

require_once __DIR__ . '/../services/security.php';
verifierRole(['gestionnaire']);

$pdo = (new Database())->getPdo();
$service = new ClientService(new ClientRepository($pdo));

$action = $_GET['action'] ?? 'lister';

switch ($action) {
    case 'formulaire':
        $client = null;
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $client = $service->recupererParId($id);
        }
        include '../views/gestionnaire/form_client.php';
        break;

    case 'ajouter_ou_modifier':
        $photo = $_FILES['photo']['name'] ?? null;

        if ($photo && is_uploaded_file($_FILES['photo']['tmp_name'])) {
            $chemin = '../../assets/' . $photo;
            move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
        } else {
            $photo = $_POST['photo_existe'] ?? null;
        }

        $data = [
            'id' => $_POST['id'] ?? null,
            'nom' => $_POST['nom'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'telephone_portable' => $_POST['telephone_portable'] ?? '',
            'adresse' => $_POST['adresse'] ?? '',
            'observation' => $_POST['observation'] ?? '',
            'photo' => $photo
        ];

        if (!empty($data['id'])) {
            $service->modifierClient($data);
        } else {
            $service->ajouterClient($data);
        }

        header('Location: ClientController.php?action=lister');
        exit;

    case 'lister':
        $motcle = $_GET['motcle'] ?? '';
        if (!empty($motcle)) {
            $clients = $service->rechercher($motcle);
        } else {
            $clients = $service->listerTous();
        }
        include '../views/gestionnaire/liste_clients.php';
        break;

    case 'archiver':
        if (isset($_GET['id'])) {
            $service->archiverClient((int)$_GET['id']);
        }
        header('Location: ClientController.php?action=lister');
        exit;

    case 'supprimer':
        if (isset($_GET['id'])) {
            $service->supprimerClient((int)$_GET['id']);
        }
        header('Location: ClientController.php?action=lister');
        exit;

    default:
        echo "Action non reconnue.";
}
