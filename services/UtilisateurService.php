<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../repository/UtilisateurRepository.php';

class UtilisateurService {
    private UtilisateurRepository $repo;

    public function __construct() {
        $pdo = Database::getPdo();
        $this->repo = new UtilisateurRepository($pdo);
    }

    public function ajouterUtilisateur(Utilisateur $u): void {
        $this->repo->ajouter($u);
    }

    public function modifierUtilisateur(Utilisateur $u): void {
        $this->repo->modifier($u);
    }

    public function archiverUtilisateur(Utilisateur $u): void {
        $this->repo->archiver($u);
    }

    public function recupererTous(): array {
        return $this->repo->lister();
    }

    public function recupererParLogin(string $login): ?Utilisateur {
        return $this->repo->recupererParLogin($login);
    }

    public function recupererParId(int $id): ?Utilisateur {
        return $this->repo->recupererParId($id);
    }
}
