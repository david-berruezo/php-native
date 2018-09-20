create database crud5;
use crud5;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `school`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id_student` int(11) NOT NULL,
  `student_name` varchar(65) NOT NULL,
  `student_age` int(11) NOT NULL
) ENGINE = INNODB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;

--
-- Truncar tablas antes de insertar `students`
--

TRUNCATE TABLE `students`;
--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id_student`, `student_name`, `student_age`) VALUES
(18, 'Mario Dominguez', 22);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id_student`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id_student` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
