<?php

require_once __DIR__ . '/../models/Approvisionnement.php';

class ApprovisionnementRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouter(Approvisionnement $a): void
    {
        $sql = "INSERT INTO approvisionnement (date_appro, article_confection_id, quantite, prix, montant, observation, fournisseur_id, responsable_stock_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $a->getDateAppro()->format('Y-m-d'),
            $a->getArticleConfectionId(),
            $a->getQuantite(),
            $a->getPrix(),
            $a->getMontant(),
            $a->getObservation(),
            $a->getFournisseurId(),
            $a->getResponsableStockId()
        ]);
    }

    public function recupererTous(): array
    {
        $sql = "SELECT * FROM approvisionnement ORDER BY date_appro DESC";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Approvisionnement($row), $rows);
    }

    public function recupererParId(int $id): ?Approvisionnement
    {
        $sql = "SELECT * FROM approvisionnement WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Approvisionnement($data) : null;
    }

    public function modifier(Approvisionnement $a): void
    {
        $sql = "UPDATE approvisionnement SET date_appro=?, article_confection_id=?, quantite=?, prix=?, montant=?, observation=?, fournisseur_id=?, responsable_stock_id=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $a->getDateAppro()->format('Y-m-d'),
            $a->getArticleConfectionId(),
            $a->getQuantite(),
            $a->getPrix(),
            $a->getMontant(),
            $a->getObservation(),
            $a->getFournisseurId(),
            $a->getResponsableStockId(),
            $a->getId()
        ]);
    }

    public function supprimer(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM approvisionnement WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function archiver(int $id): void
    {
        $sql = "UPDATE approvisionnement SET etat = 'archive' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function rechercher(array $criteres): array
    {
        $sql = "SELECT * FROM approvisionnement WHERE 1=1";
        $params = [];

        if (!empty($criteres['date_appro'])) {
            $sql .= " AND date_appro = ?";
            $params[] = $criteres['date_appro'];
        }

        if (!empty($criteres['article_confection_id'])) {
            $sql .= " AND article_confection_id = ?";
            $params[] = $criteres['article_confection_id'];
        }

        if (!empty($criteres['fournisseur_id'])) {
            $sql .= " AND fournisseur_id = ?";
            $params[] = $criteres['fournisseur_id'];
        }

        $sql .= " ORDER BY date_appro DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Approvisionnement($row), $rows);
    }

}

