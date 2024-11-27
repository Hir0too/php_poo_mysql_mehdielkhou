<?php
include("connection.php");
include("Client.php");
include("City.php");

$connection = new Connection();
$connection->selectDatabase("poog4");

$clients = Client::selectAllClients("clients", $connection->conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Client List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= $client['id'] ?></td>
                        <td><?= htmlspecialchars($client['firstname']) ?></td>
                        <td><?= htmlspecialchars($client['lastname']) ?></td>
                        <td><?= htmlspecialchars($client['email']) ?></td>
                        <td>
                            <?php
                            $city = City::selectCityById("Cities", $connection->conn, $client['idCity']);
                            echo $city ? htmlspecialchars($city['cityName']) : "Unknown";
                            ?>
                        </td>
                        <td>
                            <a href="update.php?id=<?= $client['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $client['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this client?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
