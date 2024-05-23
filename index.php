<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients Manager</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
        require './controllers/database.php';
        require './controllers/client.php';
        $client = new Client();
        $clients = $client->get_all();
    ?>
    <h1>Welcome to your Account</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="csvFile">Choose CSV file:</label>
        <input type="file" name="csvFile" id="csvFile" accept=".csv">
        <button type="submit">Upload</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($clients as $client): ?>
            <tr>
                <td><?php echo htmlspecialchars($client['name']); ?></td>
                <td><?php echo htmlspecialchars($client['email']); ?></td>
                <td><?php echo htmlspecialchars($client['phone']); ?></td>
                <td><?php echo htmlspecialchars($client['statut']); ?></td>

                <td>
                    <!-- Placeholder for actions like Edit, Delete -->
                    <a href="edit.php?id=<?php echo $client['id']; ?>">Edit</a> |
                    <a href="delete.php?id=<?php echo $client['id']; ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
