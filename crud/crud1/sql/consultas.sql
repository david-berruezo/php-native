create database crud1;
use crud1;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbpdo`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `contact_no` bigint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = INNODB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci ;



--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `first_name`, `last_name`, `email_id`, `contact_no`) VALUES
(1, 'pradeep', 'khodke', 'pradeep@gmail.com', 9876543210),
(2, 'sohan', 'mahamune', 'sohan@gmail.com', 9874563210),
(3, 'john', 'doe', 'john@someone.com', 9778456123),
(4, 'test', 'test', 'test@test.com', 8745691230),
(5, 'david', 'berruezo', 'davidberruezo@davidberruezo.com', 8745691231);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
