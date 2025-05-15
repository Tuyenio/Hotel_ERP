CREATE TABLE `attendance` (
  `id` varchar(30) NOT NULL,
  `staff_id` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `check_in` time NOT NULL,
  `check_out` time NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staffs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 