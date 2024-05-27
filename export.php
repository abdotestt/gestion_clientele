<?php
require_once './controllers/database.php';
$conn = Database::getConnection(); // Get the PDO connection

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=clients.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Nom', 'Email', 'Téléphone', 'statut'));

$sql = "SELECT id, name, email, phone, statut FROM clients"; // Adjust the columns as per your table schema
$stmt = $conn->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>
