<?php
require_once 'Utilisateur.php';
require_once dirname(__DIR__) . '/repository/UtilisateurRepository.php';
require_once dirname(__DIR__) . '/repository/VenteRepository.php';
require_once dirname(__DIR__) . '/repository/ApprovisionnementRepository.php';
require_once dirname(__DIR__) . '/repository/ProductionRepository.php';

class Gestionnaire extends Utilisateur{
    
    private UtilisateurRepository $utilisateurRepository;
    private VenteRepository $venteRepository;
    private ApprovisionnementRepository $approvisionnementRepository;
    private ProductionRepository $productionRepository;

    public function __construct(array $data, PDO $pdo)
    {
        parent::__construct($data);
        $this->setRole('gestionnaire');
        $this->utilisateurRepository = new UtilisateurRepository($pdo);
        $this->venteRepository = new VenteRepository($pdo);
        $this->approvisionnementRepository = new ApprovisionnementRepository($pdo);
        $this->productionRepository = new ProductionRepository($pdo);
    }

    public function ajouterUtilisateur(Utilisateur $utilisateur): bool {
        $this->utilisateurRepository->ajouter($utilisateur);
        return true;
    }

    public function archiverUtilisateur(int $id): bool {
        $this->utilisateurRepository->archiverParId($id);
        return true;
    }

    public function modifierUtilisateur(Utilisateur $utilisateur): bool {
        $this->utilisateurRepository->modifier($utilisateur);
        return true;
    }

    public function listerUtilisateur(string $role): array {
        return $this->utilisateurRepository->listerParRole($role);
    }

    public function genererRapportGlobal(): array {
        return [
            'nbUtilisateurs' => count($this->utilisateurRepository->lister()),
            'nbArticles' => $this->productionRepository->compterArticlesStock(),
            'nbVentes' => $this->venteRepository->compterVentesAujourdHui(),
            'nbProductions' => $this->productionRepository->compterProductionsEnCours(),
            'nbAppro' => $this->approvisionnementRepository->compterApprovisionnements()
        ];
    }
}
