<?php

class Fournisseur
{
    private ?int $id = null;
    private string $nom;
    private string $prenom;
    private string $telephone_portable;
    private string $telephone_fixe;
    private string $adresse;
    private ?string $photo ;
    private string $etat;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->telephone_portable = $data['telephone_portable'];
        $this->telephone_fixe = $data['telephone_fixe'];
        $this->adresse = $data['adresse'];
        $this->photo = $data['photo'] ?? null;
        $this->etat = $data['etat'] ?? 'actif';
    }

    // Getters 

    public function getId(): ?int { 
        return $this->id; 
    }

    public function getNom(): string { 
        return $this->nom; 
    }

    public function getPrenom(): string { 
        return $this->prenom; 
    }

    public function getTelephonePortable(): string { 
        return $this->telephone_portable; 
    }

    public function getTelephoneFixe(): string {
        return $this->telephone_fixe; 
    }

    public function getAdresse(): string { 
        return $this->adresse; 
    }

    public function getPhoto(): ?string { 
        return $this->photo; 
    }

    public function getEtat(): string { 
        return $this->etat; 
    }

    // Setters...

    public function setId(?int $id): void { 
        $this->id = $id; 
    }
    public function setNom(string $nom): void { 
        $this->nom = $nom; 
    }

    public function setPrenom(string $prenom): void { 
        $this->prenom = $prenom; 
    }

    public function setTelephonePortable(string $telephone_portable): void { 
        $this->telephone_portable = $telephone_portable; 
    }

    public function setTelephoneFixe(string $telephone_fixe): void { 
        $this->telephone_fixe = $telephone_fixe; 
    }

    public function setAdresse(string $adresse): void { 
        $this->adresse = $adresse; 
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
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'telephone_portable' => $this->telephone_portable,
            'telephone_fixe' => $this->telephone_fixe,
            'adresse' => $this->adresse,
            'photo' => $this->photo,
            'etat' => $this->etat
        ];
    }
}
