<?php

require_once __DIR__ . '/../models/Client.php';

class ClientRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouter(Client $client): void
    {
        $sql = "INSERT INTO client (nom, prenom, telephone_portable, adresse, observation, photo, etat)
                VALUES (:nom, :prenom, :telephone, :adresse, :observation, :photo, :etat)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $client->getNom(),
            'prenom' => $client->getPrenom(),
            'telephone' => $client->getTelephonePortable(),
            'adresse' => $client->getAdresse(),
            'observation' => $client->getObservation(),
            'photo' => $client->getPhoto(),
            'etat' => $client->getEtat()
        ]);
    }

    public function modifier(Client $client): void
    {
        $sql = "UPDATE client SET nom = :nom, prenom = :prenom, telephone_portable = :telephone,
                adresse = :adresse, observation = :observation, photo = :photo WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $client->getNom(),
            'prenom' => $client->getPrenom(),
            'telephone' => $client->getTelephonePortable(),
            'adresse' => $client->getAdresse(),
            'observation' => $client->getObservation(),
            'photo' => $client->getPhoto(),
            'id' => $client->getId()
        ]);
    }

    public function supprimer(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM client WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function archiver(int $id): void
    {
        $stmt = $this->pdo->prepare("UPDATE client SET etat = 'archive' WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function recupererParId(int $id): ?Client
    {
        $stmt = $this->pdo->prepare("SELECT * FROM client WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Client($data) : null;
    }

    public function listerActifs(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM client WHERE etat = 'actif'");
        $resultats = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = new Client($data);
        }
        return $resultats;
    }

    public function listerTous(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM client");
        $resultats = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = new Client($data);
        }
        return $resultats;
    }

    public function recupererTous(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM client ORDER BY nom, prenom");
        $resultats = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = new Client($data);
        }
        return $resultats;
    }

    public function recupererTousAssoc(): array {
        $sql = "SELECT id, nom, prenom FROM client";
        $stmt = $this->pdo->query($sql);
        $clients = [];

        while ($row = $stmt->fetch()) {
            $clients[$row['id']] = $row['nom'] . ' ' . $row['prenom'];
        }

        return $clients;
    }

    public function rechercher(string $motcle): array {
        $sql = "SELECT * FROM client WHERE etat = 'actif'
                AND (nom LIKE :motcle OR prenom LIKE :motcle OR adresse LIKE :motcle)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['motcle' => "%$motcle%"]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new Client($row), $rows);
    }


}
