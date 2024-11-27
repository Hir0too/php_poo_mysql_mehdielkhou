<?php
include("connection.php");
include("Client.php");
include("City.php");

$connection = new Connection();
$connection->selectDatabase("poog4");

$errorMsg = "";
$successMsg = "";

if (isset($_POST['submit'])) {
    $fnameValue = $_POST['firstName'];
    $lnameValue = $_POST['lastName'];
    $emailValue = $_POST['email'];
    $passValue = $_POST['password'];
    $idCityValue = $_POST['cities'];

    // Validation des champs
    if (empty($fnameValue) || empty($lnameValue) || empty($emailValue) || empty($passValue)) {
        $errorMsg = "All fields must be filled in.";
    } elseif (strlen($passValue) < 8) {
        $errorMsg = "Password must contain at least 8 characters.";
    } elseif (preg_match('/[A-Z]+/', $passValue) == 0) {
        $errorMsg = "Password must contain at least one uppercase letter.";
    } else {
        $client = new Client($fnameValue, $lnameValue, $emailValue, $passValue, $idCityValue);
        if ($client->insertClient("clients", $connection->conn)) {
            $successMsg = "Client successfully registered!";
        } else {
            $errorMsg = "Failed to register client.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Signup</h2>
        <?php if (!empty($errorMsg)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
                <label for="fname" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="fname" name="firstName" value="<?= htmlspecialchars($fnameValue) ?>">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lname" name="lastName" value="<?= htmlspecialchars($lnameValue) ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($emailValue) ?>">
            </div>
            <div class="mb-3">
                <label for="cities" class="form-label">City:</label>
                <select name="cities" class="form-select">
                    <option selected>Select your city</option>
                    <?php
                    $cities = City::selectAllCities('Cities', $connection->conn);
                    foreach ($cities as $city) {
                        echo "<option value=\"{$city['id']}\">{$city['cityName']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
</body>
</html>
