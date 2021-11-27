--
-- Database: `store`
--

CREATE DATABASE store CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE store;

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hourly_wage` decimal(10,0) NOT NULL,
  `years_of_service` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

--
-- Create user and grant privileges
--
CREATE USER 'store'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'store';
GRANT SELECT, INSERT, UPDATE, DELETE, DROP ON `store`.* TO 'store'@'localhost'; ALTER USER 'store'@'localhost' ;
FLUSH PRIVILEGES;
