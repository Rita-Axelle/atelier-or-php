<?php

require_once __DIR__ . '/../models/Fournisseur.php';

class FournisseurRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouter(Fournisseur $f): void
    {
        $sql = "INSERT INTO fournisseur (nom, prenom, telephone_portable, telephone_fixe, adresse, photo, etat)
                VALUES (:nom, :prenom, :telephone_portable, :telephone_fixe, :adresse, :photo, :etat)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($f->toArray());
    }

    public function modifier(Fournisseur $f): void
    {
        $sql = "UPDATE fournisseur SET nom = :nom, prenom = :prenom, telephone_portable = :telephone_portable,
                telephone_fixe = :telephone_fixe, adresse = :adresse, photo = :photo, etat = :etat
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $data = $f->toArray();
        $data['id'] = $f->getId(); 

        $stmt->execute($data);
        }

    public function supprimer(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM fournisseur WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function archiver(int $id): void
    {
        $stmt = $this->pdo->prepare("UPDATE fournisseur SET etat = 'archive' WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function recupererParId(int $id): ?Fournisseur
    {
        $stmt = $this->pdo->prepare("SELECT * FROM fournisseur WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Fournisseur($row) : null;
    }

    public function recupererTous(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM fournisseur ORDER BY nom, prenom");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Fournisseur($row);
        }
        return $result;
    }

    public function recupererTousActifsAssoc(): array
    {
        $sql = "SELECT id, CONCAT(nom, ' ', prenom) AS nom_complet FROM fournisseur WHERE etat = 'actif' ORDER BY nom, prenom";
        $stmt = $this->pdo->query($sql);

        $assoc = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $assoc[$row['id']] = $row['nom_complet'];
        }

        return $assoc;
    }

    public function rechercher(array $criteres): array
    {
        $sql = "SELECT * FROM fournisseur WHERE 1=1";
        $params = [];

        if (!empty($criteres['nom'])) {
            $sql .= " AND nom LIKE ?";
            $params[] = '%' . $criteres['nom'] . '%';
        }

        if (!empty($criteres['prenom'])) {
            $sql .= " AND prenom LIKE ?";
            $params[] = '%' . $criteres['prenom'] . '%';
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $resultats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultats[] = new Fournisseur($row);
        }

        return $resultats;
    }
    public function recupererTousAssoc(): array
    {
        $sql = "SELECT id, CONCAT(nom, ' ', prenom) AS nom_complet FROM fournisseur ORDER BY nom, prenom";
        $stmt = $this->pdo->query($sql);

        $assoc = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $assoc[$row['id']] = $row['nom_complet'];
        }

        return $assoc;
    }

}
