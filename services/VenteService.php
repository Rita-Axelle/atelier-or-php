<?php

require_once __DIR__ . '/../models/Vente.php';
require_once __DIR__ . '/../repository/VenteRepository.php';

class VenteService
{
    private VenteRepository $venteRepo;

    public function __construct(VenteRepository $venteRepo)
    {
        $this->venteRepo = $venteRepo;
    }

    public function ajouterVente(array $data): void
    {
        $vente = new Vente($data);
        $this->venteRepo->ajouter($vente);
    }

    public function modifierVente(array $data): void
    {
        $vente = new Vente($data);
        $this->venteRepo->modifier($vente);
    }

    public function recupererParId(int $id): ?Vente
    {
        return $this->venteRepo->recupererParId($id);
    }

    public function listerToutes(): array
    {
        return $this->venteRepo->listerToutes();
    }

    public function filtrer(?string $date = null, ?int $clientId = null, ?int $articleId = null): array
    {
        return $this->venteRepo->filtrer($date, $clientId, $articleId);
    }

    public function recupererToutesParVendeur(int $vendeurId): array
    {
        return $this->venteRepo->recupererParVendeur($vendeurId);
    }

    public function calculerMontantTotal(): float
    {
        $ventes = $this->listerToutes();
        $total = 0;

        foreach ($ventes as $vente) {
            $total += $vente->getMontant();
        }

        return $total;
    }


}
