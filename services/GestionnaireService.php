<?php
require_once dirname(__DIR__) . '/models/Gestionnaire.php';
require_once dirname(__DIR__) . '/repository/GestionnaireRepository.php';

class GestionnaireService
{
    private GestionnaireRepository $repository;

    public function __construct(PDO $pdo)
    {
        $this->repository = new GestionnaireRepository($pdo);
    }

    public function ajouter(Utilisateur $u): void
    {
        $this->repository->ajouter($u);
    }

    public function modifier(Utilisateur $u): void
    {
        $this->repository->modifier($u);
    }

    public function archiver(Utilisateur $u): void
    {
        $this->repository->archiver($u);
    }

    public function lister(): array
    {
        return $this->repository->lister();
    }

    public function listerTous(): array 
    {
        return $this->repository->listerTous();
    }

    public function recupererParId(int $id): ?Utilisateur
    {
        $utilisateur = $this->repository->recupererParId($id);
        return $utilisateur ? new Utilisateur($utilisateur->toArray()) : null;

    }

    public function recupererParLogin(string $login): ?Utilisateur
    {
        $utilisateur = $this->repository->recupererParLogin($login);
        if (!$utilisateur) return null;
        return new Utilisateur($utilisateur->toArray());

    }

    public function supprimerParId(int $id): void
    {
        $this->repository->supprimerParId($id);
    }

    public function rechercher(string $motcle): array 
    {
        return $this->repository->rechercher($motcle);
    }

}
