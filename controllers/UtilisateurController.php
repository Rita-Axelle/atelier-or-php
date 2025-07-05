<?php
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../services/UtilisateurService.php';

$service = new UtilisateurService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $donnees = [
        'id' => $_POST['id'] ?? null,
        'nom' => $_POST['nom'] ?? '',
        'prenom' => $_POST['prenom'] ?? '',
        'telephone_portable' => $_POST['telephone_portable'] ?? '',
        'adresse' => $_POST['adresse'] ?? '',
        'salaire' => $_POST['salaire'] ?? 0.0,
        'login' => $_POST['login'] ?? '',
        'mot_de_passe' => $_POST['mot_de_passe'] ?? '',
        'role' => $_POST['role'] ?? '',
        'photo' => $_POST['photo'] ?? null,
    ];

    $utilisateur = new Utilisateur($donnees);

    switch ($action) {
        case 'ajouter':
            $service->ajouterUtilisateur($utilisateur);
            break;
        case 'modifier':
            $service->modifierUtilisateur($utilisateur);
            break;
        case 'archiver':
            $service->archiverUtilisateur($utilisateur);
            break;
    }

    header('Location: ../views/gestionnaire/liste-utilisateurs.php');
    exit;
}
