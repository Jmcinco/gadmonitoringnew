<?php
// Simple script to run the database migration
// Run this from the command line: php run_migration.php

require_once 'app/Config/Database.php';

try {
    // Get database connection
    $config = new \Config\Database();
    $db = \Config\Database::connect();
    
    echo "Connected to database successfully.\n";
    
    // Read the migration SQL file
    $migrationSQL = file_get_contents('app/Database/Migrations/update_output_table.sql');
    
    if (!$migrationSQL) {
        throw new Exception("Could not read migration file");
    }
    
    echo "Migration file loaded.\n";
    
    // Split the SQL into individual statements
    $statements = array_filter(array_map('trim', explode(';', $migrationSQL)));
    
    echo "Executing migration...\n";
    
    foreach ($statements as $statement) {
        if (!empty($statement) && !str_starts_with(trim($statement), '--')) {
            echo "Executing: " . substr($statement, 0, 50) . "...\n";
            $db->query($statement);
        }
    }
    
    echo "Migration completed successfully!\n";
    echo "The output table now has a primary key (output_id) and proper structure.\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Please check your database connection and try again.\n";
}
?>
