<?php

// Update audit trail table to support GAD Plan actions
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pgms_db';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database successfully!\n";
    
    // Update action enum to include GAD Plan actions
    $updateQuery = "ALTER TABLE audit_trail MODIFY COLUMN action enum('CREATE','UPDATE','DELETE','LOGIN','LOGOUT','REVIEW','APPROVE','REJECT','FINALIZE','ARCHIVE') NOT NULL";
    
    $pdo->exec($updateQuery);
    echo "✅ Updated audit_trail action enum to include GAD Plan actions!\n";
    
    // Update details column to allow longer text
    $updateDetailsQuery = "ALTER TABLE audit_trail MODIFY COLUMN details text NOT NULL";
    
    $pdo->exec($updateDetailsQuery);
    echo "✅ Updated audit_trail details column to support longer text!\n";
    
    // Show current table structure
    $stmt = $pdo->query("DESCRIBE audit_trail");
    echo "\n📋 Updated table structure:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Field'] == 'action') {
            echo "  - {$row['Field']} ({$row['Type']}) ✅ GAD Plan actions supported\n";
        } elseif ($row['Field'] == 'details') {
            echo "  - {$row['Field']} ({$row['Type']}) ✅ Extended length\n";
        } else {
            echo "  - {$row['Field']} ({$row['Type']})\n";
        }
    }
    
    // Test insert with new action types
    $testActions = ['REVIEW', 'APPROVE', 'REJECT', 'FINALIZE', 'ARCHIVE'];
    
    foreach ($testActions as $action) {
        $stmt = $pdo->prepare("
            INSERT INTO audit_trail (user_id, action, table_name, details, employee_name, employee_email, ip_address, created_at, updated_at) 
            VALUES (1, ?, 'plan', ?, 'Test GAD Plan', 'test@example.com', '127.0.0.1', NOW(), NOW())
        ");
        
        try {
            $stmt->execute([$action, "Test GAD Plan $action action"]);
            $testId = $pdo->lastInsertId();
            echo "✅ Test $action action inserted successfully (ID: $testId)!\n";
            
            // Clean up test record
            $deleteStmt = $pdo->prepare("DELETE FROM audit_trail WHERE id = ?");
            $deleteStmt->execute([$testId]);
        } catch (PDOException $e) {
            echo "❌ Failed to test $action action: " . $e->getMessage() . "\n";
        }
    }
    
    echo "✅ All test records cleaned up.\n";
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n🎉 Audit trail table updated for GAD Plan activities!\n";
echo "Supported actions: CREATE, UPDATE, DELETE, LOGIN, LOGOUT, REVIEW, APPROVE, REJECT, FINALIZE, ARCHIVE\n";
echo "You can now track comprehensive GAD Plan workflows in the audit trail.\n";
?>
