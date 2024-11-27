<?php
// Inclusions des fichiers nécessaires pour la connexion, les classes Client et City
include("connection.php");
include("Client.php");
include("City.php");

// Création de la connexion à la base de données
$connection = new Connection();
$connection->selectDatabase("poog4");

// Variables pour les messages
$errorMsg = "";
$successMsg = "";

// Traitement du formulaire de connexion
if (isset($_POST['submit'])) {
    $emailValue = $_POST['email'];
    $passwordValue = $_POST['password'];

    if (empty($emailValue) || empty($passwordValue)) {
        $errorMsg = "Both fields are required.";
    } else {
        // Vérification des informations de connexion
        $sql = "SELECT * FROM clients WHERE email = ? AND password = ?";
        $stmt = $connection->conn->prepare($sql);
        $stmt->bind_param("ss", $emailValue, $passwordValue);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $successMsg = "Login successful!";
        } else {
            $errorMsg = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Login</h2>
        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= $errorMsg ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($successMsg)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?= $successMsg ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($emailValue ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
