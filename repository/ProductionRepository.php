<?php
require_once __DIR__ . '/../models/Production.php';
class ProductionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouter(Production $production): void
    {
        $sql = "INSERT INTO production (date_production, quantite, observation, article_vente_id, responsable_production_id)
                VALUES (:date_production, :quantite, :observation, :article_vente_id, :responsable_production_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':date_production' => $production->getDateProduction()->format('Y-m-d'),
            ':quantite' => $production->getQuantite(),
            ':observation' => $production->getObservation(),
            ':article_vente_id' => $production->getArticleVenteId(),
            ':responsable_production_id' => $production->getResponsableProductionId()
        ]);
    }

    public function modifier(Production $production): void
    {
        $sql = "UPDATE production SET 
                    date_production = :date_production,
                    quantite = :quantite,
                    observation = :observation,
                    article_vente_id = :article_vente_id
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':date_production' => $production->getDateProduction()->format('Y-m-d'),
            ':quantite' => $production->getQuantite(),
            ':observation' => $production->getObservation(),
            ':article_vente_id' => $production->getArticleVenteId(),
            ':id' => $production->getId()
        ]);
    }

    public function listerToutes(): array
    {
        $sql = "SELECT p.*, a.libelle AS libelle_article
                FROM production p
                JOIN article_vente a ON p.article_vente_id = a.id
                ORDER BY p.date_production DESC";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        

    public function listerParJour(DateTime $date): array
    {
        $sql = "SELECT p.*, a.libelle AS libelle_article
                FROM production p
                JOIN article_vente a ON p.article_vente_id = a.id
                WHERE p.date_production = :date";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':date' => $date->format('Y-m-d')
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function listerParPeriodeEtLibelle(DateTime $debut, DateTime $fin, string $libelle): array
    {
        $sql = "SELECT p.*, a.libelle AS libelle_article
                FROM production p
                JOIN article_vente a ON p.article_vente_id = a.id
                WHERE p.date_production BETWEEN :debut AND :fin
                AND a.libelle LIKE :libelle
                ORDER BY p.date_production DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':debut' => $debut->format('Y-m-d'),
            ':fin' => $fin->format('Y-m-d'),
            ':libelle' => "%$libelle%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function recupererParId(int $id): ?Production
    {
        $sql = "SELECT * FROM production WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Production($data) : null;
    }
}
