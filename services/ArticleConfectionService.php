<?php
require_once dirname(__DIR__) . '/models/ArticleConfection.php';
require_once dirname(__DIR__) . '/repository/ArticleConfectionRepository.php';

class ArticleConfectionService
{
    private ArticleConfectionRepository $repository;

    public function __construct(PDO $pdo)
    {
        $this->repository = new ArticleConfectionRepository($pdo);
    }

    public function lister(): array
    {
        return $this->repository->lister();
    }

    public function recupererParId(int $id): ?ArticleConfection
    {
        return $this->repository->recupererParId($id);
    }

    public function ajouter(ArticleConfection $article): bool
    {
        return $this->repository->ajouter($article);
    }

    public function modifier(ArticleConfection $article): bool
    {
        return $this->repository->modifier($article);
    }

    public function archiver(ArticleConfection $article): bool
    {
        return $this->repository->archiver($article);
    }

    public function supprimer(int $id): bool
    {
        return $this->repository->supprimer($id);
    }

    public function rechercherParLibelle(string $libelle = '') {
        return $this->repository->rechercherParLibelle($libelle);
    }

}
