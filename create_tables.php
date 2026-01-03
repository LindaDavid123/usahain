<?php
// Load database config
require_once('application/config/database.php');

// Connect to database
$conn = new mysqli(
    $db['default']['hostname'],
    $db['default']['username'],
    $db['default']['password'],
    $db['default']['database']
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to database: " . $db['default']['database'] . "\n\n";

// Read schema file
$schema = file_get_contents('database/schema.sql');

// Execute schema
if ($conn->multi_query($schema)) {
    echo "Schema executed successfully!\n";
    do {
        // Store results if any
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());
    echo "All tables created successfully!\n";
} else {
    echo "Error executing schema: " . $conn->error . "\n";
}

// Check if pencatatan_keuangan table exists
$result = $conn->query("SHOW TABLES LIKE 'pencatatan_keuangan'");
if ($result->num_rows > 0) {
    echo "\n✓ Table 'pencatatan_keuangan' exists!\n";
    
    // Show table structure
    $structure = $conn->query("DESCRIBE pencatatan_keuangan");
    echo "\nTable structure:\n";
    while ($row = $structure->fetch_assoc()) {
        echo "  - " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} else {
    echo "\n✗ Table 'pencatatan_keuangan' does NOT exist!\n";
}

$conn->close();
echo "\nDone!\n";
