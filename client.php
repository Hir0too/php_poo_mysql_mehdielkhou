<?php
class Client {
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $idCity;

    public function __construct($firstname, $lastname, $email, $password, $idCity = null) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->idCity = $idCity;
    }

    // Méthode pour insérer un client dans la base de données
    public function insertClient($tableName, $conn) {
        $sql = "INSERT INTO $tableName (firstname, lastname, email, password, idCity) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $this->firstname, $this->lastname, $this->email, $this->password, $this->idCity);
        return $stmt->execute();
    }

    // Méthode pour sélectionner tous les clients
    public static function selectAllClients($tableName, $conn) {
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        $clients = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $clients[] = $row;
            }
        }
        return $clients;
    }

    // Méthode pour sélectionner un client par son ID
    public static function selectClientById($tableName, $conn, $id) {
        $sql = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Méthode pour mettre à jour un client
    public static function updateClient($client, $tableName, $conn, $id) {
        $sql = "UPDATE $tableName SET firstname = ?, lastname = ?, email = ?, password = ?, idCity = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $client->firstname, $client->lastname, $client->email, $client->password, $client->idCity, $id);
        return $stmt->execute();
    }

    // Méthode pour supprimer un client
    public static function deleteClient($tableName, $conn, $id) {
        $sql = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
