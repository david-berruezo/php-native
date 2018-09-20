create database crud4;
use crud4;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `email`, `user_name`, `password`, `date_added`) VALUES
(1, 'Fiaz', 'ahmad', 'admin2@test.com', 'mfiazahmad', '', '2015-08-17 07:52:01'),
(2, 'Ahmad', 'Fiaz', 'admin@test.com', 'mfiaz', '202cb962ac59075b964b07152d234b70', '2015-08-17 07:52:59'),
(3, 'Bashir', 'Khalid', 'khalid@test.com', 'hellokhalid', '202cb962ac59075b964b07152d234b70', '2015-08-17 08:14:24'),
(4, 'Bashir', 'Khalid', 'khalid@test.com', 'hellokhalid', '202cb962ac59075b964b07152d234b70', '2015-08-17 08:14:40'),
(5, 'Ahmad', 'Fiaz', 'test@gmail.com', 'mfiaz', '202cb962ac59075b964b07152d234b70', '2015-08-17 08:21:02');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
