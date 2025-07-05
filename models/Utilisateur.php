<?php
class Utilisateur {
    protected ?int $id = null;
    protected string $nom;
    protected string $prenom;
    protected string $telephonePortable;
    protected string $adresse;
    protected float $salaire;
    protected ?string $photo = null;
    protected string $login;
    protected string $motDePasse;
    protected string $role;
    private string $etat;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['nom'] ?? '';
        $this->prenom = $data['prenom'] ?? '';
        $this->telephonePortable = $data['telephone_portable'] ?? '';
        $this->adresse = $data['adresse'] ?? '';
        $this->salaire = isset($data['salaire']) ? (float)$data['salaire'] : 0;
        $this->photo = $data['photo'] ?? null;
        $this->login = $data['login'] ?? '';
        $this->motDePasse = $data['mot_de_passe'] ?? '';
        $this->role = $data['role'] ?? '';
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

    public function getSalaire(): float { 
        return $this->salaire; 
    }

    public function getPhoto(): ?string { 
        return $this->photo; 
    }

    public function getLogin(): string { 
        return $this->login; 
    }

    public function getMotDePasse(): string { 
        return $this->motDePasse; 
    }

    public function getRole(): string { 
        return $this->role; 
    }

    public function getEtat(): string { 
        return $this->etat; 
    }


    // Setters
    public function setId(?int $id): void { 
        $this->id = $id; 
    }

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

    public function setSalaire(float $salaire): void { 
        $this->salaire = $salaire; 
    }

    public function setPhoto(?string $photo): void { 
        $this->photo = $photo; 
    }

    public function setLogin(string $login): void { 
        $this->login = $login; 
    }

    public function setMotDePasse(string $mdp): void { 
        $this->motDePasse = $mdp; 
    }

    public function setRole(string $role): void { 
        $this->role = $role; 
    }

    public function setEtat(string $etat): void { 
        $this->etat = $etat; 
    }

    public function toArray(): array {
    return [
        'id' => $this->id ?? null,
        'nom' => $this->nom,
        'prenom' => $this->prenom,
        'telephone_portable' => $this->telephonePortable,
        'adresse' => $this->adresse,
        'salaire' => $this->salaire,
        'login' => $this->login,
        'mot_de_passe' => $this->motDePasse,
        'role' => $this->role,
        'photo' => $this->photo,
        'etat' => $this->etat ?? 'actif'
    ];
}

    
}
