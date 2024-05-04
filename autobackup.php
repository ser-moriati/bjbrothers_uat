<?php 

ini_set('memory_limit', '1024M'); // Increase memory limit to 1024 megabytes

$host = "localhost";
$username = "bjbro_uat";
$password = "Jmyk20~58";
$database = "bjbrothers_uat";
$table = "products";
$backup_folder = "Database Backup/"; // Define the backup folder
$batch_size = 500; // Specify batch size for fetching data

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    return;
}

// Set UTF-8 encoding for the connection
$mysqli->set_charset("utf8mb4");

// Fetch total number of rows in the table
$result = $mysqli->query("SELECT COUNT(*) as total FROM $table");
$row = $result->fetch_assoc();
$total_rows = $row['total'];

// Loop through batches to fetch and write data to separate backup files
for ($offset = 0; $offset < $total_rows; $offset += $batch_size) {
    // Open backup file with UTF-8 encoding
    $backup_file = $backup_folder . "backup_" . date("Y-m-d_H-i-s") . "_offset_$offset.sql";
    $fp = fopen($backup_file, 'w');
    if (!$fp) {
        echo "Failed to open backup file";
        $mysqli->close();
        return;
    }

    // Write SQL file header with UTF-8 encoding
    fwrite($fp, "-- Database Backup\n");
    fwrite($fp, "-- Date: " . date("Y-m-d H:i:s") . "\n");
    fwrite($fp, "-- Table: $table\n");
    fwrite($fp, "SET NAMES utf8mb4;\n\n");

    // Fetch data for current batch
    $query = "SELECT * FROM $table LIMIT $offset, $batch_size";
    $result = $mysqli->query($query);

    if (!$result) {
        echo "Failed to fetch data from table: " . $mysqli->error;
        fclose($fp);
        $mysqli->close();
        return;
    }

    // Fetch and write data to backup file
    while ($row = $result->fetch_assoc()) {
        $values = array_map(array($mysqli, 'real_escape_string'), $row);
        $sqlValues = "'" . implode("','", $values) . "'";
        fwrite($fp, "INSERT INTO $table VALUES ($sqlValues);\n");
    }

    fclose($fp);

    // Free result memory
    $result->free();
}

$mysqli->close();

?>
