<?php

require_once __DIR__ . '/../repository/ApprovisionnementRepository.php';
require_once __DIR__ . '/../models/Approvisionnement.php';

class ApprovisionnementService
{
    private ApprovisionnementRepository $repo;

    public function __construct(PDO $pdo)
    {
        $this->repo = new ApprovisionnementRepository($pdo);
    }

    public function ajouter(array $data): void
    {
        $data['date_appro'] = new DateTime($data['date_appro']);
        $appro = new Approvisionnement($data);
        $this->repo->ajouter($appro);
    }

    public function modifier(array $data): void
    {
        $data['date_appro'] = new DateTime($data['date_appro']);
        $appro = new Approvisionnement($data);
        $this->repo->modifier($appro);
    }

    public function supprimer(int $id): void
    {
        $this->repo->supprimer($id);
    }

    public function archiver(int $id): void
    {
        $this->repo->archiver($id);
    }

    public function recupererParId(int $id): ?Approvisionnement
    {
        return $this->repo->recupererParId($id);
    }

    public function recupererTous(): array
    {
        return $this->repo->recupererTous();
    }

    public function rechercher(array $criteres): array
    {
        if (!empty($criteres['date_appro'])) {
            $criteres['date_appro'] = (new DateTime($criteres['date_appro']))->format('Y-m-d');
        }
        return $this->repo->rechercher($criteres);
    }
}
