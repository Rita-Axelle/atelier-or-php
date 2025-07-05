<?php

require_once __DIR__ . '/../repository/ProductionRepository.php';
require_once __DIR__ . '/../repository/ArticleVenteRepository.php';
require_once __DIR__ . '/../models/Production.php';

class ProductionService
{
    private ProductionRepository $repository;
    private ArticleVenteRepository $articleRepository;

    public function __construct(ProductionRepository $repository, ArticleVenteRepository $articleRepository)
    {
        $this->repository = $repository;
        $this->articleRepository = $articleRepository;
    }

    public function ajouterProduction(array $data): void
    {
        $production = new Production($data);
        $this->repository->ajouter($production);

        // Mise à jour stock article
        $article = $this->articleRepository->recupererParId($production->getArticleVenteId());
        if ($article) {
            $nouvelleQuantite = $article->getQuantiteStock() + $production->getQuantite();
            $article->setQuantiteStock($nouvelleQuantite);
            $article->setMontantVente($nouvelleQuantite * $article->getPrixVente());
            $this->articleRepository->modifier($article);
        }
    }

    public function modifierProduction(array $data): void
{
    $production = new Production($data);
    $ancienneProd = $this->repository->recupererParId($production->getId());

    if (!$ancienneProd) {
        return;
    }

    $this->repository->modifier($production);

    $ancienArticleId = $ancienneProd->getArticleVenteId();
    $nouvelArticleId = $production->getArticleVenteId();

    // Cas : article inchangé
    if ($ancienArticleId === $nouvelArticleId) {
        $article = $this->articleRepository->recupererParId($ancienArticleId);
        if ($article) {
            $diff = $production->getQuantite() - $ancienneProd->getQuantite();
            $article->setQuantiteStock($article->getQuantiteStock() + $diff);
            $article->setMontantVente($article->getQuantiteStock() * $article->getPrixVente());
            $this->articleRepository->modifier($article);
        }
    } else {
        // Cas : changement d'article
        $ancienArticle = $this->articleRepository->recupererParId($ancienArticleId);
        $nouvelArticle = $this->articleRepository->recupererParId($nouvelArticleId);

        if ($ancienArticle) {
            $ancienArticle->setQuantiteStock($ancienArticle->getQuantiteStock() - $ancienneProd->getQuantite());
            $ancienArticle->setMontantVente($ancienArticle->getQuantiteStock() * $ancienArticle->getPrixVente());
            $this->articleRepository->modifier($ancienArticle);
        }

        if ($nouvelArticle) {
            $nouvelArticle->setQuantiteStock($nouvelArticle->getQuantiteStock() + $production->getQuantite());
            $nouvelArticle->setMontantVente($nouvelArticle->getQuantiteStock() * $nouvelArticle->getPrixVente());
            $this->articleRepository->modifier($nouvelArticle);
        }
    }
}


    public function listerToutes(): array
    {
        return $this->repository->listerToutes();
    }

    public function listerParJour(DateTime $date): array
    {
        return $this->repository->listerParJour($date);
    }

    public function listerParPeriodeEtLibelle(DateTime $debut, DateTime $fin, string $libelle): array
    {
        return $this->repository->listerParPeriodeEtLibelle($debut, $fin, $libelle);
    }

    public function recupererParId(int $id): ?Production
    {
        return $this->repository->recupererParId($id);
    }
}
