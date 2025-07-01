<?php
require_once 'User.php';
require_once 'database.php';

class UserManager {
    private $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function create(User $user) {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, firstname,username, email, password) 
            VALUES (:name, :firstname, :username, :email, :password)"
            );
        $stmt->bindValue(':name', $user->getName());
        $stmt->bindValue(':firstname', $user->getFirstname());
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->execute();

        return $this->db->lastInsertId();
    }

    public function read($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                $data['id'], 
                $data['name'], 
                $data['firstname'],
                $data['username'], 
                $data['email'],
                null, // Ne pas exposer le mot de passe
                $data['created_at']
            );
        }

        return null;
    }

    public function readAll() {
        $stmt = $this->db->query("SELECT * FROM users");
        $users = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $data['id'], 
                $data['name'], 
                $data['firstname'],
                $data['username'], 
                $data['email'],
                null, // Ne pas exposer le mot de passe
                $data['created_at']
            );
        }

        return $users;
    }

public function update(User $user) {
    // On prépare la requête de base, sans password
    $sql = "UPDATE users SET 
                name = :name, 
                firstname = :firstname,
                username = :username, 
                email = :email";

    // Si le mot de passe est fourni (non null et non vide), on l'ajoute
    if ($user->getPassword()) {
        $sql .= ", password = :password";
    }

    $sql .= " WHERE id = :id";

    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(':name', $user->getName());
    $stmt->bindValue(':firstname', $user->getFirstname());
    $stmt->bindValue(':username', $user->getUsername());
    $stmt->bindValue(':email', $user->getEmail());
    $stmt->bindValue(':id', $user->getId());

    if ($user->getPassword()) {
        $stmt->bindValue(':password', $user->getPassword());
    }

    return $stmt->execute();
}


    public function delete($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM users WHERE id = :id"
        );
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}
?>