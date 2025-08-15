<?php
// Migration script to add missing fields to output table for accomplishment review workflow
// Run this script once to add the required fields

require_once 'app/Config/Database.php';

try {
    $db = \Config\Database::connect();
    
    echo "Running database migration for output table...\n\n";
    
    // Check current table structure
    $query = $db->query("DESCRIBE output");
    $columns = $query->getResultArray();
    $existingFields = array_column($columns, 'Field');
    
    echo "Current fields: " . implode(', ', $existingFields) . "\n\n";
    
    // Add reviewed_at field if it doesn't exist
    if (!in_array('reviewed_at', $existingFields)) {
        echo "Adding reviewed_at field...\n";
        $db->query("ALTER TABLE `output` ADD COLUMN `reviewed_at` datetime DEFAULT NULL COMMENT 'When the accomplishment was reviewed'");
        echo "✓ reviewed_at field added\n";
    } else {
        echo "✓ reviewed_at field already exists\n";
    }
    
    // Add submitted_at field if it doesn't exist
    if (!in_array('submitted_at', $existingFields)) {
        echo "Adding submitted_at field...\n";
        $db->query("ALTER TABLE `output` ADD COLUMN `submitted_at` datetime DEFAULT NULL COMMENT 'When the accomplishment was submitted for review'");
        echo "✓ submitted_at field added\n";
    } else {
        echo "✓ submitted_at field already exists\n";
    }
    
    // Update existing records to set submitted_at for completed status
    echo "\nUpdating existing records...\n";
    $result = $db->query("UPDATE `output` SET `submitted_at` = `timestamp` WHERE `status` = 'completed' AND `submitted_at` IS NULL");
    $affectedRows = $db->affectedRows();
    echo "✓ Updated $affectedRows records with submitted_at timestamp\n";
    
    // Add indexes for better performance
    echo "\nAdding indexes...\n";
    try {
        $db->query("CREATE INDEX IF NOT EXISTS `idx_output_status` ON `output` (`status`)");
        echo "✓ Status index added\n";
    } catch (Exception $e) {
        echo "Note: Status index may already exist\n";
    }
    
    try {
        $db->query("CREATE INDEX IF NOT EXISTS `idx_output_accepted_by` ON `output` (`accepted_by`)");
        echo "✓ Accepted_by index added\n";
    } catch (Exception $e) {
        echo "Note: Accepted_by index may already exist\n";
    }
    
    echo "\n✅ Migration completed successfully!\n";
    echo "\nNext steps:\n";
    echo "1. Uncomment the new fields in app/Models/OutputModel.php\n";
    echo "2. Uncomment the timestamp code in app/Controllers/FocalController.php\n";
    echo "3. Uncomment the timestamp code in app/Controllers/MemberController.php\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Please check your database connection and try again.\n";
}
?>
