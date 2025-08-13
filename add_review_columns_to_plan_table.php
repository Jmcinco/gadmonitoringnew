<?php

// Add review columns to plan table
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
    echo "\n📋 Current plan table structure:\n";
    $stmt = $pdo->query("DESCRIBE plan");
    $existingColumns = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingColumns[] = $row['Field'];
        echo "  - {$row['Field']} ({$row['Type']})\n";
    }
    
    // Define new columns to add
    $newColumns = [
        'reviewed_by' => 'INT NULL COMMENT "User ID who reviewed the plan"',
        'reviewed_at' => 'DATETIME NULL COMMENT "When the plan was reviewed"',
        'returned_by' => 'INT NULL COMMENT "User ID who returned the plan"',
        'returned_at' => 'DATETIME NULL COMMENT "When the plan was returned"',
        'approved_by' => 'INT NULL COMMENT "User ID who approved the plan"',
        'approved_at' => 'DATETIME NULL COMMENT "When the plan was approved"'
    ];
    
    echo "\n🔧 Adding new review columns...\n";
    
    foreach ($newColumns as $columnName => $columnDefinition) {
        if (!in_array($columnName, $existingColumns)) {
            $sql = "ALTER TABLE plan ADD COLUMN $columnName $columnDefinition";
            $pdo->exec($sql);
            echo "✅ Added column: $columnName\n";
        } else {
            echo "⚠️  Column already exists: $columnName\n";
        }
    }
    
    // Add foreign key constraints if they don't exist
    echo "\n🔗 Adding foreign key constraints...\n";
    
    // Check existing foreign keys
    $stmt = $pdo->query("
        SELECT CONSTRAINT_NAME 
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA = '$database' 
        AND TABLE_NAME = 'plan' 
        AND REFERENCED_TABLE_NAME IS NOT NULL
    ");
    $existingFKs = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $existingFKs[] = $row['CONSTRAINT_NAME'];
    }
    
    // Define foreign key constraints
    $foreignKeys = [
        'fk_plan_reviewed_by' => 'ADD CONSTRAINT fk_plan_reviewed_by FOREIGN KEY (reviewed_by) REFERENCES employees(emp_id) ON DELETE SET NULL',
        'fk_plan_returned_by' => 'ADD CONSTRAINT fk_plan_returned_by FOREIGN KEY (returned_by) REFERENCES employees(emp_id) ON DELETE SET NULL',
        'fk_plan_approved_by' => 'ADD CONSTRAINT fk_plan_approved_by FOREIGN KEY (approved_by) REFERENCES employees(emp_id) ON DELETE SET NULL'
    ];
    
    foreach ($foreignKeys as $fkName => $fkDefinition) {
        if (!in_array($fkName, $existingFKs)) {
            try {
                $sql = "ALTER TABLE plan $fkDefinition";
                $pdo->exec($sql);
                echo "✅ Added foreign key: $fkName\n";
            } catch (PDOException $e) {
                echo "⚠️  Could not add foreign key $fkName: " . $e->getMessage() . "\n";
                echo "   (This is normal if employees table doesn't exist or has different structure)\n";
            }
        } else {
            echo "⚠️  Foreign key already exists: $fkName\n";
        }
    }
    
    // Show updated table structure
    echo "\n📋 Updated plan table structure:\n";
    $stmt = $pdo->query("DESCRIBE plan");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $isNew = in_array($row['Field'], array_keys($newColumns));
        $marker = $isNew ? " ✨ NEW" : "";
        echo "  - {$row['Field']} ({$row['Type']})$marker\n";
    }
    
    // Create indexes for better performance
    echo "\n📊 Adding indexes for performance...\n";
    
    $indexes = [
        'idx_plan_reviewed_by' => 'CREATE INDEX idx_plan_reviewed_by ON plan(reviewed_by)',
        'idx_plan_returned_by' => 'CREATE INDEX idx_plan_returned_by ON plan(returned_by)',
        'idx_plan_approved_by' => 'CREATE INDEX idx_plan_approved_by ON plan(approved_by)',
        'idx_plan_reviewed_at' => 'CREATE INDEX idx_plan_reviewed_at ON plan(reviewed_at)',
        'idx_plan_returned_at' => 'CREATE INDEX idx_plan_returned_at ON plan(returned_at)',
        'idx_plan_approved_at' => 'CREATE INDEX idx_plan_approved_at ON plan(approved_at)'
    ];
    
    foreach ($indexes as $indexName => $indexSQL) {
        try {
            $pdo->exec($indexSQL);
            echo "✅ Added index: $indexName\n";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate key name') !== false) {
                echo "⚠️  Index already exists: $indexName\n";
            } else {
                echo "⚠️  Could not add index $indexName: " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "\n🎉 Successfully updated plan table with review columns!\n";
    echo "\nNew columns added:\n";
    echo "  - reviewed_by: Stores user ID who reviewed the plan\n";
    echo "  - reviewed_at: Stores when the plan was reviewed\n";
    echo "  - returned_by: Stores user ID who returned the plan\n";
    echo "  - returned_at: Stores when the plan was returned\n";
    echo "  - approved_by: Stores user ID who approved the plan\n";
    echo "  - approved_at: Stores when the plan was approved\n";
    echo "\nThese columns will help track the complete review workflow!\n";
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

?>
