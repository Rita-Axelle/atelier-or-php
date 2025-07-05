<?php

require_once __DIR__ . '/../repository/ClientRepository.php';
require_once __DIR__ . '/../models/Client.php';

class ClientService
{
    private ClientRepository $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    public function ajouterClient(array $data): void
    {
        $client = new Client($data);
        $this->repository->ajouter($client);
    }

    public function modifierClient(array $data): void
    {
        $client = new Client($data);
        $this->repository->modifier($client);
    }

    public function archiverClient(int $id): void
    {
        $this->repository->archiver($id);
    }

    public function supprimerClient(int $id): void
    {
        $this->repository->supprimer($id);
    }

    public function recupererParId(int $id): ?Client
    {
        return $this->repository->recupererParId($id);
    }

    public function listerActifs(): array
    {
        return $this->repository->listerActifs();
    }

    public function listerTous(): array
    {
        return $this->repository->listerTous();
    }

    public function rechercher(string $motcle): array 
    {
        return $this->repository->rechercher($motcle);
    }

}
