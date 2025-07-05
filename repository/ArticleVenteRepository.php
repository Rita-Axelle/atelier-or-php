<?php

require_once dirname(__DIR__) . '/models/ArticleVente.php';

class ArticleVenteRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouter(ArticleVente $article): bool
    {
        $sql = "INSERT INTO article_vente (libelle, categorie, prix_vente, quantite_stock, montant_vente, photo, etat)
                VALUES (:libelle, :categorie, :prix_vente, :quantite_stock, :montant_vente, :photo, :etat)";
        $stmt = $this->pdo->prepare($sql);
        $data = $article->toArray();
        unset($data['id']); // id auto-incrémenté
        return $stmt->execute($data);
    }


    public function modifier(ArticleVente $article): bool
    {
        $sql = "UPDATE article_vente SET
                libelle = :libelle,
                prix_vente = :prix_vente,
                quantite_stock = :quantite_stock,
                montant_vente = :montant_vente,
                photo = :photo,
                categorie = :categorie,
                etat = :etat
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($article->toArray());
    }

    public function archiver(ArticleVente $article): bool
    {
        $stmt = $this->pdo->prepare("UPDATE article_vente SET etat = 'archive' WHERE id = :id");
        return $stmt->execute(['id' => $article->getId()]);
    }

    public function supprimer(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM article_vente WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function listerActif(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM article_vente WHERE etat = 'actif' ORDER BY libelle");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];
        foreach ($results as $row) {
            $articles[] = new ArticleVente($row);
        }
        return $articles;
    }

    public function listerTous(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM article_vente ORDER BY libelle");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];
        foreach ($results as $row) {
            $articles[] = new ArticleVente($row);
        }
        return $articles;
    }

    public function recupererParId(int $id): ?ArticleVente
    {
        $stmt = $this->pdo->prepare("SELECT * FROM article_vente WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ArticleVente($row);
        }
        return null;
    }

    public function rechercherParLibelle(string $libelle = ''): array
    {
        $sql = "SELECT * FROM article_vente";
        if (!empty($libelle)) {
            $sql .= " WHERE libelle LIKE :libelle";
        }

        $sql .= " ORDER BY libelle";

        $stmt = $this->pdo->prepare($sql);
        if (!empty($libelle)) {
            $stmt->bindValue(':libelle', '%' . $libelle . '%');
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];
        foreach ($rows as $row) {
            $articles[] = new ArticleVente($row);
        }
        return $articles;
    }

    public function recupererTousAssoc(): array {
        $sql = "SELECT id, libelle FROM article_vente";
        $stmt = $this->pdo->query($sql);
        $articles = [];

        while ($row = $stmt->fetch()) {
            $articles[$row['id']] = $row['libelle'];
        }

        return $articles;
    }



}
