<?php

class Client
{
    private ?int $id;
    private string $nom;
    private string $prenom;
    private string $telephonePortable;
    private string $adresse;
    private ?string $observation;
    private ?string $photo;
    private string $etat;

    public function __construct(array $data)
    {
        $this->id = !empty($data['id']) ? (int) $data['id'] : null;
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->telephonePortable = $data['telephone_portable'];
        $this->adresse = $data['adresse'];
        $this->observation = $data['observation'] ?? null;
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
        return $this->telephonePortable; 
    }

    public function getAdresse(): string { 
        return $this->adresse; 
    }

    public function getObservation(): ?string { 
        return $this->observation; 
    }

    public function getPhoto(): ?string { 
        return $this->photo; 
    }

    public function getEtat(): string { 
        return $this->etat; 
    }


    // Setters
    public function setNom(string $nom): void { 
        $this->nom = $nom; 
    }

    public function setPrenom(string $prenom): void { 
        $this->prenom = $prenom; 
    }

    public function setTelephonePortable(string $tel): void { 
        $this->telephonePortable = $tel; 
    }

    public function setAdresse(string $adresse): void { 
        $this->adresse = $adresse; 
    }

    public function setObservation(?string $obs): void { 
        $this->observation = $obs; 
    }

    public function setPhoto(?string $photo): void { 
        $this->photo = $photo; 
    }

    public function setEtat(string $etat): void { 
        $this->etat = $etat; 
    }

    // Pour convertir en tableau (utile pour insert/update)
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'telephone_portable' => $this->telephonePortable,
            'adresse' => $this->adresse,
            'observation' => $this->observation,
            'photo' => $this->photo,
            'etat' => $this->etat,
        ];
    }
}
