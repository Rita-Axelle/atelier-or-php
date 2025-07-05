<?php
require_once dirname(__DIR__) . '/models/ArticleVente.php';
require_once dirname(__DIR__) . '/repository/ArticleVenteRepository.php';

class ArticleVenteService
{
    private ArticleVenteRepository $repository;

    public function __construct(PDO $pdo)
    {
        $this->repository = new ArticleVenteRepository($pdo);
    }

    public function lister(): array
    {
        return $this->repository->listerTous();
    }

    public function recupererParId(int $id): ?ArticleVente
    {
        return $this->repository->recupererParId($id);
    }

    public function ajouter(ArticleVente $article): bool
    {
        $article->setMontantVente($article->getPrixVente() * $article->getQuantiteStock());
        return $this->repository->ajouter($article);
    }

    public function modifier(ArticleVente $article): bool
    {
        $article->setMontantVente($article->getPrixVente() * $article->getQuantiteStock());
        return $this->repository->modifier($article);
    }

    public function archiver(ArticleVente $article): bool
    {
        return $this->repository->archiver($article);
    }

    public function supprimer(int $id): bool
    {
        return $this->repository->supprimer($id);
    }

    public function rechercherParLibelle(string $libelle = ''): array
    {
        return $this->repository->rechercherParLibelle($libelle);
    }
}
