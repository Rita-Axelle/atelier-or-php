<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function verifierConnexion(): void {
    if (!isset($_SESSION['utilisateur'])) {
        header("Location: /aiguille-or/views/security/login.php");
        exit;
    }
}

/**
 * Vérifie si l'utilisateur connecté a l'un des rôles autorisés.
 * Redirige vers la page de connexion ou d'accès refusé si ce n’est pas le cas.
 */
function verifierRole(array $rolesAutorises): void {
    verifierConnexion(); // d'abord vérifier que l'utilisateur est connecté

    $utilisateur = $_SESSION['utilisateur'];
    if (!in_array($utilisateur['role'], $rolesAutorises)) {
        header("Location: /aiguille-or/views/security/unauthorized.php");
        exit;
    }
}
