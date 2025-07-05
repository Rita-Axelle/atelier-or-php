<?php

class ArticleVente
{
    private ?int $id = null;
    private string $libelle;
    private float $prix_vente;
    private int $quantite_stock;
    private float $montant_vente;
    private ?string $photo = null;
    private string $categorie = 'vente';
    private string $etat;


    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->libelle = $data['libelle'] ?? '';
        $this->categorie = $data['categorie'] ?? 'vente';
        $this->prix_vente = isset($data['prix_vente']) ? (float)$data['prix_vente'] : 0.0;
        $this->quantite_stock = isset($data['quantite_stock']) ? (int)$data['quantite_stock'] : 0;
        $this->montant_vente = isset($data['montant_vente']) ? (float)$data['montant_vente'] : 0.0;
        $this->photo = $data['photo'] ?? null;
        $this->etat = $data['etat'] ?? 'actif';
    }

    // Getters et setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getLibelle(): string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void {
        $this->libelle = $libelle;
    }

    public function getPrixVente(): float
    {
        return $this->prix_vente;
    }

    public function setPrixVente(float $prix_vente): void
    {
        $this->prix_vente = $prix_vente;
    }

    public function getQuantiteStock(): int
    {
        return $this->quantite_stock;
    }

    public function setQuantiteStock(int $quantite_stock): void
    {
        $this->quantite_stock = $quantite_stock;
    }

    public function getMontantVente(): float
    {
        return $this->montant_vente;
    }

    public function setMontantVente(float $montant_vente): void
    {
        $this->montant_vente = $montant_vente;
    }

    public function getPhoto(): ?string {
        return $this->photo;
    }

    public function setPhoto(?string $photo): void {
        $this->photo = $photo;
    }

    public function getCategorie(): string {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): void {
        $this->categorie = $categorie;
    }

    public function getEtat(): string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }

    // Pour convertir en tableau (utile pour insert/update)
    public function toArray(): array {
        return [
            'id' => $this->id ?? null,
            'libelle' => $this->libelle,
            'categorie' => $this->categorie,
            'prix_vente' => $this->prix_vente,
            'quantite_stock' => $this->quantite_stock,
            'montant_vente' => $this->montant_vente,
            'photo' => $this->photo,
            'etat' => $this->etat
        ];
    }
}
