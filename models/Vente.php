<?php

class Vente
{
    private ?int $id = null;
    private DateTime $date_vente;
    private int $quantite;
    private float $prix;
    private float $montant;
    private ?string $observation;
    private int $article_vente_id;
    private int $client_id;
    private int $vendeur_id;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->date_vente = new DateTime($data['date_vente'] ?? 'now');
        $this->quantite = (int)($data['quantite'] ?? 0);
        $this->prix = (float)($data['prix'] ?? 0.0);
        $this->montant = (float)($data['montant'] ?? 0.0);
        $this->observation = $data['observation'] ?? null;
        $this->article_vente_id = (int)($data['article_vente_id'] ?? 0);
        $this->client_id = (int)($data['client_id'] ?? 0);
        $this->vendeur_id = (int)($data['vendeur_id'] ?? 0);
    }

    // Getters
    public function getId(): ?int { 
        return $this->id; 
    }

    public function getDateVente(): DateTime { 
        return $this->date_vente; 
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

    public function getObservation(): ?string { 
        return $this->observation; 
    }

    public function getArticleVenteId(): int { 
        return $this->article_vente_id; 
    }

    public function getClientId(): int { 
        return $this->client_id; 
    }

    public function getVendeurId(): int { 
        return $this->vendeur_id; 
    }

    // Setters
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function setDateVente(DateTime $_vente): void { 
        $this->date_vente = $date_vente; 
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

    public function setObservation(?string $observation): void { 
        $this->observation = $observation; 
    }

    public function setArticleVenteId(int $article_vente_id): void { 
        $this->article_vente_id = $article_vente_id; 
    }

    public function setClientId(int $client_id): void { 
        $this->client_id = $client_id; 
    }

    public function setVendeurId(int $vendeur_id): void { 
        $this->vendeur_id = $vendeur_id; 
    }

    // Pour convertir en tableau (utile pour insert/update)
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date_vente ' => $this->date_vente->format('Y-m-d'),
            'quantite' => $this->quantite,
            'prix' => $this->prix,
            'montant' => $this->montant,
            'observation' => $this->observation,
            'article_vente_id' => $this->article_vente_id,
            'client_id' => $this->client_id,
            'vendeur_id' => $this->vendeur_id,
        ];
    }

}
