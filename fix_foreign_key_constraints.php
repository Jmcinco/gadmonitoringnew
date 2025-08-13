<?php

// Fix foreign key constraints in plan table
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pgms_db';

try {
    // Connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to database successfully!\n";
    
    // Check current foreign key constraints
    echo "\n📋 Current foreign key constraints in plan table:\n";
    $stmt = $pdo->query("
        SELECT 
            CONSTRAINT_NAME,
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA = '$database' 
        AND TABLE_NAME = 'plan' 
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    
    $existingConstraints = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingConstraints[] = $row['CONSTRAINT_NAME'];
        echo "  - {$row['CONSTRAINT_NAME']}: {$row['COLUMN_NAME']} -> {$row['REFERENCED_TABLE_NAME']}.{$row['REFERENCED_COLUMN_NAME']}\n";
    }
    
    // Drop incorrect foreign key constraint if it exists
    echo "\n🔧 Fixing foreign key constraints...\n";
    
    if (in_array('fk_authors_division', $existingConstraints)) {
        try {
            $pdo->exec("ALTER TABLE plan DROP FOREIGN KEY fk_authors_division");
            echo "✅ Dropped incorrect constraint: fk_authors_division\n";
        } catch (PDOException $e) {
            echo "⚠️  Could not drop fk_authors_division: " . $e->getMessage() . "\n";
        }
    }
    
    // Add correct foreign key constraints
    $correctConstraints = [
        'fk_plan_authors_division' => 'ADD CONSTRAINT fk_plan_authors_division FOREIGN KEY (authors_division) REFERENCES divisions(div_id) ON DELETE SET NULL ON UPDATE CASCADE',
        'fk_plan_reviewed_by' => 'ADD CONSTRAINT fk_plan_reviewed_by FOREIGN KEY (reviewed_by) REFERENCES employees(emp_id) ON DELETE SET NULL ON UPDATE CASCADE',
        'fk_plan_returned_by' => 'ADD CONSTRAINT fk_plan_returned_by FOREIGN KEY (returned_by) REFERENCES employees(emp_id) ON DELETE SET NULL ON UPDATE CASCADE',
        'fk_plan_approved_by' => 'ADD CONSTRAINT fk_plan_approved_by FOREIGN KEY (approved_by) REFERENCES employees(emp_id) ON DELETE SET NULL ON UPDATE CASCADE'
    ];
    
    foreach ($correctConstraints as $constraintName => $constraintSQL) {
        if (!in_array($constraintName, $existingConstraints)) {
            try {
                $pdo->exec("ALTER TABLE plan $constraintSQL");
                echo "✅ Added constraint: $constraintName\n";
            } catch (PDOException $e) {
                echo "⚠️  Could not add $constraintName: " . $e->getMessage() . "\n";
            }
        } else {
            echo "⚠️  Constraint already exists: $constraintName\n";
        }
    }
    
    // Check if audit_trail table exists and add foreign key if needed
    $stmt = $pdo->query("SHOW TABLES LIKE 'audit_trail'");
    if ($stmt->rowCount() > 0) {
        echo "\n🔧 Checking audit_trail foreign key constraints...\n";
        
        $stmt = $pdo->query("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = '$database' 
            AND TABLE_NAME = 'audit_trail' 
            AND REFERENCED_TABLE_NAME = 'employees'
        ");
        
        $auditConstraints = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $auditConstraints[] = $row['CONSTRAINT_NAME'];
        }
        
        if (!in_array('fk_audit_trail_user_id', $auditConstraints)) {
            try {
                $pdo->exec("ALTER TABLE audit_trail ADD CONSTRAINT fk_audit_trail_user_id FOREIGN KEY (user_id) REFERENCES employees(emp_id) ON DELETE SET NULL ON UPDATE CASCADE");
                echo "✅ Added audit_trail foreign key constraint\n";
            } catch (PDOException $e) {
                echo "⚠️  Could not add audit_trail foreign key: " . $e->getMessage() . "\n";
            }
        }
    }
    
    // Show updated constraints
    echo "\n📋 Updated foreign key constraints:\n";
    $stmt = $pdo->query("
        SELECT 
            CONSTRAINT_NAME,
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA = '$database' 
        AND TABLE_NAME = 'plan' 
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "  - {$row['CONSTRAINT_NAME']}: {$row['COLUMN_NAME']} -> {$row['REFERENCED_TABLE_NAME']}.{$row['REFERENCED_COLUMN_NAME']}\n";
    }
    
    echo "\n🎉 Foreign key constraints have been fixed!\n";
    echo "Now employees can be deleted safely - related records will be set to NULL.\n";
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

?>
