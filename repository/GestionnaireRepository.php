<?php
require_once dirname(__DIR__) . '/repository/UtilisateurRepository.php';

class GestionnaireRepository extends UtilisateurRepository
{
    // Hérite déjà des méthodes utiles :
    // - ajouter(Utilisateur $u)
    // - modifier(Utilisateur $u)
    // - archiver($id)
    // - listerParRole($role)
    // - trouverParLogin($login)

    // Tu peux ajouter des méthodes spécifiques ici si besoin
}