<?php
require_once dirname(__DIR__) . '/models/ArticleConfection.php';

class ArticleConfectionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouter(ArticleConfection $article): bool
    {
        $sql = "INSERT INTO article_confection 
            (libelle, categorie, prix_achat, quantite_achat, quantite_stock, montant_stock, photo, etat)
            VALUES (:libelle, :categorie, :prix_achat, :quantite_achat, :quantite_stock, :montant_stock, :photo, :etat)";
        $stmt = $this->pdo->prepare($sql);
        $data = $article->toArray();
        unset($data['id']); // id auto-incrémenté
        return $stmt->execute($data);
    }

    public function modifier(ArticleConfection $article): bool
    {
        $sql = "UPDATE article_confection SET
            libelle = :libelle,
            categorie = :categorie,
            prix_achat = :prix_achat,
            quantite_achat = :quantite_achat,
            quantite_stock = :quantite_stock,
            montant_stock = :montant_stock,
            photo = :photo,
            etat = :etat
            WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data = $article->toArray();
        return $stmt->execute($data);
    }

    public function archiver(ArticleConfection $article): bool
    {
        $stmt = $this->pdo->prepare("UPDATE article_confection SET etat = 'archive' WHERE id = :id");
        return $stmt->execute(['id' => $article->getId()]);
    }

    public function supprimer(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM article_confection WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function lister(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM article_confection ORDER BY libelle WHERE etat = 'actif'");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];
        foreach ($results as $row) {
            $articles[] = new ArticleConfection($row);
        }
        return $articles;
    }

    public function recupererParId(int $id): ?ArticleConfection
    {
        $stmt = $this->pdo->prepare("SELECT * FROM article_confection WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ArticleConfection($row);
        }
        return null;
    }

    public function recupererTousAssoc(): array
    {
        $sql = "SELECT id, libelle FROM article_confection WHERE etat = 'actif' ORDER BY libelle";
        $stmt = $this->pdo->query($sql);

        $assoc = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $assoc[$row['id']] = $row['libelle'];
        }

        return $assoc;
    }

    public function rechercherParLibelle(string $libelle = ''): array {
        $sql = "SELECT * FROM article_confection";
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
            $articles[] = new ArticleConfection($row);
        }
        return $articles;
    }


}
