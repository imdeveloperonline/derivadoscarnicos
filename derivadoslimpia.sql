-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-06-2018 a las 04:38:23
-- Versión del servidor: 10.1.29-MariaDB
-- Versión de PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `derivadoslimpia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `advance_client`
--

CREATE TABLE `advance_client` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `amount` decimal(65,2) DEFAULT NULL,
  `unit_price` decimal(65,2) DEFAULT NULL,
  `quantity` decimal(65,2) DEFAULT NULL,
  `detail` text COLLATE utf8_spanish_ci,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payed` tinyint(1) DEFAULT NULL,
  `archived` tinyint(1) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `regional_id` int(11) NOT NULL,
  `total` decimal(65,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `advance_supplier`
--

CREATE TABLE `advance_supplier` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `amount` decimal(65,2) DEFAULT NULL,
  `unit_price` decimal(65,2) DEFAULT NULL,
  `quantity` decimal(65,2) DEFAULT NULL,
  `detail` text COLLATE utf8_spanish_ci,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `regional_id` int(11) NOT NULL,
  `payed` tinyint(1) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `archived` tinyint(1) DEFAULT NULL,
  `method_id` int(11) NOT NULL,
  `paid_account` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brand_reception`
--

CREATE TABLE `brand_reception` (
  `id` int(11) NOT NULL,
  `quantity` decimal(65,2) DEFAULT NULL,
  `brand` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `reception_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `city`
--

INSERT INTO `city` (`id`, `name`, `department_id`) VALUES
(1, 'Bogotá', 1),
(2, 'Puerto Nariño', 2),
(3, 'Leticia', 2),
(4, 'Medellín', 3),
(5, 'Abejorral', 3),
(6, 'Abriaqui', 3),
(7, 'Alejandría', 3),
(8, 'Amagá', 3),
(9, 'Amalfi', 3),
(10, 'Andes', 3),
(11, 'Angelópolis', 3),
(12, 'Angostura', 3),
(13, 'Anorí', 3),
(14, 'Antioquia', 3),
(15, 'Anzá', 3),
(16, 'Apartadó', 3),
(17, 'Arboletes', 3),
(18, 'Argelia', 3),
(19, 'Armenia', 3),
(20, 'Barbosa', 3),
(21, 'Belmira', 3),
(22, 'Bello', 3),
(23, 'Betania', 3),
(24, 'Betulia', 3),
(25, 'Bolívar', 3),
(26, 'Briseño', 3),
(27, 'Buriticá', 3),
(28, 'Cáceres', 3),
(29, 'Caicedo', 3),
(30, 'Caldas', 3),
(31, 'Campamento', 3),
(32, 'Cañasgordas', 3),
(33, 'Caracolí', 3),
(34, 'Caramanta', 3),
(35, 'Carepa', 3),
(36, 'Carmen de Viboral', 3),
(37, 'Carolina', 3),
(38, 'Caucasia', 3),
(39, 'Chigorodó', 3),
(40, 'Cisneros', 3),
(41, 'Cocorná', 3),
(42, 'Concepción', 3),
(43, 'Concordia', 3),
(44, 'Copacabana', 3),
(45, 'Dabeiba', 3),
(46, 'Don Matías', 3),
(47, 'Ebéjico', 3),
(48, 'El Bagre', 3),
(49, 'Entrerríos', 3),
(50, 'Envigado', 3),
(51, 'Fredonia', 3),
(52, 'Frontino', 3),
(53, 'Giraldo', 3),
(54, 'Girardota', 3),
(55, 'Gómez Plata', 3),
(56, 'Granada', 3),
(57, 'Guadalupe', 3),
(58, 'Guarne', 3),
(59, 'Guatapé', 3),
(60, 'Heliconia', 3),
(61, 'Hispania', 3),
(62, 'Itagüí', 3),
(63, 'Ituango', 3),
(64, 'Jardín', 3),
(65, 'Jericó', 3),
(66, 'La Ceja', 3),
(67, 'La Estrella', 3),
(68, 'La Pintada', 3),
(69, 'La Unión', 3),
(70, 'Liborina', 3),
(71, 'Maceo', 3),
(72, 'Marinilla', 3),
(73, 'Montebello', 3),
(74, 'Murindó', 3),
(75, 'Mutatá', 3),
(76, 'Nariño', 3),
(77, 'Necoclí', 3),
(78, 'Nechí', 3),
(79, 'Olaya', 3),
(80, 'Peñol', 3),
(81, 'Peque', 3),
(82, 'Pueblorrico', 3),
(83, 'Puerto Berrío', 3),
(84, 'Puerto Nare', 3),
(85, 'Puerto Triunfo', 3),
(86, 'Remedios', 3),
(87, 'Retiro', 3),
(88, 'Rionegro', 3),
(89, 'Sabanalarga', 3),
(90, 'Sabaneta', 3),
(91, 'Salgar', 3),
(92, 'San Andrés', 3),
(93, 'San Carlos', 3),
(94, 'San francisco', 3),
(95, 'San Jerónimo', 3),
(96, 'San José de Montaña', 3),
(97, 'San Juan de Urabá', 3),
(98, 'San Luis', 3),
(99, 'San Pedro', 3),
(100, 'San Pedro de Urabá', 3),
(101, 'San Rafael', 3),
(102, 'San Roque', 3),
(103, 'San Vicente', 3),
(104, 'Santa Bárbara', 3),
(105, 'Santa Rosa de Osos', 3),
(106, 'Santo Domingo', 3),
(107, 'Santuario', 3),
(108, 'Segovia', 3),
(109, 'Sonsón', 3),
(110, 'Sopetrán', 3),
(111, 'Támesis', 3),
(112, 'Tarazá', 3),
(113, 'Tarso', 3),
(114, 'Titiribí', 3),
(115, 'Toledo', 3),
(116, 'Turbo', 3),
(117, 'Uramita', 3),
(118, 'Urrao', 3),
(119, 'Valdivia', 3),
(120, 'Valparaíso', 3),
(121, 'Vegachí', 3),
(122, 'Venecia', 3),
(123, 'Vigía del Fuerte', 3),
(124, 'Yalí', 3),
(125, 'Yarumal', 3),
(126, 'Yolombó', 3),
(127, 'Yondó (Casabe)', 3),
(128, 'Zaragoza', 3),
(129, 'Arauca', 4),
(130, 'Arauquita', 4),
(131, 'Cravo Norte', 4),
(132, 'Fortul', 4),
(133, 'Puerto Rondón', 4),
(134, 'Fortul', 4),
(135, 'Puerto Rondón', 4),
(136, 'Saravena', 4),
(137, 'Tame', 4),
(138, 'Barranquilla', 5),
(139, 'Baranoa', 5),
(140, 'Campo de la Cruz', 5),
(141, 'Candelaria', 5),
(142, 'Galapa', 5),
(143, 'Juan de Acosta', 5),
(144, 'Luruaco', 5),
(145, 'Malambo', 5),
(146, 'Manatí', 5),
(147, 'Palmar de Varela', 5),
(148, 'Piojó', 5),
(149, 'Polonuevo', 5),
(150, 'Ponedera', 5),
(151, 'Puerto Colombia', 5),
(152, 'Repelón', 5),
(153, 'Sabanagrande', 5),
(154, 'Sabanalarga', 5),
(155, 'Santa Lucía', 5),
(156, 'Santo Tomás', 5),
(157, 'Soledad', 5),
(158, 'Suán', 5),
(159, 'Tubará', 5),
(160, 'Usiacurí', 5),
(161, 'Cartagena', 6),
(162, 'Achí', 6),
(163, 'Altos del Rosario', 6),
(164, 'Arenal', 6),
(165, 'Arjona', 6),
(166, 'Arroyohondo', 6),
(167, 'Barranco de Loba', 6),
(168, 'Calamar', 6),
(169, 'Cantagallo', 6),
(170, 'Cicuco', 6),
(171, 'Córdoba', 6),
(172, 'Clemencia', 6),
(173, 'El Carmen de Bolívar', 6),
(174, 'El Guamo', 6),
(175, 'El Peñón', 6),
(176, 'Hatillo de Loba', 6),
(177, 'Magangué', 6),
(178, 'Mahates', 6),
(179, 'Margarita', 6),
(180, 'María la Baja', 6),
(181, 'Montecristo', 6),
(182, 'Santa Cruz de Mompox', 6),
(183, 'Morales', 6),
(184, 'Norosí', 6),
(185, 'Pinillos', 6),
(186, 'Regidor', 6),
(187, 'Río Viejo', 6),
(188, 'San Cristóbal', 6),
(189, 'San Estanislao', 6),
(190, 'San Fernando', 6),
(191, 'San Jacinto', 6),
(192, 'San Jacinto del Cauca', 6),
(193, 'San Juan Nepomuceno', 6),
(194, 'San Martín de Loba', 6),
(195, 'San Pablo', 6),
(196, 'Santa Catalina', 6),
(197, 'Santa Rosa', 6),
(198, 'Santa Rosa del Sur', 6),
(199, 'Simití', 6),
(200, 'Soplaviento', 6),
(201, 'Talaigua Nuevo', 6),
(202, 'Tiquisio', 6),
(203, 'Turbaco', 6),
(204, 'Turbaná', 6),
(205, 'Villanueva', 6),
(206, 'Zambrano', 6),
(207, 'Tunja', 7),
(208, 'Almeida', 7),
(209, 'Aquitania', 7),
(210, 'Arcabuco', 7),
(211, 'Belén', 7),
(212, 'Berbeo', 7),
(213, 'Beteitiva', 7),
(214, 'Boavita', 7),
(215, 'Boyacá', 7),
(216, 'Briceño', 7),
(217, 'Buenavista', 7),
(218, 'Busbanzá', 7),
(219, 'Caldas', 7),
(220, 'Campohermoso', 7),
(221, 'Cerinza', 7),
(222, 'Chinavita', 7),
(223, 'Chiquinquirá', 7),
(224, 'Chiscas', 7),
(225, 'Chitaranque', 7),
(226, 'Chivatá', 7),
(227, 'Ciénaga', 7),
(228, 'Cómbita', 7),
(229, 'Coper', 7),
(230, 'Corrales', 7),
(231, 'Covarachia', 7),
(232, 'Cubará', 7),
(233, 'Cucaita', 7),
(234, 'Cuitiva', 7),
(235, 'Chíquiza', 7),
(236, 'Chivor', 7),
(237, 'Duitama', 7),
(238, 'El Cocuy', 7),
(239, 'El Espino', 7),
(240, 'Firavitoba', 7),
(241, 'Floresta', 7),
(242, 'Gachantivá', 7),
(243, 'Gámeza', 7),
(244, 'Garagoa', 7),
(245, 'Guacamayas', 7),
(246, 'Guateque', 7),
(247, 'Guayatá', 7),
(248, 'Güicán', 7),
(249, 'Iza', 7),
(250, 'Jenesano', 7),
(251, 'Jericó', 7),
(252, 'Labranzagrande', 7),
(253, 'La Capilla', 7),
(254, 'La Victoria', 7),
(255, 'La Uvita', 7),
(256, 'Villa de Leyva', 7),
(257, 'Macanal', 7),
(258, 'Maripí', 7),
(259, 'Miraflores', 7),
(260, 'Mongua', 7),
(261, 'Monguí', 7),
(262, 'Moniquirá', 7),
(263, 'Motavita', 7),
(264, 'Muzo', 7),
(265, 'Nobsa', 7),
(266, 'Nuevo Colón', 7),
(267, 'Oicatá', 7),
(268, 'Otanche', 7),
(269, 'Pachavita', 7),
(270, 'Páez', 7),
(271, 'Paipa', 7),
(272, 'Pajarito', 7),
(273, 'Panqueba', 7),
(274, 'Pauna', 7),
(275, 'Paya', 7),
(276, 'Paz de Río', 7),
(277, 'Pesca', 7),
(278, 'Pisba', 7),
(279, 'Puerto Boyacá', 7),
(280, 'Quípama', 7),
(281, 'Ramiriquí', 7),
(282, 'Ráquira', 7),
(283, 'Rondón', 7),
(284, 'Saboyá', 7),
(285, 'Sáchica', 7),
(286, 'Samacá', 7),
(287, 'San Eduardo', 7),
(288, 'San José de Pare', 7),
(289, 'San Luis de Gaceno', 7),
(290, 'San Mateo', 7),
(291, 'San Miguel de Sema', 7),
(292, 'San Pablo de Borbur', 7),
(293, 'Santana', 7),
(294, 'Santa María', 7),
(295, 'Santa Rosa de Viterbo', 7),
(296, 'Santa Sofía', 7),
(297, 'Sativanorte', 7),
(298, 'Sativasur', 7),
(299, 'Siachoque', 7),
(300, 'Soatá', 7),
(301, 'Socotá', 7),
(302, 'Socha', 7),
(303, 'Sogamoso', 7),
(304, 'Somondoco', 7),
(305, 'Sora', 7),
(306, 'Sotaquirá', 7),
(307, 'Soracá', 7),
(308, 'Susacón', 7),
(309, 'Sutamarchán', 7),
(310, 'Sutatenza', 7),
(311, 'Tasco', 7),
(312, 'Tenza', 7),
(313, 'Tibaná', 7),
(314, 'Tibasosa', 7),
(315, 'Tinjacá', 7),
(316, 'Tipacoque', 7),
(317, 'Toca', 7),
(318, 'Togüí', 7),
(319, 'Tópaga', 7),
(320, 'Tota', 7),
(321, 'Tununguá', 7),
(322, 'Turmequé', 7),
(323, 'Tuta', 7),
(324, 'Tutazá', 7),
(325, 'Úmbita', 7),
(326, 'Ventaquemada', 7),
(327, 'Viracachá', 7),
(328, 'Zetaquirá', 7),
(329, 'Manizales', 8),
(330, 'Aguadas', 8),
(331, 'Anserma', 8),
(332, 'Aranzazu', 8),
(333, 'Belalcázar', 8),
(334, 'Chinchiná', 8),
(335, 'Filadelfia', 8),
(336, 'La Dorada', 8),
(337, 'La Merced', 8),
(338, 'Manzanares', 8),
(339, 'Marmato', 8),
(340, 'Marquetalia', 8),
(341, 'Marulanda', 8),
(342, 'Neira', 8),
(343, 'Pácora', 8),
(344, 'Palestina', 8),
(345, 'Pensilvania', 8),
(346, 'Riosucio', 8),
(347, 'Risaralda', 8),
(348, 'Salamina', 8),
(349, 'Samaná', 8),
(350, 'San José', 8),
(351, 'Supía', 8),
(352, 'Victoria', 8),
(353, 'Villamaría', 8),
(354, 'Viterbo', 8),
(355, 'Florencia', 9),
(356, 'Albania', 9),
(357, 'Belén de los Andaquíes', 9),
(358, 'Cartagena del Chairá', 9),
(359, 'Curillo', 9),
(360, 'El Doncello', 9),
(361, 'El Paujil', 9),
(362, 'La Montañita', 9),
(363, 'Milán', 9),
(364, 'Morelia', 9),
(365, 'Puerto Rico', 9),
(366, 'San José del Fragua', 9),
(367, 'San Vicente del Caguán', 9),
(368, 'Solano', 9),
(369, 'Solita', 9),
(370, 'Valparaíso', 9),
(371, 'Yopal', 10),
(372, 'Aguazul', 10),
(373, 'Chameza', 10),
(374, 'Hato Corozal', 10),
(375, 'La Salina', 10),
(376, 'Maní', 10),
(377, 'Monterrey', 10),
(378, 'Nunchía', 10),
(379, 'Orocué', 10),
(380, 'Paz de Ariporo', 10),
(381, 'Pore', 10),
(382, 'Recetor', 10),
(383, 'Sabanalarga', 10),
(384, 'Sácama', 10),
(385, 'San Luis de Palenque', 10),
(386, 'Támara', 10),
(387, 'Tauramena', 10),
(388, 'Trinidad', 10),
(389, 'Villanueva', 10),
(390, 'Popayán', 11),
(391, 'Almaguer', 11),
(392, 'Argelia', 11),
(393, 'Balboa', 11),
(394, 'Bolívar', 11),
(395, 'Buenos Aires', 11),
(396, 'Cajibío', 11),
(397, 'Caldono', 11),
(398, 'Caloto', 11),
(399, 'Corinto', 11),
(400, 'El Tambo', 11),
(401, 'Florencia', 11),
(402, 'Guapi', 11),
(403, 'Inzá', 11),
(404, 'Jambaló', 11),
(405, 'La Sierra', 11),
(406, 'La Vega', 11),
(407, 'López (Micay)', 11),
(408, 'Mercaderes', 11),
(409, 'Miranda', 11),
(410, 'Morales', 11),
(411, 'Padilla', 11),
(412, 'Páez (Belalcazar)', 11),
(413, 'Patía (El Bordo)', 11),
(414, 'Piamonte', 11),
(415, 'Piendamó', 11),
(416, 'Puerto Tejada', 11),
(417, 'Puracé (Coconuco)', 11),
(418, 'Rosas', 11),
(419, 'San Sebastián', 11),
(420, 'Santander de Quilichao', 11),
(421, 'Santa Rosa', 11),
(422, 'Silvia', 11),
(423, 'Sotará (Paispamba)', 11),
(424, 'Suárez', 11),
(425, 'Timbío', 11),
(426, 'Timbiquí', 11),
(427, 'Toribío', 11),
(428, 'Totoró', 11),
(429, 'Valledupar', 12),
(430, 'Aguachica', 12),
(431, 'Agustín Codazzi', 12),
(432, 'Astrea', 12),
(433, 'Becerril', 12),
(434, 'Bosconia', 12),
(435, 'Chimichagua', 12),
(436, 'Chiriguaná', 12),
(437, 'Curumaní', 12),
(438, 'El Copey', 12),
(439, 'El Paso', 12),
(440, 'Gamarra', 12),
(441, 'González', 12),
(442, 'La Gloria', 12),
(443, 'La Jagua de Ibirico', 12),
(444, 'Manaure Balcón Cesar', 12),
(445, 'Pailitas', 12),
(446, 'Pelaya', 12),
(447, 'Pueblo Bello', 12),
(448, 'Río de Oro', 12),
(449, 'La Paz (Robles)', 12),
(450, 'San Alberto', 12),
(451, 'San Diego', 12),
(452, 'San Martín', 12),
(453, 'Tamalameque', 12),
(454, 'Montería', 13),
(455, 'Ayapel', 13),
(456, 'Buenavista', 13),
(457, 'Canalete', 13),
(458, 'Cereté', 13),
(459, 'Chima', 13),
(460, 'Chinú', 13),
(461, 'Ciénaga de Oro', 13),
(462, 'Cotorra', 13),
(463, 'La Apartada (Frontera)', 13),
(464, 'Lorica', 13),
(465, 'Los Córdobas', 13),
(466, 'Momil', 13),
(467, 'Montelíbano', 13),
(468, 'Moñitos', 13),
(469, 'Planeta Rica', 13),
(470, 'Pueblo Nuevo', 13),
(471, 'Puerto Escondido', 13),
(472, 'Puerto Libertador', 13),
(473, 'Purísima', 13),
(474, 'Sahagún', 13),
(475, 'San Andrés Sotavento', 13),
(476, 'San Antero', 13),
(477, 'San Bernardo del Viento', 13),
(478, 'San Carlos', 13),
(479, 'San José de Uré', 13),
(480, 'San Pelayo', 13),
(481, 'Santa Cruz de Lorica', 13),
(482, 'Tierralta', 13),
(483, 'Valencia', 13),
(484, 'Agua de Dios', 14),
(485, 'Albán', 14),
(486, 'Anapoima', 14),
(487, 'Anolaima', 14),
(488, 'Arbeláez', 14),
(489, 'Beltrán', 14),
(490, 'Bituima', 14),
(491, 'Bojacá', 14),
(492, 'Cabrera', 14),
(493, 'Cachipay', 14),
(494, 'Cajicá', 14),
(495, 'Caparrapí', 14),
(496, 'Cáqueza', 14),
(497, 'Carmen de Carupa', 14),
(498, 'Chaguaní', 14),
(499, 'Chía', 14),
(500, 'Chipaque', 14),
(501, 'Choachí', 14),
(502, 'Chocontá', 14),
(503, 'Cogua', 14),
(504, 'Cota', 14),
(505, 'Cucunubá', 14),
(506, 'El Colegio', 14),
(507, 'El Peñón', 14),
(508, 'El Rosal', 14),
(509, 'Facatativá', 14),
(510, 'Fómeque', 14),
(511, 'Fosca', 14),
(512, 'Funza', 14),
(513, 'Fúquene', 14),
(514, 'Fusagasugá', 14),
(515, 'Gachalá', 14),
(516, 'Gachancipá', 14),
(517, 'Gachetá', 14),
(518, 'Gama', 14),
(519, 'Girardot', 14),
(520, 'Granada', 14),
(521, 'Guachetá', 14),
(522, 'Guaduas', 14),
(523, 'Guasca', 14),
(524, 'Guataquí', 14),
(525, 'Guatavita', 14),
(526, 'Guayabal de Síquima', 14),
(527, 'Guayabetal', 14),
(528, 'Gutiérrez', 14),
(529, 'Jerusalén', 14),
(530, 'Junín', 14),
(531, 'La Calera', 14),
(532, 'La Mesa', 14),
(533, 'La Palma', 14),
(534, 'La Peña', 14),
(535, 'La Vega', 14),
(536, 'Lenguazaque', 14),
(537, 'Machetá', 14),
(538, 'Madrid', 14),
(539, 'Manta', 14),
(540, 'Medina', 14),
(541, 'Mosquera', 14),
(542, 'Nariño', 14),
(543, 'Nemocón', 14),
(544, 'Nilo', 14),
(545, 'Nimaima', 14),
(546, 'Nocaima', 14),
(547, 'Venecia (Ospina Pérez)', 14),
(548, 'Pacho', 14),
(549, 'Paime', 14),
(550, 'Pandi', 14),
(551, 'Paratebueno', 14),
(552, 'Pasca', 14),
(553, 'Puerto Salgar', 14),
(554, 'Pulí', 14),
(555, 'Quebradanegra', 14),
(556, 'Quetame', 14),
(557, 'Quipile', 14),
(558, 'Rafael', 14),
(559, 'Ricaurte', 14),
(560, 'San Antonio de Tequendama', 14),
(561, 'San Bernardo', 14),
(562, 'San Cayetano', 14),
(563, 'San Francisco', 14),
(564, 'San Juan de Rioseco', 14),
(565, 'Sasaima', 14),
(566, 'Sesquilé', 14),
(567, 'Sibaté', 14),
(568, 'Silvania', 14),
(569, 'Simijaca', 14),
(570, 'Soacha', 14),
(571, 'Sopó', 14),
(572, 'Subachoque', 14),
(573, 'Suesca', 14),
(574, 'Supatá', 14),
(575, 'Susa', 14),
(576, 'Sutatausa', 14),
(577, 'Tabio', 14),
(578, 'Tausa', 14),
(579, 'Tena', 14),
(580, 'Tenjo', 14),
(581, 'Tibacuy', 14),
(582, 'Tibirita', 14),
(583, 'Tocaima', 14),
(584, 'Tocancipá', 14),
(585, 'Topaipí', 14),
(586, 'Ubalá', 14),
(587, 'Ubaque', 14),
(588, 'Ubaté', 14),
(589, 'Une', 14),
(590, 'Útica', 14),
(591, 'Vergara', 14),
(592, 'Vianí', 14),
(593, 'Villagómez', 14),
(594, 'Villapinzón', 14),
(595, 'Villeta', 14),
(596, 'Viotá', 14),
(597, 'Yacopí', 14),
(598, 'Zipacón', 14),
(599, 'Zipaquirá', 14),
(600, 'Quibdó', 15),
(601, 'Acandí', 15),
(602, 'Alto Baudó (Pie de Pato)', 15),
(603, 'Atrato (Yuto)', 15),
(604, 'Bagadó', 15),
(605, 'Bahía Solano (Mútis)', 15),
(606, 'Bajo Baudó (Pizarro)', 15),
(607, 'Bojayá (Bellavista)', 15),
(608, 'Cantón de San Pablo', 15),
(609, 'Cértegui', 15),
(610, 'Condoto', 15),
(611, 'El Carmen de Atrato', 15),
(612, 'El Carmen de Darién', 15),
(613, 'El Litoral de San Juan', 15),
(614, 'Itsmina', 15),
(615, 'Juradó', 15),
(616, 'Lloró', 15),
(617, 'Nóvita', 15),
(618, 'Medio Atrato', 15),
(619, 'Medio Baudó', 15),
(620, 'Medio San Juan', 15),
(621, 'Nuquí', 15),
(622, 'Rio Iró', 15),
(623, 'Río Quito', 15),
(624, 'Riosucio', 15),
(625, 'San José del Palmar', 15),
(626, 'Sipí', 15),
(627, 'Tadó', 15),
(628, 'Unguía', 15),
(629, 'Unión Panamericana', 15),
(630, 'Puerto Inírida', 16),
(631, 'San José del Guaviare', 17),
(632, 'Calamar', 17),
(633, 'El Retorno', 17),
(634, 'Miraflores', 17),
(635, 'Neiva', 18),
(636, 'Acevedo', 18),
(637, 'Agrado', 18),
(638, 'Aipe', 18),
(639, 'Algeciras', 18),
(640, 'Altamira', 18),
(641, 'Baraya', 18),
(642, 'Campoalegre', 18),
(643, 'Colombia', 18),
(644, 'Elías', 18),
(645, 'Garzón', 18),
(646, 'Gigante', 18),
(647, 'Guadalupe', 18),
(648, 'Hobo', 18),
(649, 'Iquira', 18),
(650, 'Isnos', 18),
(651, 'La Argentina', 18),
(652, 'La Plata', 18),
(653, 'Nátaga', 18),
(654, 'Oporapa', 18),
(655, 'Paicol', 18),
(656, 'Palermo', 18),
(657, 'Palestina', 18),
(658, 'Pital', 18),
(659, 'Pitalito', 18),
(660, 'Rivera', 18),
(661, 'Saladoblanco', 18),
(662, 'San Agustín', 18),
(663, 'Santa María', 18),
(664, 'Suazá', 18),
(665, 'Tarqui', 18),
(666, 'Tesalia', 18),
(667, 'Tello', 18),
(668, 'Teruel', 18),
(669, 'Timaná', 18),
(670, 'Villavieja', 18),
(671, 'Yaguará', 18),
(672, 'Riohacha', 19),
(673, 'Barrancas', 19),
(674, 'Dibulla', 19),
(675, 'Distracción', 19),
(676, 'El Molino', 19),
(677, 'Fonseca', 19),
(678, 'Hatonuevo', 19),
(679, 'La Jagua del Pilar', 19),
(680, 'Maicao', 19),
(681, 'Manaure', 19),
(682, 'San Juan del Cesar', 19),
(683, 'Uribía', 19),
(684, 'Urumita', 19),
(685, 'Villanueva', 19),
(686, 'Santa Marta', 20),
(687, 'Aracataca', 20),
(688, 'Ariguaní (El Difícil)', 20),
(689, 'Cerro San Antonio', 20),
(690, 'Chibolo', 20),
(691, 'Ciénaga', 20),
(692, 'Concordia', 20),
(693, 'El Banco', 20),
(694, 'El Piñón', 20),
(695, 'El Retén', 20),
(696, 'Fundación', 20),
(697, 'Guamal', 20),
(698, 'Nueva Granada', 20),
(699, 'Pedraza', 20),
(700, 'Pijiño del Carmen', 20),
(701, 'Pivijay', 20),
(702, 'Plato', 20),
(703, 'Pueblo Viejo', 20),
(704, 'Remolino', 20),
(705, 'Salamina', 20),
(706, 'San Sebastián de Buenavista', 20),
(707, 'San Zenón', 20),
(708, 'Santa Ana', 20),
(709, 'Santa Bárbara de Pinto', 20),
(710, 'Sitionuevo', 20),
(711, 'Tenerife', 20),
(712, 'Zapayán', 20),
(713, 'Zona Bananera', 20),
(714, 'Villavicencio', 21),
(715, 'Acacias', 21),
(716, 'Barranca de Upía', 21),
(717, 'Cabuyaro', 21),
(718, 'Castilla la Nueva', 21),
(719, 'Cubarral', 21),
(720, 'Cumaral', 21),
(721, 'El Calvario', 21),
(722, 'El Castillo', 21),
(723, 'El Dorado', 21),
(724, 'Fuente de Oro', 21),
(725, 'Granada', 21),
(726, 'Guamal', 21),
(727, 'Mapiripán', 21),
(728, 'Mesetas', 21),
(729, 'La Macarena', 21),
(730, 'La Uribe', 21),
(731, 'Lejanías', 21),
(732, 'Puerto Concordia', 21),
(733, 'Puerto Gaitán', 21),
(734, 'Puerto López', 21),
(735, 'Puerto Lleras', 21),
(736, 'Puerto Rico', 21),
(737, 'Restrepo', 21),
(738, 'San Carlos de Guaroa', 21),
(739, 'San Juan de Arama', 21),
(740, 'San Juanito', 21),
(741, 'San Martín', 21),
(742, 'Vista Hermosa', 21),
(743, 'Pasto', 22),
(744, 'Albán (San José)', 22),
(745, 'Aldana', 22),
(746, 'Ancuyá', 22),
(747, 'Arboleda (Berruecos)', 22),
(748, 'Barbacoas', 22),
(749, 'Belén', 22),
(750, 'Buesaco', 22),
(751, 'Colón (Génova)', 22),
(752, 'Consacá', 22),
(753, 'Contadero', 22),
(754, 'Córdoba', 22),
(755, 'Cuaspud (Carlosama)', 22),
(756, 'Cumbal', 22),
(757, 'Cumbitara', 22),
(758, 'Chachagüí', 22),
(759, 'El Charco', 22),
(760, 'El Rosario', 22),
(761, 'El Tablón', 22),
(762, 'El Tambo', 22),
(763, 'Funes', 22),
(764, 'Guachucal', 22),
(765, 'Guaitarilla', 22),
(766, 'Gualmatán', 22),
(767, 'Iles', 22),
(768, 'Imués', 22),
(769, 'Ipiales', 22),
(770, 'La Cruz', 22),
(771, 'La Florida', 22),
(772, 'La Llanada', 22),
(773, 'La Tola', 22),
(774, 'La Unión', 22),
(775, 'Leiva', 22),
(776, 'Linares', 22),
(777, 'Los Andes (Sotomayor)', 22),
(778, 'Magüí (Payán)', 22),
(779, 'Mallama (Piedrancha)', 22),
(780, 'Mosquera', 22),
(781, 'Olaya', 22),
(782, 'Ospina', 22),
(783, 'Francisco Pizarro', 22),
(784, 'Policarpa', 22),
(785, 'Potosí', 22),
(786, 'Providencia', 22),
(787, 'Puerres', 22),
(788, 'Pupiales', 22),
(789, 'Ricaurte', 22),
(790, 'Roberto Payán (San José)', 22),
(791, 'Samaniego', 22),
(792, 'Sandoná', 22),
(793, 'San Bernardo', 22),
(794, 'San Lorenzo', 22),
(795, 'San Pablo', 22),
(796, 'San Pedro de Cartago', 22),
(797, 'Santa Bárbara (Iscuandé)', 22),
(798, 'Santa Cruz (Guachávez)', 22),
(799, 'Sapuyes', 22),
(800, 'Taminango', 22),
(801, 'Tangua', 22),
(802, 'Tumaco', 22),
(803, 'Túquerres', 22),
(804, 'Yacuanquer', 22),
(805, 'Cúcuta', 23),
(806, 'Abrego', 23),
(807, 'Arboledas', 23),
(808, 'Bochalema', 23),
(809, 'Bucarasica', 23),
(810, 'Cácota', 23),
(811, 'Cáchira', 23),
(812, 'Chinácota', 23),
(813, 'Chitagá', 23),
(814, 'Convención', 23),
(815, 'Cucutilla', 23),
(816, 'Durania', 23),
(817, 'El Carmen', 23),
(818, 'El Tarra', 23),
(819, 'El Zulia', 23),
(820, 'Gramalote', 23),
(821, 'Hacarí', 23),
(822, 'Herrán', 23),
(823, 'Labateca', 23),
(824, 'La Esperanza', 23),
(825, 'La Playa', 23),
(826, 'Los Patios', 23),
(827, 'Lourdes', 23),
(828, 'Mutiscua', 23),
(829, 'Ocaña', 23),
(830, 'Pamplona', 23),
(831, 'Pamplonita', 23),
(832, 'Puerto Santander', 23),
(833, 'Ragonvalia', 23),
(834, 'Salazar', 23),
(835, 'San Calixto', 23),
(836, 'San Cayetano', 23),
(837, 'Santiago', 23),
(838, 'Sardinata', 23),
(839, 'Santo Domingo de los Silos', 23),
(840, 'Teorama', 23),
(841, 'Tibú', 23),
(842, 'Toledo', 23),
(843, 'Villa Caro', 23),
(844, 'Villa del Rosario', 23),
(845, 'Mocoa', 24),
(846, 'Colón', 24),
(847, 'Orito', 24),
(848, 'Puerto Asís', 24),
(849, 'Puerto Caicedo', 24),
(850, 'Puerto Guzmán', 24),
(851, 'Puerto Leguízamo', 24),
(852, 'Sibundoy', 24),
(853, 'San Francisco', 24),
(854, 'San Miguel', 24),
(855, 'Santiago', 24),
(856, 'Valle del Guamuez', 24),
(857, 'Villa Garzón', 24),
(858, 'Armenia', 25),
(859, 'Buenavista', 25),
(860, 'Calarcá', 25),
(861, 'Circasia', 25),
(862, 'Córdoba', 25),
(863, 'Filandia', 25),
(864, 'Génova', 25),
(865, 'La Tebaida', 25),
(866, 'Montenegro', 25),
(867, 'Pijao', 25),
(868, 'Quimbaya', 25),
(869, 'Salento', 25),
(870, 'Pereira', 26),
(871, 'Apía', 26),
(872, 'Balboa', 26),
(873, 'Belén de Umbría', 26),
(874, 'Dos Quebradas', 26),
(875, 'Guática', 26),
(876, 'La Celia', 26),
(877, 'La Virginia', 26),
(878, 'Marsella', 26),
(879, 'Mistrató', 26),
(880, 'Pueblo Rico', 26),
(881, 'Quinchia', 26),
(882, 'Santa Rosa de Cabal', 26),
(883, 'Santuario', 26),
(884, 'San Andrés', 27),
(885, 'Providencia', 27),
(886, 'Bucaramanga', 28),
(887, 'Aguada', 28),
(888, 'Albania', 28),
(889, 'Aratoca', 28),
(890, 'Barbosa', 28),
(891, 'Barichara', 28),
(892, 'Barrancabermeja', 28),
(893, 'Betulia', 28),
(894, 'Bolívar', 28),
(895, 'Cabrera', 28),
(896, 'California', 28),
(897, 'Capitanejo', 28),
(898, 'Carcasí', 28),
(899, 'Cepitá', 28),
(900, 'Cerrito', 28),
(901, 'Charalá', 28),
(902, 'Charta', 28),
(903, 'Chima', 28),
(904, 'Chipatá', 28),
(905, 'Cimitarra', 28),
(906, 'Concepción', 28),
(907, 'Confines', 28),
(908, 'Contratación', 28),
(909, 'Coromoro', 28),
(910, 'Curití', 28),
(911, 'El Carmen de Chururí', 28),
(912, 'El Guacamayo', 28),
(913, 'El Peñón', 28),
(914, 'El Playón', 28),
(915, 'Encino', 28),
(916, 'Enciso', 28),
(917, 'Florián', 28),
(918, 'Floridablanca', 28),
(919, 'Galán', 28),
(920, 'Gámbita', 28),
(921, 'Girón', 28),
(922, 'Guaca', 28),
(923, 'Guadalupe', 28),
(924, 'Guapotá', 28),
(925, 'Guavatá', 28),
(926, 'Güepsa', 28),
(927, 'Hato', 28),
(928, 'Jesús María', 28),
(929, 'Jordán', 28),
(930, 'La Belleza', 28),
(931, 'Landázuri', 28),
(932, 'La Paz', 28),
(933, 'Lebrija', 28),
(934, 'Los Santos', 28),
(935, 'Macaravita', 28),
(936, 'Málaga', 28),
(937, 'Matanza', 28),
(938, 'Mogotes', 28),
(939, 'Molagavita', 28),
(940, 'Ocamonte', 28),
(941, 'Oiba', 28),
(942, 'Onzaga', 28),
(943, 'Palmar', 28),
(944, 'Palmas del Socorro', 28),
(945, 'Páramo', 28),
(946, 'Piedecuesta', 28),
(947, 'Pinchote', 28),
(948, 'Puente Nacional', 28),
(949, 'Puerto Parra', 28),
(950, 'Puerto Wilches', 28),
(951, 'Rionegro', 28),
(952, 'Sabana de Torres', 28),
(953, 'San Andrés', 28),
(954, 'San Benito', 28),
(955, 'San Gil', 28),
(956, 'San Joaquín', 28),
(957, 'San José de Miranda', 28),
(958, 'San Miguel', 28),
(959, 'San Vicente de Chucurí', 28),
(960, 'Santa Bárbara', 28),
(961, 'Santa Helena del Opón', 28),
(962, 'Simacota', 28),
(963, 'Socorro', 28),
(964, 'Suaita', 28),
(965, 'Sucre', 28),
(966, 'Suratá', 28),
(967, 'Tona', 28),
(968, 'Valle de San José', 28),
(969, 'Vélez', 28),
(970, 'Vetas', 28),
(971, 'Villanueva', 28),
(972, 'Zapatoca', 28),
(973, 'Sincelejo', 29),
(974, 'Buenavista', 29),
(975, 'Caimito', 29),
(976, 'Colosó', 29),
(977, 'Corozal', 29),
(978, 'Chalán', 29),
(979, 'Galeras (Nueva Granada)', 29),
(980, 'Guaranda', 29),
(981, 'La Unión', 29),
(982, 'Los Palmitos', 29),
(983, 'Majagual', 29),
(984, 'Morroa', 29),
(985, 'Ovejas', 29),
(986, 'Palmito', 29),
(987, 'Sampués', 29),
(988, 'San Benito Abad', 29),
(989, 'San Juan de Betulia', 29),
(990, 'San Marcos', 29),
(991, 'San Onofre', 29),
(992, 'San Pedro', 29),
(993, 'Sincé', 29),
(994, 'Sucre', 29),
(995, 'Santiago de Tolú', 29),
(996, 'Tolúviejo', 29),
(997, 'Ibagué', 30),
(998, 'Alpujarra', 30),
(999, 'Alvarado', 30),
(1000, 'Ambalema', 30),
(1001, 'Anzoátegui', 30),
(1002, 'Armero (Guayabal)', 30),
(1003, 'Ataco', 30),
(1004, 'Cajamarca', 30),
(1005, 'Carmen de Apicalá', 30),
(1006, 'Casabianca', 30),
(1007, 'Chaparral', 30),
(1008, 'Coello', 30),
(1009, 'Coyaima', 30),
(1010, 'Cunday', 30),
(1011, 'Dolores', 30),
(1012, 'Espinal', 30),
(1013, 'Falan', 30),
(1014, 'Flandes', 30),
(1015, 'Fresno', 30),
(1016, 'Guamo', 30),
(1017, 'Herveo', 30),
(1018, 'Honda', 30),
(1019, 'Icononzo', 30),
(1020, 'Lérida', 30),
(1021, 'Líbano', 30),
(1022, 'Mariquita', 30),
(1023, 'Melgar', 30),
(1024, 'Murillo', 30),
(1025, 'Natagaima', 30),
(1026, 'Ortega', 30),
(1027, 'Palocabildo', 30),
(1028, 'Piedras', 30),
(1029, 'Planadas', 30),
(1030, 'Prado', 30),
(1031, 'Purificación', 30),
(1032, 'Rioblanco', 30),
(1033, 'Roncesvalles', 30),
(1034, 'Rovira', 30),
(1035, 'Saldaña', 30),
(1036, 'San Antonio', 30),
(1037, 'San Luis', 30),
(1038, 'Santa Isabel', 30),
(1039, 'Suárez', 30),
(1040, 'Valle de San Juan', 30),
(1041, 'Venadillo', 30),
(1042, 'Villahermosa', 30),
(1043, 'Villarrica', 30),
(1044, 'Cali', 31),
(1045, 'Alcalá', 31),
(1046, 'Andalucía', 31),
(1047, 'Ansermanuevo', 31),
(1048, 'Argelia', 31),
(1049, 'Bolívar', 31),
(1050, 'Buenaventura', 31),
(1051, 'Buga', 31),
(1052, 'Bugalagrande', 31),
(1053, 'Caicedonia', 31),
(1054, 'Calima (Darién)', 31),
(1055, 'Candelaria', 31),
(1056, 'Cartago', 31),
(1057, 'Dagua', 31),
(1058, 'El Águila', 31),
(1059, 'El Cairo', 31),
(1060, 'El Cerrito', 31),
(1061, 'El Dovio', 31),
(1062, 'Florida', 31),
(1063, 'Ginebra', 31),
(1064, 'Guacarí', 31),
(1065, 'Jamundí', 31),
(1066, 'La Cumbre', 31),
(1067, 'La Unión', 31),
(1068, 'La Victoria', 31),
(1069, 'Obando', 31),
(1070, 'Palmira', 31),
(1071, 'Pradera', 31),
(1072, 'Restrepo', 31),
(1073, 'Riofrío', 31),
(1074, 'Roldanillo', 31),
(1075, 'San Pedro', 31),
(1076, 'Sevilla', 31),
(1077, 'Toro', 31),
(1078, 'Trujillo', 31),
(1079, 'Tuluá', 31),
(1080, 'Ulloa', 31),
(1081, 'Versalles', 31),
(1082, 'Vijes', 31),
(1083, 'Yotoco', 31),
(1084, 'Yumbo', 31),
(1085, 'Zarzal', 31),
(1086, 'Mitú', 32),
(1087, 'Carurú', 32),
(1088, 'Taraira', 32),
(1089, 'Puerto Carreño', 33),
(1090, 'La Primavera', 33),
(1091, 'Santa Rosalia', 33),
(1092, 'Cumaribo', 33),
(1093, 'HONG KONG', 34),
(1094, 'HAIPHONG', 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `tradename` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rut` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `address` text COLLATE utf8_spanish_ci,
  `zip` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `connection`
--

CREATE TABLE `connection` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `agent` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `so` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`id`, `name`) VALUES
(1, 'Afghanistan'),
(2, 'Aland Islands'),
(3, 'Albania'),
(4, 'Alemania'),
(5, 'Algeria'),
(6, 'American Samoa'),
(7, 'Andorra'),
(8, 'Angola'),
(9, 'Anguilla'),
(10, 'Antarctica'),
(11, 'Antigua Y Barbuda'),
(12, 'Arabia Saudita'),
(13, 'Argentina'),
(14, 'Armenia'),
(15, 'Aruba'),
(16, 'Asia / Region Pacifico'),
(17, 'Australia'),
(18, 'Austria'),
(19, 'Azerbaijan'),
(20, 'Bahamas'),
(21, 'Bahrain'),
(22, 'Bangladesh'),
(23, 'Barbados'),
(24, 'Belarus'),
(25, 'Belgica'),
(26, 'Belice'),
(27, 'Benin'),
(28, 'Bermuda'),
(29, 'Bhutan'),
(30, 'Bolivia'),
(31, 'Bonair'),
(32, 'Bosnia And Herzegovina'),
(33, 'Botswana'),
(34, 'Brasil'),
(35, 'British Indian Ocean Territory'),
(36, 'Brunei Darussalam'),
(37, 'Bulgaria'),
(38, 'Burkina Faso'),
(39, 'Burundi'),
(40, 'Cabo Verde'),
(41, 'Camboya'),
(42, 'Camerun'),
(43, 'Canada'),
(44, 'Chad'),
(45, 'Chile'),
(46, 'China'),
(47, 'Chipre'),
(48, 'Cocos (KEELING) Islands'),
(49, 'Colombia'),
(50, 'Comoros'),
(51, 'Cong'),
(52, 'Congo'),
(53, 'Cook Islands'),
(54, 'Costa Rica'),
(55, 'Cote D\'ivoire'),
(56, 'Croacia'),
(57, 'Cuba'),
(58, 'Curacao'),
(59, 'Dinamarca'),
(60, 'Djibouti'),
(61, 'Dominica'),
(62, 'Ecuador'),
(63, 'Egipto'),
(64, 'El Salvador'),
(65, 'Emiratos Arabes Unidos'),
(66, 'Eritrea'),
(67, 'Eslovaquia'),
(68, 'Eslovenia'),
(69, 'España'),
(70, 'Estados Unidos'),
(71, 'Estonia'),
(72, 'Etiopia'),
(73, 'Faroe Islands'),
(74, 'Fiji'),
(75, 'Filipinas'),
(76, 'Finlandia'),
(77, 'Francia'),
(78, 'French Polynesia'),
(79, 'Gabon'),
(80, 'Gambia'),
(81, 'Gana'),
(82, 'Georgia'),
(83, 'Gibraltar'),
(84, 'Granada'),
(85, 'Grecia'),
(86, 'Groenlandia'),
(87, 'Guadeloupe'),
(88, 'Guam'),
(89, 'Guatemala'),
(90, 'Guernsey'),
(91, 'Guinea'),
(92, 'Guinea Ecuatorial'),
(93, 'Guinea-Bissau'),
(94, 'Guyana'),
(95, 'Guyana Francesa'),
(96, 'Haiti'),
(97, 'Holanda, Paises Bajos'),
(98, 'Holy See (VATICAN City State)'),
(99, 'Honduras'),
(100, 'Hungria'),
(101, 'India'),
(102, 'Indonesia'),
(103, 'Ira'),
(104, 'Iraq'),
(105, 'Irlanda'),
(106, 'Islandia'),
(107, 'Islas (MALVINAS)'),
(108, 'Islas Caiman'),
(109, 'Islas De Pascua'),
(110, 'Islas Salomon'),
(111, 'Isle Of Man'),
(112, 'Israel'),
(113, 'Italia'),
(114, 'Jamaica'),
(115, 'Japan'),
(116, 'Jersey'),
(117, 'Jordan'),
(118, 'Kazakhstan'),
(119, 'Kenya'),
(120, 'Kiribati'),
(121, 'Kore'),
(122, 'Kuwait'),
(123, 'Kyrgyzstan'),
(124, 'Lao People\'s Democratic Republic'),
(125, 'Latvia'),
(126, 'Lebanon'),
(127, 'Lesotho'),
(128, 'Liberia'),
(129, 'Libya'),
(130, 'Liechtenstein'),
(131, 'Lithuania'),
(132, 'Luxembourg'),
(133, 'Macau'),
(134, 'Macedonia'),
(135, 'Madagascar'),
(136, 'Malasia'),
(137, 'Malawi'),
(138, 'Maldives'),
(139, 'Mali'),
(140, 'Malta'),
(141, 'Marruecos'),
(142, 'Marshall Islands'),
(143, 'Martinique'),
(144, 'Mauritania'),
(145, 'Mauritius'),
(146, 'Mayotte'),
(147, 'Mexico'),
(148, 'Micronesi'),
(149, 'Moldov'),
(150, 'Monaco'),
(151, 'Mongolia'),
(152, 'Montenegro'),
(153, 'Montserrat'),
(154, 'Mozambique'),
(155, 'Myanmar'),
(156, 'Namibia'),
(157, 'Nauru'),
(158, 'Nepal'),
(159, 'Nicaragua'),
(160, 'Niger'),
(161, 'Nigeria'),
(162, 'Niue'),
(163, 'Norfolk Island'),
(164, 'Northern Mariana Islands'),
(165, 'Noruega'),
(166, 'Nueva Caledonia'),
(167, 'Nueva Zelandia'),
(168, 'Oman'),
(169, 'Pakistan'),
(170, 'Palau'),
(171, 'Palestina'),
(172, 'Panama'),
(173, 'Papua New Guinea'),
(174, 'Paraguay'),
(175, 'Peru'),
(176, 'Pitcairn Islands'),
(177, 'Polonia'),
(178, 'Portugal'),
(179, 'Puerto Rico'),
(180, 'Qatar'),
(181, 'Reino Unido'),
(182, 'Republica Central De Africa'),
(183, 'Republica Checa'),
(184, 'Republica Dominicana'),
(185, 'Reunion'),
(186, 'Romania'),
(187, 'Ruanda'),
(188, 'Rusia'),
(189, 'Saint Barthelemy'),
(190, 'Saint Helena'),
(191, 'Saint Kitts And Nevis'),
(192, 'Saint Pierre And Miquelon'),
(193, 'Saint Vincent And The Grenadines'),
(194, 'Samoa'),
(195, 'San Marino'),
(196, 'San Martin'),
(197, 'Santa Lucia'),
(198, 'Sao Tome And Principe'),
(199, 'Senegal'),
(200, 'Serbia'),
(201, 'Seychelles'),
(202, 'Sierra Leone'),
(203, 'Singapur'),
(204, 'Sint Maarten (DUTCH Part)'),
(205, 'Siria Republica Arabe'),
(206, 'Somalia'),
(207, 'South Georgia And The South Sandwich Islands'),
(208, 'Sri Lanka'),
(209, 'Sudafrica'),
(210, 'Sudan'),
(211, 'Sudan Del Sur'),
(212, 'Suecia'),
(213, 'Suiza'),
(214, 'Surinam'),
(215, 'Svalbard And Jan Mayen'),
(216, 'Swaziland'),
(217, 'Tailandia'),
(218, 'Taiwan'),
(219, 'Tajikistan'),
(220, 'Tanzania'),
(221, 'Timor-Leste'),
(222, 'Togo'),
(223, 'Tokelau'),
(224, 'Tonga'),
(225, 'Trinidad Y Tobago'),
(226, 'Tunisia'),
(227, 'Turkmenistan'),
(228, 'Turks And Caicos Islands'),
(229, 'Turquia'),
(230, 'Tuvalu'),
(231, 'Ucrania'),
(232, 'Uganda'),
(233, 'United States Minor Outlying Islands'),
(234, 'Uruguay'),
(235, 'Uzbekistan'),
(236, 'Vanuatu'),
(237, 'Venezuela'),
(238, 'Vietnam'),
(239, 'Virgin Island'),
(240, 'Wallis And Futuna'),
(241, 'Western Sahara'),
(242, 'Yemen'),
(243, 'Zambia'),
(244, 'Zimbabwe'),
(245, 'HONG KONG'),
(246, 'VIETNAM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit_payment`
--

CREATE TABLE `credit_payment` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `amount` decimal(65,2) DEFAULT NULL,
  `advance_supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `map_code` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `department`
--

INSERT INTO `department` (`id`, `name`, `country_id`, `map_code`) VALUES
(1, 'Bogotá', 49, NULL),
(2, 'Amazonas', 49, NULL),
(3, 'Antioquia', 49, NULL),
(4, 'Arauca', 49, NULL),
(5, 'Atlántico', 49, NULL),
(6, 'Bolívar', 49, NULL),
(7, 'Boyacá', 49, NULL),
(8, 'Caldas', 49, NULL),
(9, 'Caquetá', 49, NULL),
(10, 'Casanare', 49, NULL),
(11, 'Cauca', 49, NULL),
(12, 'Cesar', 49, NULL),
(13, 'Córdoba', 49, NULL),
(14, 'Cundinamarca', 49, NULL),
(15, 'Chocó', 49, NULL),
(16, 'Guainía', 49, NULL),
(17, 'Guaviare', 49, NULL),
(18, 'Huila', 49, NULL),
(19, 'La Guajira', 49, NULL),
(20, 'Magdalena', 49, NULL),
(21, 'Meta', 49, NULL),
(22, 'Nariño', 49, NULL),
(23, 'Norte de Santander', 49, NULL),
(24, 'Putumayo', 49, NULL),
(25, 'Quindío', 49, NULL),
(26, 'Risaralda', 49, NULL),
(27, 'San Andrés y Providencia', 49, NULL),
(28, 'Santander', 49, NULL),
(29, 'Sucre', 49, NULL),
(30, 'Tolima', 49, NULL),
(31, 'Valle del Cauca', 49, NULL),
(32, 'Vaupés', 49, NULL),
(33, 'Vichada', 49, NULL),
(34, 'HONG KONG', 245, NULL),
(35, 'QUANG NINH', 246, NULL),
(36, 'TSIMSHATSUI KOWLOON', 245, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispatch`
--

CREATE TABLE `dispatch` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `quantity` decimal(65,2) DEFAULT NULL,
  `regional_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text COLLATE utf8_spanish_ci,
  `send_address_id` int(11) NOT NULL,
  `advance_client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispatch_regional`
--

CREATE TABLE `dispatch_regional` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `quantity` decimal(65,2) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `regional_id` int(11) NOT NULL,
  `dispatch_status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reception_note` text COLLATE utf8_spanish_ci,
  `dispatch_note` text COLLATE utf8_spanish_ci,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dispatch_status`
--

CREATE TABLE `dispatch_status` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dispatch_status`
--

INSERT INTO `dispatch_status` (`id`, `name`) VALUES
(1, 'En tránsito'),
(2, 'Recibido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `general_outgo`
--

CREATE TABLE `general_outgo` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `amount` decimal(65,2) DEFAULT NULL,
  `detail` text COLLATE utf8_spanish_ci,
  `type_outgo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `method`
--

CREATE TABLE `method` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `method`
--

INSERT INTO `method` (`id`, `name`) VALUES
(1, 'De contado'),
(2, 'Crédito'),
(3, 'Anticipo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation`
--

CREATE TABLE `operation` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `operation`
--

INSERT INTO `operation` (`id`, `name`) VALUES
(1, 'Registro'),
(2, 'Edición'),
(3, 'Eliminar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `outgo`
--

CREATE TABLE `outgo` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `amount` decimal(65,2) DEFAULT NULL,
  `detail` text COLLATE utf8_spanish_ci,
  `type_outgo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `regional_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `outgo_img`
--

CREATE TABLE `outgo_img` (
  `id` int(11) NOT NULL,
  `title` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `description` text COLLATE utf8_spanish_ci,
  `file_name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `regional_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_adv_client`
--

CREATE TABLE `payment_adv_client` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `amount` decimal(65,2) DEFAULT NULL,
  `advance_client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `period`
--

CREATE TABLE `period` (
  `id` int(11) NOT NULL,
  `regional_employees_id` int(11) NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `salary` decimal(65,2) DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person_client`
--

CREATE TABLE `person_client` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person_shamble`
--

CREATE TABLE `person_shamble` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `shamble_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person_supplier`
--

CREATE TABLE `person_supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE ucs2_spanish_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reception`
--

CREATE TABLE `reception` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `quantity` decimal(65,2) DEFAULT NULL,
  `unit_price` decimal(65,2) DEFAULT NULL,
  `regional_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text COLLATE utf8_spanish_ci,
  `advance_supplier_id` int(11) DEFAULT NULL,
  `brand` text COLLATE utf8_spanish_ci,
  `supplier_id` int(11) NOT NULL,
  `method_id` int(11) NOT NULL,
  `shamble_id` int(11) NOT NULL,
  `shamble_amount` decimal(65,2) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reception_central`
--

CREATE TABLE `reception_central` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `quantity` decimal(65,2) DEFAULT NULL,
  `regional_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note_reception` text COLLATE utf8_spanish_ci,
  `dispatch_regional_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reception_img`
--

CREATE TABLE `reception_img` (
  `id` int(11) NOT NULL,
  `title` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `description` text COLLATE utf8_spanish_ci,
  `file_name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regional`
--

CREATE TABLE `regional` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `regional`
--

INSERT INTO `regional` (`id`, `name`, `city_id`, `deleted`) VALUES
(1, 'Medellín', 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regional_advances`
--

CREATE TABLE `regional_advances` (
  `id` int(11) NOT NULL,
  `amount` decimal(65,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `detail` text COLLATE utf8_spanish_ci,
  `user_id` int(11) NOT NULL,
  `regional_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regional_employees`
--

CREATE TABLE `regional_employees` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dni` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `regional_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `send_address`
--

CREATE TABLE `send_address` (
  `id` int(11) NOT NULL,
  `address` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `zip` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shamble`
--

CREATE TABLE `shamble` (
  `id` int(11) NOT NULL,
  `tradename` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rut` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `address` text COLLATE utf8_spanish_ci,
  `zip` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `tradename` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rut` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `address` text COLLATE utf8_spanish_ci,
  `zip` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT NULL,
  `precio_unitario` decimal(65,2) DEFAULT NULL,
  `month_quantity` decimal(65,2) DEFAULT NULL,
  `name_method` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rut_method` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `bankcenter_method` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `account_method` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supplier_bank`
--

CREATE TABLE `supplier_bank` (
  `id` int(11) NOT NULL,
  `bank` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `account` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rut` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `type_account` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supplier_center`
--

CREATE TABLE `supplier_center` (
  `id` int(11) NOT NULL,
  `center` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `location` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` varchar(90) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rut` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supplier_has_shamble`
--

CREATE TABLE `supplier_has_shamble` (
  `supplier_id` int(11) NOT NULL,
  `shamble_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_from`
--

CREATE TABLE `type_from` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `type_from`
--

INSERT INTO `type_from` (`id`, `name`) VALUES
(1, 'Proveedor'),
(2, 'Regional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_outgo`
--

CREATE TABLE `type_outgo` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_to`
--

CREATE TABLE `type_to` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unity`
--

CREATE TABLE `unity` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lastname` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `position` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `verify` tinyint(1) DEFAULT NULL,
  `block` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `regional_id` int(11) NOT NULL,
  `user_profile_id` int(11) NOT NULL,
  `recover_pass` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `lastname`, `position`, `phone`, `email`, `pass`, `verify`, `block`, `deleted`, `creation_date`, `regional_id`, `user_profile_id`, `recover_pass`, `fail`) VALUES
(1, 'Asistente de Configuración', NULL, NULL, NULL, 'configuracion@derivadoscarnicos.com', '$2y$10$jesFT0ExpwpkGBxuSHYGMefSQtp9JJ8oULamoDFjxvlIiy8WUWVZm', 1, 0, 0, '2018-06-11 00:00:00', 1, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_alert`
--

CREATE TABLE `user_alert` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_operation`
--

CREATE TABLE `user_operation` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `table` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_profile`
--

INSERT INTO `user_profile` (`id`, `name`) VALUES
(1, 'Socio'),
(2, 'Coordinación Administrativa'),
(3, 'Administrador Regional'),
(4, 'Colaborador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `advance_client`
--
ALTER TABLE `advance_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_advance_client_client1_idx` (`client_id`),
  ADD KEY `fk_advance_client_user1_idx` (`user_id`),
  ADD KEY `fk_advance_client_product1_idx` (`product_id`),
  ADD KEY `fk_advance_client_regional1_idx` (`regional_id`);

--
-- Indices de la tabla `advance_supplier`
--
ALTER TABLE `advance_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_advance_supplier_supplier1_idx` (`supplier_id`),
  ADD KEY `fk_advance_supplier_user1_idx` (`user_id`),
  ADD KEY `fk_advance_supplier_regional1_idx` (`regional_id`),
  ADD KEY `fk_advance_supplier_product1_idx` (`product_id`),
  ADD KEY `fk_advance_supplier_method1_idx` (`method_id`);

--
-- Indices de la tabla `brand_reception`
--
ALTER TABLE `brand_reception`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_brand_reception_reception1_idx` (`reception_id`);

--
-- Indices de la tabla `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_city_department1_idx` (`department_id`);

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_client_city1_idx` (`city_id`);

--
-- Indices de la tabla `connection`
--
ALTER TABLE `connection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_conecction_user1_idx` (`user_id`);

--
-- Indices de la tabla `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `credit_payment`
--
ALTER TABLE `credit_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_credit_payment_advance_supplier1_idx` (`advance_supplier_id`);

--
-- Indices de la tabla `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_departament_country1_idx` (`country_id`);

--
-- Indices de la tabla `dispatch`
--
ALTER TABLE `dispatch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dispatches_regional1_idx` (`regional_id`),
  ADD KEY `fk_dispatch_user1_idx` (`user_id`),
  ADD KEY `fk_dispatch_send_address1_idx` (`send_address_id`),
  ADD KEY `fk_dispatch_advance_client1_idx` (`advance_client_id`);

--
-- Indices de la tabla `dispatch_regional`
--
ALTER TABLE `dispatch_regional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dispatches_regional1_idx` (`regional_id`),
  ADD KEY `fk_dispatch_dispatch_status1_idx` (`dispatch_status_id`),
  ADD KEY `fk_dispatch_user1_idx` (`user_id`),
  ADD KEY `fk_dispatch_regional_product1_idx` (`product_id`);

--
-- Indices de la tabla `dispatch_status`
--
ALTER TABLE `dispatch_status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `general_outgo`
--
ALTER TABLE `general_outgo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_general_outgo_type_outgo1_idx` (`type_outgo_id`);

--
-- Indices de la tabla `method`
--
ALTER TABLE `method`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `outgo`
--
ALTER TABLE `outgo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_outgo_type_outgo2_idx` (`type_outgo_id`),
  ADD KEY `fk_outgo_user1_idx` (`user_id`),
  ADD KEY `fk_outgo_regional1_idx` (`regional_id`);

--
-- Indices de la tabla `outgo_img`
--
ALTER TABLE `outgo_img`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `payment_adv_client`
--
ALTER TABLE `payment_adv_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_adv_client_advance_client1_idx` (`advance_client_id`);

--
-- Indices de la tabla `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_period_regional_employees1_idx` (`regional_employees_id`);

--
-- Indices de la tabla `person_client`
--
ALTER TABLE `person_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contact_client1_idx` (`client_id`);

--
-- Indices de la tabla `person_shamble`
--
ALTER TABLE `person_shamble`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_person_shamble_shamble1_idx` (`shamble_id`);

--
-- Indices de la tabla `person_supplier`
--
ALTER TABLE `person_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_person_supplier_supplier1_idx` (`supplier_id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reception`
--
ALTER TABLE `reception`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reception_regional1_idx` (`regional_id`),
  ADD KEY `fk_reception_user1_idx` (`user_id`),
  ADD KEY `fk_reception_supplier1_idx` (`supplier_id`),
  ADD KEY `fk_reception_method1_idx` (`method_id`),
  ADD KEY `fk_reception_shamble1_idx` (`shamble_id`);

--
-- Indices de la tabla `reception_central`
--
ALTER TABLE `reception_central`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reception_regional1_idx` (`regional_id`),
  ADD KEY `fk_reception_user1_idx` (`user_id`),
  ADD KEY `fk_reception_central_dispatch_regional1_idx` (`dispatch_regional_id`);

--
-- Indices de la tabla `reception_img`
--
ALTER TABLE `reception_img`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regional`
--
ALTER TABLE `regional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_regional_city1_idx` (`city_id`);

--
-- Indices de la tabla `regional_advances`
--
ALTER TABLE `regional_advances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_regional_advances_user1_idx` (`user_id`),
  ADD KEY `fk_regional_advances_regional1_idx` (`regional_id`);

--
-- Indices de la tabla `regional_employees`
--
ALTER TABLE `regional_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_regional_employees_regional1_idx` (`regional_id`);

--
-- Indices de la tabla `send_address`
--
ALTER TABLE `send_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_send_address_city1_idx` (`city_id`),
  ADD KEY `fk_send_address_client1_idx` (`client_id`);

--
-- Indices de la tabla `shamble`
--
ALTER TABLE `shamble`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shamble_city1_idx` (`city_id`);

--
-- Indices de la tabla `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_supplier_city1_idx` (`city_id`);

--
-- Indices de la tabla `supplier_bank`
--
ALTER TABLE `supplier_bank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_supplier_bank_supplier1_idx` (`supplier_id`);

--
-- Indices de la tabla `supplier_center`
--
ALTER TABLE `supplier_center`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_supplier_center_supplier1_idx` (`supplier_id`);

--
-- Indices de la tabla `supplier_has_shamble`
--
ALTER TABLE `supplier_has_shamble`
  ADD PRIMARY KEY (`supplier_id`,`shamble_id`),
  ADD KEY `fk_supplier_has_shamble_shamble1_idx` (`shamble_id`),
  ADD KEY `fk_supplier_has_shamble_supplier1_idx` (`supplier_id`);

--
-- Indices de la tabla `type_from`
--
ALTER TABLE `type_from`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_outgo`
--
ALTER TABLE `type_outgo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_to`
--
ALTER TABLE `type_to`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unity`
--
ALTER TABLE `unity`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_regional1_idx` (`regional_id`),
  ADD KEY `fk_user_user_profile1_idx` (`user_profile_id`);

--
-- Indices de la tabla `user_alert`
--
ALTER TABLE `user_alert`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_alert_user1_idx` (`user_id`);

--
-- Indices de la tabla `user_operation`
--
ALTER TABLE `user_operation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_operation_user1_idx` (`user_id`),
  ADD KEY `fk_user_operation_operation1_idx` (`operation_id`);

--
-- Indices de la tabla `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `advance_client`
--
ALTER TABLE `advance_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `advance_supplier`
--
ALTER TABLE `advance_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `brand_reception`
--
ALTER TABLE `brand_reception`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1095;

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `connection`
--
ALTER TABLE `connection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de la tabla `credit_payment`
--
ALTER TABLE `credit_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `dispatch`
--
ALTER TABLE `dispatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dispatch_regional`
--
ALTER TABLE `dispatch_regional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dispatch_status`
--
ALTER TABLE `dispatch_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `general_outgo`
--
ALTER TABLE `general_outgo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `method`
--
ALTER TABLE `method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `operation`
--
ALTER TABLE `operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `outgo`
--
ALTER TABLE `outgo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `outgo_img`
--
ALTER TABLE `outgo_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payment_adv_client`
--
ALTER TABLE `payment_adv_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `period`
--
ALTER TABLE `period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `person_client`
--
ALTER TABLE `person_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `person_shamble`
--
ALTER TABLE `person_shamble`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `person_supplier`
--
ALTER TABLE `person_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reception`
--
ALTER TABLE `reception`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reception_central`
--
ALTER TABLE `reception_central`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reception_img`
--
ALTER TABLE `reception_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regional`
--
ALTER TABLE `regional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `regional_advances`
--
ALTER TABLE `regional_advances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regional_employees`
--
ALTER TABLE `regional_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `send_address`
--
ALTER TABLE `send_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `shamble`
--
ALTER TABLE `shamble`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `supplier_bank`
--
ALTER TABLE `supplier_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `supplier_center`
--
ALTER TABLE `supplier_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `type_from`
--
ALTER TABLE `type_from`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `type_outgo`
--
ALTER TABLE `type_outgo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `type_to`
--
ALTER TABLE `type_to`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unity`
--
ALTER TABLE `unity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `user_alert`
--
ALTER TABLE `user_alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_operation`
--
ALTER TABLE `user_operation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `advance_client`
--
ALTER TABLE `advance_client`
  ADD CONSTRAINT `fk_advance_client_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_advance_client_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_advance_client_regional1` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_advance_client_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `advance_supplier`
--
ALTER TABLE `advance_supplier`
  ADD CONSTRAINT `fk_advance_supplier_method1` FOREIGN KEY (`method_id`) REFERENCES `method` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_advance_supplier_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_advance_supplier_regional1` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_advance_supplier_supplier1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_advance_supplier_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `brand_reception`
--
ALTER TABLE `brand_reception`
  ADD CONSTRAINT `fk_brand_reception_reception1` FOREIGN KEY (`reception_id`) REFERENCES `reception` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `fk_city_departament1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_client_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `connection`
--
ALTER TABLE `connection`
  ADD CONSTRAINT `fk_conecction_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `credit_payment`
--
ALTER TABLE `credit_payment`
  ADD CONSTRAINT `fk_credit_payment_advance_supplier1` FOREIGN KEY (`advance_supplier_id`) REFERENCES `advance_supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `fk_departament_country1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dispatch`
--
ALTER TABLE `dispatch`
  ADD CONSTRAINT `fk_dispatch_advance_client1` FOREIGN KEY (`advance_client_id`) REFERENCES `advance_client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dispatch_send_address1` FOREIGN KEY (`send_address_id`) REFERENCES `send_address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dispatch_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dispatches_regional1` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dispatch_regional`
--
ALTER TABLE `dispatch_regional`
  ADD CONSTRAINT `fk_dispatch_dispatch_status10` FOREIGN KEY (`dispatch_status_id`) REFERENCES `dispatch_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dispatch_regional_product1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dispatch_user10` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dispatches_regional10` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `general_outgo`
--
ALTER TABLE `general_outgo`
  ADD CONSTRAINT `fk_general_outgo_type_outgo1` FOREIGN KEY (`type_outgo_id`) REFERENCES `type_outgo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `outgo`
--
ALTER TABLE `outgo`
  ADD CONSTRAINT `fk_outgo_regional1` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_outgo_type_outgo2` FOREIGN KEY (`type_outgo_id`) REFERENCES `type_outgo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_outgo_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `payment_adv_client`
--
ALTER TABLE `payment_adv_client`
  ADD CONSTRAINT `fk_payment_adv_client_advance_client1` FOREIGN KEY (`advance_client_id`) REFERENCES `advance_client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `period`
--
ALTER TABLE `period`
  ADD CONSTRAINT `fk_period_regional_employees1` FOREIGN KEY (`regional_employees_id`) REFERENCES `regional_employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `person_client`
--
ALTER TABLE `person_client`
  ADD CONSTRAINT `fk_contact_client1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `person_shamble`
--
ALTER TABLE `person_shamble`
  ADD CONSTRAINT `fk_person_shamble_shamble1` FOREIGN KEY (`shamble_id`) REFERENCES `shamble` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `person_supplier`
--
ALTER TABLE `person_supplier`
  ADD CONSTRAINT `fk_person_supplier_supplier1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reception_central`
--
ALTER TABLE `reception_central`
  ADD CONSTRAINT `fk_reception_central_dispatch_regional1` FOREIGN KEY (`dispatch_regional_id`) REFERENCES `dispatch_regional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reception_regional10` FOREIGN KEY (`regional_id`) REFERENCES `regional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reception_user10` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user_alert`
--
ALTER TABLE `user_alert`
  ADD CONSTRAINT `fk_user_alert_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
