<?php

class Approvisionnement
{
    private ?int $id = null;
    private DateTime $dateAppro;
    private int $articleConfectionId;
    private int $quantite;
    private float $prix;
    private float $montant;
    private string $observation;
    private int $fournisseurId;
    private int $responsableStockId;

     public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->dateAppro = $data['date_appro'] instanceof DateTime
            ? $data['date_appro']
            : new DateTime($data['date_appro']);
        $this->articleConfectionId = (int)$data['article_confection_id'];
        $this->quantite = (int)$data['quantite'];
        $this->prix = (float)$data['prix'];
        $this->montant = (float)$data['montant'];
        $this->observation = $data['observation'] ?? '';
        $this->fournisseurId = (int)$data['fournisseur_id'];
        $this->responsableStockId = (int)$data['responsable_stock_id'];
    }


    // Getters 

    public function getId(): ?int {
        return $this->id;
    }

    public function getDateAppro(): DateTime {
        return $this->dateAppro;
    }

    public function getQuantite(): int {
        return $this->quantite;
    }

    public function getPrix(): float {
        return $this->prix;
    }

    public function getMontant(): float {
        return $this->montant;
    }

    public function getArticleConfectionId(): int {
        return $this->articleConfectionId;
    }

    public function getFournisseurId(): int {
        return $this->fournisseurId;
    }

    public function getResponsableStockId(): int {
        return $this->responsableStockId;
    }
    
    public function getObservation(): ?string {
        return $this->observation;
    }


    // Setters

    public function setId(?int $id): void {
        $this->id = $id;
    }
    
    public function setDateAppro(DateTime $dateAppro): void {
        $this->dateAppro = $dateAppro;
    }

    public function setQuantite(int $quantite): void {
        $this->quantite = $quantite;
    }

    public function setPrix(float $prix): void {
        $this->prix = $prix;
    }

    public function setMontant(float $montant): void {
        $this->montant = $montant;
    }

    public function setArticleConfectionId(int $articleConfectionId): void {
        $this->articleConfectionId = $articleConfectionId;
    }

    public function setFournisseurId(int $fournisseurId): void {
        $this->fournisseurId = $fournisseurId;
    }

    public function setResponsableStockId(int $responsableStockId): void {
        $this->responsableStockId = $responsableStockId;
    }

    public function setObservation(?string $observation): void {
        $this->observation = $observation;
    }

    // Pour convertir en tableau (utile pour insert/update)
    public function toArray(): array {
        return [
            'date_appro' => $this->dateAppro->format('Y-m-d'),
            'quantite' => $this->quantite,
            'prix' => $this->prix,
            'montant' => $this->montant,
            'observation' => $this->observation,
            'article_confection_id' => $this->articleConfectionId,
            'fournisseur_id' => $this->fournisseurId,
            'responsable_stock_id' => $this->responsableStockId
        ];
    }
}
