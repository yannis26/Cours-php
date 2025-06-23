<?php
class User {
    private $id;
    private $name;
    private $email;
    private $firstname;

    public function __construct($id = null, $name, $firstname, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->firstname = $firstname;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getEmail() {
        return $this->email;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }
}
?>