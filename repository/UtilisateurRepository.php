<?php
require_once __DIR__ . '/../models/Utilisateur.php';

class UtilisateurRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function recupererParLogin(string $login): ?Utilisateur {
        $sql = "SELECT * FROM utilisateur WHERE login = :login AND etat = 'actif' LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();
        return $data ? new Utilisateur($data) : null;
    }

    public function ajouter(Utilisateur $u): void {
        $sql = "INSERT INTO utilisateur 
                (nom, prenom, telephone_portable, adresse, salaire, login, mot_de_passe, role, photo, etat) 
                VALUES (:nom, :prenom, :tel, :adresse, :salaire, :login, :mdp, :role, :photo, 'actif')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $u->getNom(),
            'prenom' => $u->getPrenom(),
            'tel' => $u->getTelephonePortable(),
            'adresse' => $u->getAdresse(),
            'salaire' => $u->getSalaire(),
            'login' => $u->getLogin(),
            'mdp' => $u->getMotDePasse(),
            'role' => $u->getRole(),
            'photo' => $u->getPhoto()
        ]);
    }

    public function modifier(Utilisateur $u): void {
        $sql = "UPDATE utilisateur SET 
                nom = :nom, prenom = :prenom, telephone_portable = :tel,
                adresse = :adresse, salaire = :salaire, login = :login,
                mot_de_passe = :mdp, role = :role, photo = :photo
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $u->getId(),
            'nom' => $u->getNom(),
            'prenom' => $u->getPrenom(),
            'tel' => $u->getTelephonePortable(),
            'adresse' => $u->getAdresse(),
            'salaire' => $u->getSalaire(),
            'login' => $u->getLogin(),
            'mdp' => $u->getMotDePasse(),
            'role' => $u->getRole(),
            'photo' => $u->getPhoto()
        ]);
    }

    public function archiver(Utilisateur $u): void {
        $sql = "UPDATE utilisateur SET etat = 'archive' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $u->getId()]);
    }

    public function lister(): array {
        $sql = "SELECT * FROM utilisateur WHERE etat = 'actif' ORDER BY nom";
        $stmt = $this->pdo->query($sql);
        $result = [];
        while ($row = $stmt->fetch()) {
            $result[] = new Utilisateur($row);
        }
        return $result;
    }

    public function listerTous(): array {
        $sql = "SELECT * FROM utilisateur ORDER BY nom, prenom";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }


    public function recupererParId(int $id): ?Utilisateur {
        $sql = "SELECT * FROM utilisateur WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        return $data ? new Utilisateur($data) : null;
    }

    public function supprimerParId(int $id): void{
        $sql = "DELETE FROM utilisateur WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function rechercher(string $motcle): array {
    $sql = "SELECT * FROM utilisateur 
            WHERE etat = 'actif'
            AND (nom LIKE :motcle OR prenom LIKE :motcle OR login LIKE :motcle)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['motcle' => "%$motcle%"]);
    $rows = $stmt->fetchAll();

    return array_map(fn($row) => new Utilisateur($row), $rows);
}


}
