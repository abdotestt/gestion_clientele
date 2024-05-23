<?php
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
            // Specify the upload directory
            $uploadFileDir = 'C:\xampp\htdocs\gestion_clientele_php\views';
            $dest_path = $uploadFileDir . $fileName;

            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                echo "File is successfully uploaded.\n";
                // Now you can read and process the CSV file
                processCSV($dest_path);
            } else {
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
