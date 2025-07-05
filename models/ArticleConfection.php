<?php

class ArticleConfection
{
    private ?int $id = null;
    private string $libelle;
    private string $categorie;
    private float $prixAchat;
    private int $quantiteAchat = 0;
    private int $quantiteStock = 0;
    private float $montantStock;
    private ?string $photo = null;
    private string $etat;


    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->libelle = $data['libelle'];
        $this->categorie = $data['categorie'] ?? 'confection';
        $this->prixAchat = (float)$data['prix_achat'];
        $this->quantiteAchat = (int)$data['quantite_achat'];
        $this->quantiteStock = (int)$data['quantite_stock'];
        $this->montantStock = (float)$data['montant_stock'];
        $this->photo = $data['photo'] ?? null;
        $this->etat = $data['etat'] ?? 'actif';
    }


    // Getters
    public function getId(): ?int { 
        return $this->id; 
    }

    public function getLibelle(): string {
        return $this->libelle;
    }

    public function getCategorie(): string {
        return $this->categorie;
    }

    public function getPrixAchat(): float { 
        return $this->prixAchat; 
    }

    public function getQuantiteAchat(): int { 
        return $this->quantiteAchat; 
    }

    public function getQuantiteStock(): int {
        return $this->quantiteStock;
    }
    
    public function getMontantStock(): float { 
        return $this->montantStock; 
    }

    public function getPhoto(): ?string {
        return $this->photo;
    }

    public function getEtat(): string { 
        return $this->etat; 
    }


    // Setters
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function setLibelle(string $libelle): void {
        $this->libelle = $libelle;
    }

    public function setPrixAchat(float $prixAchat): void { 
        $this->prixAchat = $prixAchat; 
    }

    public function setQuantiteAchat(int $quantiteAchat): void { 
        $this->quantiteAchat = $quantiteAchat; 
    }

    public function setQuantiteStock(int $quantiteStock): void {
        $this->quantiteStock = $quantiteStock;
    }

    public function setMontantStock(float $montantStock): void {
        $this->montantStock = $montantStock;
    }

    public function setPhoto(?string $photo): void { 
        $this->photo = $photo; 
    }

    public function setEtat(string $etat): void { 
        $this->etat = $etat;
    } 

    // Pour convertir en tableau (utile pour insert/update)
    public function toArray(): array {
        return [
            'id' => $this->id ?? null,
            'libelle' => $this->libelle,
            'categorie' => $this->categorie,
            'prix_achat' => $this->prixAchat,
            'quantite_achat' => $this->quantiteAchat,
            'quantite_stock' => $this->quantiteStock,
            'montant_stock' => $this->montantStock,
            'photo' => $this->photo,
            'etat' => $this->etat
        ];
    }
}
