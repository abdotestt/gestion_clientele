<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
    session_start();
    require './controllers/database.php';
    require './controllers/client.php';
    $client = new Client();
    $clients = $client->get_all();

    // Fonction pour supprimer un client
    function processFunction1Data($formData, $clientId) {
        $clientModel = new Client();
        $clientModel->delete_client($clientId);
    }

    // Suppression d'un client
    if (isset($_POST['function2_submit'])) {
        $clientId = $_POST['client_id'];
        processFunction1Data($_POST, $clientId);
    }

    // Fonction pour mettre à jour un client
    function updateclient($clientId, $data) {
        $clientModel = new Client();
        $clientModel->update_client($clientId, $data);
    }

    // Mise à jour d'un client
    if (isset($_POST['update_client'])) {
        $clientId = $_SESSION['client_id'];
        updateclient($clientId, $_POST);
    }
    ?>
    <div class="container mt-4">
        <h1>Welcome to your Account</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="mb-3">
            <div class="mb-3">
                <label for="csvFile" class="form-label">Choose CSV file:</label>
                <input type="file" name="csvFile" id="csvFile" accept=".csv" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        <a href="export.php" class="btn btn-secondary mb-3">Exporter les clients</a>
        <table class="table table-striped table-bordered">
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
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="d-inline">
                            <input type="hidden" name="client_id" value="<?php echo $_SESSION['client_id'] = $client['id']; ?>">
                            <button type="button" name="show_edit" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#EditModal">Edit</button>
                        </form>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="d-inline">
                            <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger" name="function2_submit">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modalForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" id="phone">
                        </div>
                        <div class="mb-3">
                            <label for="statut" class="form-label">Status</label>
                            <input type="number" name="statut" class="form-control" id="statut">
                        </div>
                        <button type="submit" name="update_client" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
