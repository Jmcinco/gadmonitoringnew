<?php

// Update existing audit trail table to match our model
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pgms_db';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database successfully!\n";
    
    // Check current table structure
    $stmt = $pdo->query("DESCRIBE audit_trail");
    echo "\n📋 Current table structure:\n";
    $existingColumns = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingColumns[] = $row['Field'];
        echo "  - {$row['Field']} ({$row['Type']})\n";
    }
    
    // Add missing columns
    $alterQueries = [];
    
    if (!in_array('id', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail CHANGE audit_id id int(11) unsigned NOT NULL AUTO_INCREMENT";
    }
    
    if (!in_array('table_name', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail ADD COLUMN table_name varchar(100) NOT NULL DEFAULT 'employees' AFTER action";
    }
    
    if (!in_array('record_id', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail ADD COLUMN record_id int(11) unsigned DEFAULT NULL AFTER table_name";
    }
    
    if (!in_array('user_agent', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail ADD COLUMN user_agent text DEFAULT NULL AFTER ip_address";
    }
    
    if (!in_array('old_data', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail ADD COLUMN old_data json DEFAULT NULL AFTER user_agent";
    }
    
    if (!in_array('new_data', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail ADD COLUMN new_data json DEFAULT NULL AFTER old_data";
    }
    
    if (!in_array('created_at', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail ADD COLUMN created_at datetime DEFAULT NULL AFTER new_data";
    }
    
    if (!in_array('updated_at', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail ADD COLUMN updated_at datetime DEFAULT NULL AFTER created_at";
    }
    
    // Update action enum to include LOGIN and LOGOUT
    $alterQueries[] = "ALTER TABLE audit_trail MODIFY COLUMN action enum('CREATE','UPDATE','DELETE','LOGIN','LOGOUT') NOT NULL";
    
    // Update timestamp column to created_at if it exists
    if (in_array('timestamp', $existingColumns) && !in_array('created_at', $existingColumns)) {
        $alterQueries[] = "ALTER TABLE audit_trail CHANGE timestamp created_at datetime DEFAULT NULL";
    }
    
    // Execute alter queries
    foreach ($alterQueries as $query) {
        try {
            $pdo->exec($query);
            echo "✅ Executed: " . substr($query, 0, 50) . "...\n";
        } catch (PDOException $e) {
            echo "⚠️  Warning: " . $e->getMessage() . "\n";
        }
    }
    
    // Add indexes
    $indexQueries = [
        "CREATE INDEX IF NOT EXISTS idx_user_id ON audit_trail (user_id)",
        "CREATE INDEX IF NOT EXISTS idx_action ON audit_trail (action)",
        "CREATE INDEX IF NOT EXISTS idx_table_name ON audit_trail (table_name)",
        "CREATE INDEX IF NOT EXISTS idx_created_at ON audit_trail (created_at)"
    ];
    
    foreach ($indexQueries as $query) {
        try {
            $pdo->exec($query);
            echo "✅ Index created successfully\n";
        } catch (PDOException $e) {
            echo "⚠️  Index warning: " . $e->getMessage() . "\n";
        }
    }
    
    // Show final table structure
    $stmt = $pdo->query("DESCRIBE audit_trail");
    echo "\n📋 Updated table structure:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "  - {$row['Field']} ({$row['Type']})\n";
    }
    
    // Test insert
    $stmt = $pdo->prepare("
        INSERT INTO audit_trail (user_id, action, table_name, record_id, employee_name, employee_email, details, ip_address, created_at, updated_at) 
        VALUES (1, 'CREATE', 'employees', 1, 'Test Employee', 'test@example.com', 'Test audit trail functionality', '127.0.0.1', NOW(), NOW())
    ");
    
    if ($stmt->execute()) {
        $testId = $pdo->lastInsertId();
        echo "✅ Test audit record inserted successfully (ID: $testId)!\n";
        
        // Clean up test record
        $stmt = $pdo->prepare("DELETE FROM audit_trail WHERE id = ?");
        $stmt->execute([$testId]);
        echo "✅ Test record cleaned up.\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n🎉 Audit trail table updated successfully!\n";
echo "You can now access the audit trail at: http://localhost:8080/AuditTrail\n";
?>
