-- Migration script to update the output table structure
-- Run this script to add primary key and correct columns

-- First, let's see the current structure
-- DESCRIBE output;

-- Drop the existing table if it exists and recreate with proper structure
DROP TABLE IF EXISTS `output`;

CREATE TABLE `output` (
  `output_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `accomplishment` varchar(255) DEFAULT NULL,
  `accepted_by` int(11) DEFAULT NULL,
  `date_accomplished` date DEFAULT NULL,
  `file` text DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`output_id`),
  KEY `plan_id` (`plan_id`),
  CONSTRAINT `output_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert some sample data
INSERT INTO `output` (`output_id`, `plan_id`, `accomplishment`, `accepted_by`, `date_accomplished`, `file`, `remarks`, `status`, `timestamp`) VALUES
(1, 1, 'Completed Gender Sensitivity Training for 120 employees (exceeded target of 100)', NULL, '2024-03-15', NULL, 'Training was well-received by participants', 'completed', '2024-03-16 08:00:00'),
(2, 2, 'Conducted Women\'s Leadership Workshop with 45 participants', NULL, '2024-04-10', NULL, 'Positive feedback from attendees', 'pending', '2024-04-11 09:30:00'),
(3, 3, 'Launched Anti-Sexual Harassment Campaign agency-wide', NULL, '2024-05-20', NULL, 'Campaign reached all divisions successfully', 'completed', '2024-05-21 10:15:00'),
(4, 43, 'Drafted Work-Life Balance Policy Framework', NULL, '2024-06-15', NULL, 'Policy framework under review by legal team', 'pending', '2024-06-16 14:20:00');

-- Set AUTO_INCREMENT to start from 5
ALTER TABLE `output` AUTO_INCREMENT = 5;
