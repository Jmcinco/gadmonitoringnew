<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pgms_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to the database.\n";

// Test query
$sql = "SELECT COUNT(*) as count FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Number of employees in the database: " . $row['count'] . "\n";
} else {
    echo "No employees found in the database.\n";
}

$conn->close();
?>