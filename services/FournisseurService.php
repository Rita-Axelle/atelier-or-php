<?php

require_once __DIR__ . '/../repository/FournisseurRepository.php';
require_once __DIR__ . '/../models/Fournisseur.php';

class FournisseurService
{
    private FournisseurRepository $repo;

    public function __construct(PDO $pdo)
    {
        $this->repo = new FournisseurRepository($pdo);
    }

    public function ajouter(array $data): void
    {
        $data['etat'] = $data['etat'] ?? 'actif';
        $fournisseur = new Fournisseur($data);
        $this->repo->ajouter($fournisseur);
    }

    public function modifier(array $data): void
    {
        $fournisseur = new Fournisseur($data);
        $this->repo->modifier($fournisseur);
    }

    public function supprimer(int $id): void
    {
        $this->repo->supprimer($id);
    }

    public function archiver(int $id): void
    {
        $this->repo->archiver($id);
    }

    public function recupererParId(int $id): ?Fournisseur
    {
        return $this->repo->recupererParId($id);
    }

    public function recupererTous(): array
    {
        return $this->repo->recupererTous();
    }

    public function recupererTousActifsAssoc(): array
    {
        return $this->repo->recupererTousActifsAssoc();
    }

    public function rechercher(array $criteres): array
    {
        return $this->repo->rechercher($criteres);
    }
}
