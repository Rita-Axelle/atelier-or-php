<?php

class Production
{
    protected ?int $id = null;
    private DateTime $date_production;
    private int $quantite;
    private ?string $observation;
    private int $article_vente_id;
    private int $responsable_production_id;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->date_production = new DateTime($data['date_production'] ?? 'now');
        $this->quantite = (int)($data['quantite'] ?? 0);
        $this->observation = $data['observation'] ?? null;
        $this->article_vente_id = (int)($data['article_vente_id'] ?? 0);
        $this->responsable_production_id = (int)($data['responsable_production_id'] ?? 0);
    }


    // Getters 

    public function getId(): ?int { 
        return $this->id; 
    }

    public function getDateProduction(): DateTime { 
        return $this->date_production; 
    }

    public function getDateProductionFormatted(): string {
        return $this->date_production->format('d/m/Y');
    }

    public function getQuantite(): int { 
        return $this->quantite; 
    }

    public function getObservation(): ?string { 
        return $this->observation; 
    }

    public function getArticleVenteId(): int { 
        return $this->article_vente_id; 
    }

    public function getResponsableProductionId(): int { 
        return $this->responsable_production_id; 
    }


    // Setters

    public function setId(?int $id): void { 
        $this->id = $id; 
    }

    public function setDateProduction(DateTime $date): void { 
        $this->date_production = $date; 
    }

    public function setQuantite(int $q): void { 
        $this->quantite = $q; 
    }

    public function setObservation(?string $o): void { 
        $this->observation = $o; 
    }

    public function setArticleVenteId(int $id): void { 
        $this->article_vente_id = $id; 
    }

    public function setResponsableProductionId(int $id): void { 
        $this->responsable_production_id = $id; 
    }
}
