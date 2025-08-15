<?php
// Script to check the current database structure
// Run this to see what needs to be migrated

require_once 'vendor/autoload.php';

try {
    // Load CodeIgniter configuration
    $config = new \Config\Database();
    $db = \Config\Database::connect();
    
    echo "=== Database Connection Test ===\n";
    echo "Connected to database successfully.\n\n";
    
    echo "=== Current Output Table Structure ===\n";
    $query = $db->query("DESCRIBE output");
    $columns = $query->getResultArray();
    
    foreach ($columns as $column) {
        echo sprintf("%-20s %-15s %-10s %-10s\n", 
            $column['Field'], 
            $column['Type'], 
            $column['Null'], 
            $column['Key']
        );
    }
    
    echo "\n=== Checking for Primary Key ===\n";
    $hasPrimaryKey = false;
    foreach ($columns as $column) {
        if ($column['Key'] === 'PRI') {
            echo "Primary key found: " . $column['Field'] . "\n";
            $hasPrimaryKey = true;
        }
    }
    
    if (!$hasPrimaryKey) {
        echo "❌ NO PRIMARY KEY FOUND - Migration needed!\n";
        echo "Run: php run_migration.php\n";
    } else {
        echo "✅ Primary key exists - Ready to use!\n";
    }
    
    echo "\n=== Sample Data Count ===\n";
    $countQuery = $db->query("SELECT COUNT(*) as count FROM output");
    $count = $countQuery->getRowArray();
    echo "Records in output table: " . $count['count'] . "\n";
    
    if ($count['count'] > 0) {
        echo "\n=== Sample Records ===\n";
        $sampleQuery = $db->query("SELECT * FROM output LIMIT 3");
        $samples = $sampleQuery->getResultArray();
        
        foreach ($samples as $sample) {
            echo "ID: " . ($sample['output_id'] ?? 'N/A') . " | ";
            echo "Plan: " . ($sample['plan_id'] ?? 'N/A') . " | ";
            echo "Accomplishment: " . substr($sample['accomplishment'] ?? 'N/A', 0, 50) . "...\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Please check your database connection.\n";
}
?>
