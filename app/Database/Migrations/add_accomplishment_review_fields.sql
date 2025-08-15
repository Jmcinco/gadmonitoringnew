-- Migration script to add accomplishment review tracking fields
-- Run this script to add fields for tracking accomplishment review workflow

-- Add review tracking fields to output table if they don't exist
ALTER TABLE `output` 
ADD COLUMN IF NOT EXISTS `reviewed_at` datetime DEFAULT NULL COMMENT 'When the accomplishment was reviewed',
ADD COLUMN IF NOT EXISTS `submitted_at` datetime DEFAULT NULL COMMENT 'When the accomplishment was submitted for review';

-- Update existing records to set submitted_at for completed status
UPDATE `output` 
SET `submitted_at` = `timestamp` 
WHERE `status` = 'completed' AND `submitted_at` IS NULL;

-- Add index for better performance on status queries
CREATE INDEX IF NOT EXISTS `idx_output_status` ON `output` (`status`);
CREATE INDEX IF NOT EXISTS `idx_output_accepted_by` ON `output` (`accepted_by`);

-- Update OutputModel allowedFields to include new fields
-- Note: This needs to be done manually in the OutputModel.php file
