-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2024. Jún 28. 09:30
-- Kiszolgáló verziója: 8.0.17
-- PHP verzió: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `products`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `menu_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `category_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `subcategory` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- A tábla adatainak kiíratása `categories`
--

INSERT INTO `categories` (`category_id`, `menu_category`, `category_name`, `subcategory`) VALUES
(1, 'Papír-Írószer', 'Füzetek', 'Vonalas'),
(2, 'Papír-Írószer', 'Írószerek', 'Toll'),
(3, 'Kreatív', 'Festékek', 'Vízfestékek'),
(6, 'Papír-Írószer', 'test2', ' altest2'),
(7, 'Papír-Írószer', 'test2', ' altest3'),
(8, 'Ajándék', 'testö', ' altest6'),
(9, 'Kreatív', 'festékek', ' altest2'),
(10, 'Kreatív', 'festékek', ' altest3'),
(12, 'Papír-Írószer', 'festékek', ' altest2'),
(13, 'Papír-Írószer', 'Írószerek', ' Toll');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `kepek` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `leiras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `subcategory` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_as_cs DEFAULT NULL,
  `visible_product` tinyint(1) DEFAULT NULL,
  `seasonal` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- A tábla adatainak kiíratása `products`
--

INSERT INTO `products` (`id`, `product_name`, `kepek`, `price`, `leiras`, `subcategory`, `visible_product`, `seasonal`) VALUES
(1, 'vonalas kék', '', 5, '<p>&Eacute;des narancs</p>', 'Vonalas', 1, 0),
(9, 'cerúza', '6675410fc3b37.jpg', 1000, NULL, 'Toll', 0, 0),
(10, 'cerúza2', '6675412364989.jpg', 1, NULL, 'Toll', 1, 1),
(11, 't', NULL, 1, NULL, 'Vonalas', NULL, NULL),
(13, 'kék toll', '667ac8f808334.jpg', 1, NULL, 'Toll', 0, 0),
(14, 'kék toll', '667ac90c721a2.jpg', 1, NULL, 'Toll', 1, 0),
(15, 'toll', '667d7768e3c81.jpg', 1, NULL, 'Toll', 0, 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `subcategory_index` (`subcategory`);

--
-- A tábla indexei `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategory` (`subcategory`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT a táblához `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`subcategory`) REFERENCES `categories` (`subcategory`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
