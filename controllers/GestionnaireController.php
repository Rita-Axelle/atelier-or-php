<?php
require_once '../config/Database.php';
require_once '../models/Gestionnaire.php';
require_once '../models/Utilisateur.php';
require_once '../services/GestionnaireService.php';
require_once '../models/Fournisseur.php';
require_once '../services/FournisseurService.php';


require_once __DIR__ . '/../services/security.php';
verifierRole(['gestionnaire']);


$pdo = (new Database())->getPdo();
$service = new GestionnaireService($pdo);
$action = $_GET['action'] ?? 'lister';

switch ($action) {
    case 'lister':
        $motcle = $_GET['motcle'] ?? '';
        if (!empty($motcle)) {
            $utilisateurs = $service->rechercher($motcle);
        } else {
            $utilisateurs = $service->listerTous();
        }
        include '../views/gestionnaire/liste_utilisateurs.php';
        break;

    case 'formulaire':
        $utilisateur = null;
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $utilisateur = $service->recupererParId($id);
        }
        include '../views/gestionnaire/form_utilisateur.php';
        break;

    case 'ajouter_ou_modifier':
        // Traitement de la photo uploadée
        $photoPath = $_POST['photo_existant'] ?? null;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['photo']['tmp_name'];
            $originalName = basename($_FILES['photo']['name']);
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            // Création d'un nom unique
            $filename = uniqid('photo_', true) . '.' . $extension;

             // Chemin final
            $destinationWeb = '/aiguille-or/assets/photos_users/' . $filename;
            $destinationDisk = __DIR__ . '/../assets/photos_users/' . $filename;

            // Sauvegarde de la nouvelle image
            if (move_uploaded_file($tmpName, $destinationDisk)) {
                $photoPath = $destinationWeb;
            }
        }

        $data = [
            'id' => $_POST['id'] ?? null,
            'nom' => $_POST['nom'] ?? '',
            'prenom' => $_POST['prenom'] ?? '',
            'telephone_portable' => $_POST['telephone_portable'] ?? '',
            'adresse' => $_POST['adresse'] ?? '',
            'salaire' => $_POST['salaire'] ?? 0,
            'login' => $_POST['login'] ?? '',
            'mot_de_passe' => $_POST['mot_de_passe'] ?? '',
            'role' => $_POST['role'] ?? 'vendeur',
            'etat' => $_POST['etat'] ?? 'actif',
            'photo' => $photoPath
        ];

        $gestionnaire = new Gestionnaire([], $pdo);
        $utilisateur = new Utilisateur($data);

        //Vérifier si le login est déjà utilisé par un autre utilisateur
        $utilisateurRepo = new UtilisateurRepository($pdo);
        $utilisateurExistant = $utilisateurRepo->recupererParLogin($utilisateur->getLogin());
        if (
            $utilisateurExistant !== null &&
            (empty($data['id']) || $utilisateurExistant->getId() !== (int)$data['id'])
        ) {
            // Un autre utilisateur que celui modifié utilise déjà ce login
            header('Location: GestionnaireController.php?action=formulaire&id=' . $data['id'] . '&erreur=login_existe');
            exit;
        }

        if (!empty($data['id'])) {
            $gestionnaire->modifierUtilisateur($utilisateur);
        } else {
            $gestionnaire->ajouterUtilisateur($utilisateur);
        }

        header('Location: GestionnaireController.php?action=lister&success=1');
        exit;

    case 'archiver':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $gestionnaire = new Gestionnaire([], $pdo);
            $gestionnaireService = new GestionnaireService($pdo);
            $utilisateur = $gestionnaireService->recupererParId($id);
            if ($utilisateur) {
                $gestionnaireService->archiver($utilisateur);
            }
            header('Location: GestionnaireController.php?action=lister');
            exit;
        }
        break;

    case 'supprimer':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $gestionnaireService = new GestionnaireService($pdo);
            $gestionnaireService->supprimerParId($id); 
            header('Location: GestionnaireController.php?action=lister');
            exit;
        }
        break;

    case 'choixArticles':
        include dirname(__DIR__) . '/views/gestionnaire/choix_articles.php';
        break;
    
    case 'menuArticlesConfection':
        //include dirname(__DIR__) . '/views/gestionnaire/menu_articles_confection.php';
         header('Location: ../controllers/ArticleConfectionController.php?action=lister');
        break;

    case 'menuArticlesVente':
        //include dirname(__DIR__) . '/views/gestionnaire/menu_articles_vente.php';
         header('Location: ../controllers/ArticleVenteController.php?action=lister');
        break; 

    default:
        echo "Action non reconnue.";
}
