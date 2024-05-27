<?php
require_once './controllers/user.php';

$pdo = Database::getConnection(); // Get the PDO connection
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
        $fileTmpPath = $_FILES['csvFile']['tmp_name'];
        $fileName = $_FILES['csvFile']['name'];
        $fileSize = $_FILES['csvFile']['size'];
        $fileType = $_FILES['csvFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Check if the uploaded file is a CSV
        if ($fileExtension === 'csv') {
            $uploadFileDir = 'C:\xampp\htdocs\gestion_clientele_php\views\/';
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                echo "File is successfully uploaded.\n";
                if (($handle = fopen($dest_path, "r")) !== FALSE) {
                    $header = fgetcsv($handle, 1000, ",");
                    $rowCount = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $name = $data[0];
                        $email = $data[1];
                        $phone = $data[2];
                        $statut = $data[3];

                        // Insert the data into the database
                        $sql = "INSERT INTO clients (name, email, phone, statut) VALUES (?, ?, ?, ?)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([$name, $email, $phone, $statut]);
                        $rowCount++;
                    }
                    fclose($handle);
                    Header('Location: index.php');
                    Exit();
                                } else {
                    echo "Error opening the file.<br>";
                }            } else {
                echo "There was an error moving the uploaded file.\n";
            }
        } else {
            echo "Uploaded file is not a CSV file.\n";
        }
    } else {
        echo "No file uploaded or there was an error uploading the file.\n";
    }
}

function processCSV($filePath) {
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        echo "<h2>CSV File Contents:</h2>";
        echo "<table border='1'>";
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            echo "<tr>";
            foreach ($data as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        fclose($handle);
    } else {
        echo "Error opening the file.";
    }
}
?>
