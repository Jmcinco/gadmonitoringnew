<?php

// Simple database connection to create audit trail table
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pgms_db';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Connected to database successfully!\n";

    // Read SQL file
    $sql = file_get_contents('create_audit_trail_table.sql');

    // Execute the SQL
    $pdo->exec($sql);
    echo "✅ Audit trail table created successfully!\n";

    // Test the table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'audit_trail'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Table 'audit_trail' exists in database.\n";

        // Show table structure
        $stmt = $pdo->query("DESCRIBE audit_trail");
        echo "\n📋 Table structure:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "  - {$row['Field']} ({$row['Type']})\n";
        }
    } else {
        echo "❌ Table 'audit_trail' was not created.\n";
    }

    // Insert a test record
    $stmt = $pdo->prepare("
        INSERT INTO audit_trail (user_id, action, table_name, details, employee_name, employee_email, ip_address, created_at, updated_at)
        VALUES (1, 'CREATE', 'test', 'Test audit trail setup', 'System Test', 'test@system.com', '127.0.0.1', NOW(), NOW())
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

echo "\n🎉 Audit trail setup complete!\n";
echo "You can now access the audit trail at: http://localhost:8080/AuditTrail\n";
?>
