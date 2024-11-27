<?php
class City {
    public $id;
    public $cityName;

    // Méthode pour sélectionner toutes les villes
    public static function selectAllCities($tableName, $conn) {
        $sql = "SELECT id, cityName FROM $tableName";
        $result = $conn->query($sql);
        $cities = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cities[] = $row;
            }
        }
        return $cities;
    }

    // Méthode pour sélectionner une ville par son ID
    public static function selectCityById($tableName, $conn, $id) {
        $sql = "SELECT cityName FROM $tableName WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }
}
?>
