<?php

require_once __DIR__ . '/../models/Vente.php';

class VenteRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouter(Vente $vente): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO vente (date_vente, quantite, prix, montant, observation, article_vente_id, client_id, vendeur_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $vente->getDateVente()->format('Y-m-d'),
            $vente->getQuantite(),
            $vente->getPrix(),
            $vente->getMontant(),
            $vente->getObservation(),
            $vente->getArticleVenteId(),
            $vente->getClientId(),
            $vente->getVendeurId()
        ]);
    }

    public function modifier(Vente $vente): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE vente SET date_vente = ?, quantite = ?, prix = ?, montant = ?, observation = ?, article_vente_id = ?, client_id = ?, vendeur_id = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $vente->getDateVente()->format('Y-m-d'),
            $vente->getQuantite(),
            $vente->getPrix(),
            $vente->getMontant(),
            $vente->getObservation(),
            $vente->getArticleVenteId(),
            $vente->getClientId(),
            $vente->getVendeurId(),
            $vente->getId()
        ]);
    }

    public function recupererParId(int $id): ?Vente
    {
        $stmt = $this->pdo->prepare("SELECT * FROM vente WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Vente($data) : null;
    }

    public function listerToutes(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM vente ORDER BY date_vente DESC");
        return array_map(fn($row) => new Vente($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function filtrer(?string $date, ?int $clientId, ?int $articleId): array
    {
        $sql = "SELECT * FROM vente WHERE 1=1";
        $params = [];

        if ($date) {
            $sql .= " AND date_vente = ?";
            $params[] = $date;
        }

        if ($clientId) {
            $sql .= " AND client_id = ?";
            $params[] = $clientId;
        }

        if ($articleId) {
            $sql .= " AND article_vente_id = ?";
            $params[] = $articleId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return array_map(fn($row) => new Vente($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function recupererParVendeur(int $vendeurId): array
    {
        $sql = "SELECT * FROM vente WHERE vendeur_id = :vendeur_id ORDER BY date_vente DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['vendeur_id' => $vendeurId]);

        $ventes = [];
        while ($row = $stmt->fetch()) {
            $ventes[] = new Vente($row);
        }

        return $ventes;
    }

    public function recupererTousAssoc(): array {
        $sql = "SELECT id, nom, prenom FROM client";
        $stmt = $this->pdo->query($sql);
        $result = [];
        while ($row = $stmt->fetch()) {
            $result[$row['id']] = $row['nom'] . ' ' . $row['prenom'];
        }
        return $result;
    }


}
