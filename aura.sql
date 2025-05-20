-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 19, 2025 at 06:02 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aura`
--

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
CREATE TABLE IF NOT EXISTS `collections` (
  `idCollection` int NOT NULL AUTO_INCREMENT,
  `collectionName` varchar(100) NOT NULL,
  PRIMARY KEY (`idCollection`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`idCollection`, `collectionName`) VALUES
(1, 'LOUIS VUITTON'),
(2, 'BYREDO'),
(3, 'JEAN PAUL GAULTIER');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

DROP TABLE IF EXISTS `details`;
CREATE TABLE IF NOT EXISTS `details` (
  `idDetail` int NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `idOrder` int NOT NULL,
  `idPerfume` int NOT NULL,
  PRIMARY KEY (`idDetail`),
  KEY `idOrder` (`idOrder`),
  KEY `idPerfume` (`idPerfume`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
CREATE TABLE IF NOT EXISTS `discounts` (
  `idDiscount` int NOT NULL AUTO_INCREMENT,
  `reduction` decimal(5,2) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `idPerfume` int NOT NULL,
  PRIMARY KEY (`idDiscount`),
  KEY `idPerfume` (`idPerfume`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `olfactivenotes`
--

DROP TABLE IF EXISTS `olfactivenotes`;
CREATE TABLE IF NOT EXISTS `olfactivenotes` (
  `idNote` int NOT NULL AUTO_INCREMENT,
  `topNotes` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `topNotesFR` varchar(90) DEFAULT NULL,
  `middleNotes` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `middleNotesFR` varchar(100) DEFAULT NULL,
  `baseNotes` varchar(90) NOT NULL,
  `baseNotesFR` varchar(90) DEFAULT NULL,
  `idPerfume` int NOT NULL,
  PRIMARY KEY (`idNote`),
  KEY `idPerfume` (`idPerfume`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `olfactivenotes`
--

INSERT INTO `olfactivenotes` (`idNote`, `topNotes`, `topNotesFR`, `middleNotes`, `middleNotesFR`, `baseNotes`, `baseNotesFR`, `idPerfume`) VALUES
(1, 'Saffron, Bergamot', 'Safran, Bergamote', 'Leather, Cinnamon', 'Cuir, Cannelle', 'Oud, Amber', 'Oud, Ambre', 1),
(2, 'Peach, Raspberry', 'Pêche, Framboise', 'Rose, Jasmine', 'Rose, Jasmin', 'Musk, Sandalwood', 'Musc, Bois de santal', 2),
(3, 'Citrus, Ginger', 'Agrumes, Gingembre', 'Green Tea, Neroli', 'Thé vert, Néroli', 'Cedarwood, Ambroxan', 'Bois de cèdre, Ambroxan', 3),
(4, 'Cardamom, Pink Pepper', 'Cardamome, Poivre rose', 'Jasmine, Orange Blossom', 'Jasmin, Fleur d’oranger', 'Oud, Myrrh', 'Oud, Myrrhe', 4),
(5, 'Rose, Saffron', 'Rose, Safran', 'Agarwood, Geranium', 'Bois d’agar, Géranium', 'Amber, Incense', 'Ambre, Encens', 5),
(6, 'Lily of the Valley, Bergamot', 'Muguet, Bergamote', 'Magnolia, Jasmine', 'Magnolia, Jasmin', 'White Musk, Cedar', 'Musc blanc, Cèdre', 6),
(7, 'African Marigold, Bergamot', 'Souci africain, Bergamote', 'Cyclamen, Violet', 'Cyclamen, Violette', 'Cedarwood, Vetiver', 'Bois de cèdre, Vétiver', 7),
(8, 'Saffron, Juniper Berries', 'Safran, Baies de genévrier', 'Black Violet, Leather', 'Violette noire, Cuir', 'Vetiver, Blonde Woods', 'Vétiver, Bois blonds', 8),
(9, 'Ambrette, Sapodilla', 'Ambrette, Sapotille', 'Magnolia, Violet', 'Magnolia, Violette', 'Sandalwood, Cedarwood', 'Bois de santal, Bois de cèdre', 9),
(10, 'Rose, Galbanum', 'Rose, Galbanum', 'Cedar, Musk', 'Cèdre, Musc', 'Haitian Vetiver, Amber', 'Vétiver haïtien, Ambre', 10),
(11, 'Blackcurrant, Sichuan Pepper', 'Cassis, Poivre de Sichuan', 'Osmanthus, Patchouli', 'Osmanthus, Patchouli', 'Dark Amber, Vanilla', 'Ambre noir, Vanille', 11),
(12, 'Juniper, Bergamot', 'Genévrier, Bergamote', 'Black Tea, Leather', 'Thé noir, Cuir', 'Birch Tar, Amber', 'Goudron de bouleau, Ambre', 12),
(13, 'Cardamom, Mint', 'Cardamome, Menthe', 'Iris, Lavender', 'Iris, Lavande', 'Vanilla, Woodsy Notes', 'Vanille, Notes boisées', 13),
(14, 'Pear, Mint', 'Poire, Menthe', 'Lavender, Cinnamon', 'Lavande, Cannelle', 'Vanilla, Amber', 'Vanille, Ambre', 14),
(15, 'Bergamot, Clary Sage', 'Bergamote, Sauge sclarée', 'Tobacco, Tonka Bean', 'Tabac, Fève tonka', 'Amber, Sandalwood', 'Ambre, Bois de santal', 15),
(16, 'Orange Blossom, Bergamot', 'Fleur d’oranger, Bergamote', 'Jasmine, Solar Notes', 'Jasmin, Notes solaires', 'Vanilla, Amber', 'Vanille, Ambre', 16),
(17, 'Gardenia, Honey', 'Gardénia, Miel', 'Orange Blossom, Jasmine', 'Fleur d’oranger, Jasmin', 'Caramel, Patchouli', 'Caramel, Patchouli', 17),
(18, 'Cinnamon, Bergamot', 'Cannelle, Bergamote', 'Lavender, Cardamom', 'Lavande, Cardamome', 'Vanilla, Amber, Benzoin', 'Vanille, Ambre, Benjoin', 18);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `idOrder` int NOT NULL AUTO_INCREMENT,
  `orderDate` datetime NOT NULL,
  `orderStatus` enum('Pending','Shipped','Delivered') NOT NULL,
  `orderAddress` text NOT NULL,
  `idUser` int NOT NULL,
  PRIMARY KEY (`idOrder`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perfumeimage`
--

DROP TABLE IF EXISTS `perfumeimage`;
CREATE TABLE IF NOT EXISTS `perfumeimage` (
  `idImage` int NOT NULL AUTO_INCREMENT,
  `urlImage` varchar(255) NOT NULL,
  `urlHover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `idPerfume` int NOT NULL,
  PRIMARY KEY (`idImage`),
  KEY `idPerfume` (`idPerfume`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `perfumeimage`
--

INSERT INTO `perfumeimage` (`idImage`, `urlImage`, `urlHover`, `idPerfume`) VALUES
(1, '1.jpg', '1-1.jpg', 1),
(2, '2.jpg', '2-2.jpg', 2),
(3, '3.jpg', '3-3.jpg', 3),
(4, '4.jpg', '4-4.jpg', 4),
(5, '5.jpg', '5-5.jpg', 5),
(6, '6.jpg', '6-6.jpg', 6),
(7, '7.jpg', '7-7.jpg', 7),
(8, '8.jpg', '8-8.jpg', 8),
(9, '9.jpg', '9-9.jpg', 9),
(10, '10.jpg', '10-10.jpg', 10),
(11, '11.jpg', '11-11.jpg', 11),
(12, '12.jpg', '12-12.jpg', 12),
(13, '13.jpg', '13-13.jpg', 13),
(14, '14.jpg', '14-14.jpg', 14),
(15, '15.jpg', '15-15.jpg', 15),
(16, '16.jpg', '16-16.jpg', 16),
(17, '17.jpg', '17-17.jpg', 17),
(18, '18.jpg', '18-18.jpg', 18);

-- --------------------------------------------------------

--
-- Table structure for table `perfumes`
--

DROP TABLE IF EXISTS `perfumes`;
CREATE TABLE IF NOT EXISTS `perfumes` (
  `idPerfume` int NOT NULL AUTO_INCREMENT,
  `perfumeName` varchar(100) NOT NULL,
  `description` text,
  `descriptionFR` text,
  `price` decimal(10,2) NOT NULL,
  `stockQuantity` int NOT NULL,
  `gender` enum('Male','Female','Unisex') NOT NULL,
  `fragranceFamily` varchar(50) DEFAULT NULL,
  `fragranceFamilyFR` varchar(50) DEFAULT NULL,
  `season` varchar(50) DEFAULT NULL,
  `seasonFR` varchar(50) DEFAULT NULL,
  `addDate` datetime NOT NULL,
  `idCollection` int DEFAULT NULL,
  PRIMARY KEY (`idPerfume`),
  KEY `idCollection` (`idCollection`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `perfumes`
--

INSERT INTO `perfumes` (`idPerfume`, `perfumeName`, `description`, `descriptionFR`, `price`, `stockQuantity`, `gender`, `fragranceFamily`, `fragranceFamilyFR`, `season`, `seasonFR`, `addDate`, `idCollection`) VALUES
(1, 'Nouveau Monde', 'A bold and adventurous fragrance that blends the deep warmth of oud with spicy leather and a burst of fresh bergamot. Inspired by the spirit of exploration, it evokes distant lands and untold stories. Perfect for those who dare to be different and live without boundaries. Long-lasting and intense, it wraps the wearer in a mysterious aura. Ideal for evenings and special occasions.', 'Un parfum audacieux et aventureux mêlant la chaleur du oud à des notes épicées de cuir et une touche fraîche de bergamote. Inspiré par l’esprit d’exploration, il évoque des terres lointaines et des récits mystérieux. Parfait pour ceux qui osent vivre sans limites, avec une tenue intense et envoûtante. Idéal pour les soirées et les occasions spéciales.', 280.00, 50, 'Unisex', 'Woody Leather', 'Boisé Cuiré', 'All Year', 'Toute l\'année', '2025-05-13 18:14:39', 1),
(2, 'Heures d\'Absence', 'A delicate and poetic floral fragrance that evokes the sensation of a dreamy escape into a field of blooming flowers. It opens with juicy peach and raspberry, followed by a bouquet of rose and jasmine. The base of soft musk and creamy sandalwood leaves a romantic and airy trail. Perfect for spring days and moments of introspection. A scent that whispers elegance and femininity.', 'Un parfum floral délicat et poétique qui évoque un rêve éveillé au milieu d’un champ en fleurs. Il s’ouvre sur la pêche et la framboise, suivies d’un cœur de rose et de jasmin. La base de musc doux et de bois de santal laisse un sillage romantique et aérien. Parfait pour le printemps et les moments d’évasion.', 240.00, 75, 'Female', 'Floral', 'Floral', 'Spring, Summer', 'Printemps, Été', '2025-05-13 18:14:39', 1),
(3, 'Imagination', 'A fresh and vibrant scent designed to awaken the imagination and energize the soul. It opens with zesty citrus and spicy ginger, then evolves into the green elegance of neroli and tea. A base of ambroxan and cedarwood ensures depth and sophistication. Ideal for creative minds and everyday wear, it brings a modern twist to classic freshness. Clean, uplifting, and full of light.', 'Un parfum frais et vibrant qui éveille la créativité. Il commence par des agrumes éclatants et du gingembre épicé, évolue vers le thé vert et le néroli. La base de cèdre et d’ambroxan apporte élégance et modernité. Idéal pour un usage quotidien, dynamique et lumineux.', 260.00, 60, 'Male', 'Citrus Aromatic', 'Agrumes Aromatique', 'Spring, Summer', 'Printemps, Été', '2025-05-13 18:14:39', 1),
(4, 'Fleur du Desert', 'An exotic floral fragrance inspired by the mysterious beauty of desert blooms. Cardamom and pink pepper add spice, leading into a lush heart of jasmine and orange blossom. The dry down reveals smoky oud and rich myrrh, creating a warm, sensual experience. A perfect scent for cold seasons or special evenings. Captivating and opulent, it leaves a lasting impression.', 'Un parfum floral exotique inspiré par la beauté mystérieuse des fleurs du désert. Cardamome et poivre rose apportent du piquant, suivis par un cœur de jasmin et de fleur d’oranger. Le fond révèle un oud fumé et une myrrhe riche pour une expérience sensuelle et enveloppante.', 270.00, 45, 'Female', 'Floral Oriental', 'Floral Oriental', 'Fall, Winter', 'Automne, Hiver', '2025-05-13 18:14:39', 1),
(5, 'Ombre Nomade', 'A deep and intense fragrance for those who seek mystery and power. Rose and saffron open the scent with dark floral spice, while agarwood and geranium build a rich heart. Amber and incense dominate the base, wrapping the skin in an aura of luxury. Ideal for confident personalities and nighttime wear. It is seductive, bold, and undeniably luxurious.', 'Un parfum profond et intense qui évoque le mystère. L’ouverture mêle rose et safran, suivie d’un cœur boisé d’agarwood et de géranium. Le fond chaud et résineux d’ambre et d’encens laisse un sillage envoûtant et puissant.', 320.00, 40, 'Unisex', 'Woody Oriental', 'Boisé Oriental', 'Fall, Winter', 'Automne, Hiver', '2025-05-13 18:15:39', 1),
(6, 'Apogée', 'A luminous floral bouquet that captures the gentle elegance of springtime. With lily of the valley and bergamot at the top, it blooms into magnolia and jasmine. A soft base of white musk and cedarwood adds balance and comfort. This fragrance evokes purity, serenity, and fresh beginnings. A beautiful companion for daylight and calm moments.', 'Un bouquet floral lumineux qui incarne la pureté et l’élégance du printemps. Muguet et bergamote ouvrent la composition, suivis par un cœur de magnolia et de jasmin. Le fond doux de musc blanc et de cèdre apporte une touche délicate.', 250.00, 55, 'Female', 'Floral', 'Floral', 'Spring, Summer', 'Printemps, Été', '2025-05-13 18:15:39', 1),
(7, 'Bal d\'Afrique', 'A joyful and radiant fragrance inspired by the rhythms and colors of Africa. Opening with African marigold and bergamot, it reveals heart notes of violet and cyclamen. The base of vetiver and Moroccan cedarwood adds depth and sensuality. It’s a warm, sunny scent full of vitality and culture. Perfect for spring, summer, and unforgettable adventures.', 'Un parfum solaire et vibrant inspiré par les paysages africains. Le souci africain et la bergamote ouvrent sur un cœur floral doux de violette et de cyclamen. Le fond boisé chaud de cèdre et vétiver enrobe la peau avec sensualité.', 220.00, 60, 'Unisex', 'Floral Woody', 'Floral Boisé', 'Spring, Summer', 'Printemps, Été', '2025-05-13 18:19:11', 2),
(8, 'Black Saffron', 'A daring and captivating fragrance that fuses contrasts into a harmonious whole. Saffron and juniper berries spark the opening, while black violet and leather deepen the heart. A smoky, woody base of vetiver and blond woods anchors the composition. Bold and modern, this scent celebrates individuality. Ideal for those who stand out in a crowd.', 'Un parfum contrasté et audacieux. Le safran épicé et les baies de genévrier s’ouvrent sur un cœur sombre de violette noire et de cuir. Le fond boisé et fumé de vétiver et bois blonds crée une signature unique.', 240.00, 45, 'Unisex', 'Spicy Woody', 'Épicé Boisé', 'Fall, Winter', 'Automne, Hiver', '2025-05-13 18:19:11', 2),
(9, 'Mojave Ghost', 'An elusive and airy fragrance inspired by the desert’s soft winds and rare flora. Ambrette and sapodilla give an unusual fruity-floral lift, followed by a graceful heart of magnolia and violet. Sandalwood and cedarwood enrich the base with warmth. Ethereal yet grounded, it is ideal for all-year wear. A gentle and mysterious companion for the soul.', 'Une fragrance aérienne et mystérieuse inspirée du désert. Ambrette et sapotille ouvrent la danse, suivis d’un cœur floral de magnolia et violette. Le fond chaud de bois de santal et de cèdre offre une sensation douce et profonde.', 230.00, 50, 'Unisex', 'Floral Woody', 'Floral Boisé', 'All Year', 'Toute l\'année', '2025-05-13 18:19:11', 2),
(10, 'Super Cedar', 'A minimalist yet expressive woody scent that highlights the strength of simplicity. It starts with fresh rose petals and green galbanum, settling into the warmth of cedarwood and musk. Haitian vetiver and amber form the base, leaving a dry, smoky trail. Clean, natural, and deeply refined. Perfect for lovers of straightforward elegance.', 'Un parfum minimaliste et élégant axé sur la noblesse du cèdre. Les pétales de rose et le galbanum ouvrent la fragrance, avant de laisser place à un cœur de bois de cèdre et musc. Le fond mêle vétiver haïtien et ambre pour un effet boisé sec.', 210.00, 55, 'Unisex', 'Woody', 'Boisé', 'Fall, Winter', 'Automne, Hiver', '2025-05-13 18:19:11', 2),
(11, 'Rouge Chaotique', 'A luxurious extrait de parfum that radiates intensity and sensuality. It begins with bold blackcurrant and Sichuan pepper, flows into a heart of osmanthus and patchouli, and finishes with dark amber and sweet vanilla. Rich, spicy, and hypnotic, it lingers long after application. A powerful scent for bold personalities. Ideal for evening and winter wear.', 'Un extrait riche et intense aux notes fruitées et ambrées. Cassis et poivre de Sichuan s’ouvrent sur un cœur d’osmanthus et de patchouli. Le fond de vanille noire et d’ambre profond donne un caractère enveloppant et puissant.', 280.00, 35, 'Unisex', 'Amber Spicy', 'Ambré Épicé', 'Fall, Winter', 'Automne, Hiver', '2025-05-13 18:19:11', 2),
(12, 'Sellier', 'A smoky and aromatic leather scent reminiscent of classic English saddlery. Juniper and bergamot offer freshness, while black tea and leather dominate the heart. The drydown of birch tar and amber creates an earthy, smoky character. Masculine, timeless, and elegant. Perfect for formal wear or cooler days.', 'Un cuir fumé et raffiné qui évoque l’élégance des selles anglaises. Genévrier et bergamote ouvrent sur un cœur de thé noir et de cuir. Le fond de goudron de bouleau et d’ambre offre une touche rustique et noble.', 260.00, 40, 'Unisex', 'Leather Woody', 'Cuir Boisé', 'Fall, Winter', 'Automne, Hiver', '2025-05-15 17:00:00', 2),
(13, 'Le Male Le Parfum', 'A bold reinterpretation of the original Le Male, this parfum version is deeper and more mysterious. It opens with spicy cardamom and fresh mint, transitions into iris and lavender, and ends on a warm blend of vanilla and woods. Both modern and timeless, this scent speaks to strong personalities. Long-lasting and seductive, perfect for night.', 'Une version plus intense du classique Le Male. Cardamome et menthe ouvrent le parfum, suivis par un cœur poudré d’iris et de lavande. Le fond de vanille et bois chauds donne une longue tenue et un caractère envoûtant.', 125.00, 50, 'Male', 'Oriental Fougère', 'Oriental Fougère', 'Fall, Winter', 'Automne, Hiver', '2025-05-15 18:00:00', 3),
(14, 'Ultra Male', 'An ultra-sensual composition made for seduction. Juicy pear and cool mint open the scent, followed by aromatic lavender and spicy cinnamon. The vanilla and amber base leaves a smooth, addictive trail. Bold, sweet, and youthful. A true statement fragrance for bold evenings and magnetic charm.', 'Un parfum ultra-séduisant qui marie fraîcheur et gourmandise. Poire juteuse et menthe s’ouvrent sur un cœur lavande-cannelle. Le fond vanillé et ambré laisse un sillage intense et addictif.', 110.00, 65, 'Male', 'Fruity Oriental', 'Fruité Oriental', 'All Year', 'Toute l\'année', '2025-05-15 18:00:00', 3),
(15, 'Scandal Pour Homme', 'A modern masculine fragrance that fuses tradition and rebellion. It begins with fresh bergamot and sage, moves through tobacco and creamy tonka bean, and settles into amber and sandalwood. Warm and full-bodied, it captures attention instantly. Ideal for winter nights and strong personalities. Intense yet comforting.', 'Une fragrance masculine audacieuse avec des notes miellées et boisées. Bergamote et sauge s’ouvrent sur un cœur de tabac et fève tonka. Le fond d’ambre et de bois de santal donne une touche chaleureuse et puissante.', 95.00, 70, 'Male', 'Amber Woody', 'Ambré Boisé', 'Fall, Winter', 'Automne, Hiver', '2025-05-15 18:00:00', 3),
(16, 'Gaultier Divine', 'A radiant and feminine fragrance wrapped in a couture spirit. Orange blossom and bergamot sparkle at the top, leading into a heart of jasmine and solar notes. The base of vanilla and amber gives a sweet, warm finish. Elegant, luminous, and confident. Perfect for daytime glamour and sunny celebrations.', 'Un parfum féminin éclatant dans un flacon inspiré de la haute couture. Fleur d’oranger et bergamote ouvrent sur un cœur de jasmin et notes solaires. Le fond vanillé et ambré ajoute douceur et profondeur.', 120.00, 55, 'Female', 'Floral Oriental', 'Floral Oriental', 'All Year', 'Toute l\'année', '2025-05-15 18:00:00', 3),
(17, 'Scandal Le Parfum', 'A gourmand and floral masterpiece that blends innocence and sensuality. Gardenia and honey create a luminous opening, followed by orange blossom and jasmine. The caramel and patchouli base offers indulgence and mystery. Sweet, bold, and ultra-feminine. Ideal for fall evenings and elegant events.', 'Un gourmand floral ultra-féminin. Le miel et le gardénia ouvrent la fragrance, suivis par un cœur de jasmin et fleur d’oranger. Le fond de caramel et patchouli est sucré, enveloppant et très séduisant.', 115.00, 60, 'Female', 'Floral Gourmand', 'Floral Gourmand', 'Fall, Winter', 'Automne, Hiver', '2025-05-15 18:00:00', 3),
(18, 'Le Male Elixir', 'An intense and spicy fragrance that redefines the classic Le Male style. Cinnamon and bergamot shine in the opening, leading to a heart of lavender and cardamom. The base is rich with vanilla, amber, and benzoin, creating a sweet and powerful trail. Deep, long-lasting, and seductive. A bold choice for cold weather.', 'Une interprétation riche et épicée du Le Male classique. La cannelle et la bergamote ouvrent sur un cœur aromatique de lavande et cardamome. Le fond chaleureux de vanille, ambre et benjoin assure une tenue longue et intense.', 130.00, 45, 'Male', 'Spicy Oriental', 'Oriental Épicé', 'Fall, Winter', 'Automne, Hiver', '2025-05-15 18:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `idReview` int NOT NULL AUTO_INCREMENT,
  `mark` int NOT NULL,
  `comment` text,
  `reviewDate` datetime NOT NULL,
  `idUser` int NOT NULL,
  `idPerfume` int NOT NULL,
  PRIMARY KEY (`idReview`),
  KEY `idUser` (`idUser`),
  KEY `idPerfume` (`idPerfume`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `userAdress` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `subscriptionDate` datetime NOT NULL,
  `resetToken` varchar(255) DEFAULT NULL,
  `tokenDate` datetime DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `idwish` int NOT NULL AUTO_INCREMENT,
  `addDate` datetime NOT NULL,
  `idPerfume` int NOT NULL,
  `idUser` int NOT NULL,
  PRIMARY KEY (`idwish`),
  UNIQUE KEY `unique_wishlist` (`idUser`,`idPerfume`),
  KEY `idPerfume` (`idPerfume`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `fk_details_order` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`idOrder`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_details_perfume` FOREIGN KEY (`idPerfume`) REFERENCES `perfumes` (`idPerfume`) ON DELETE CASCADE;

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `fk_discounts_perfume` FOREIGN KEY (`idPerfume`) REFERENCES `perfumes` (`idPerfume`) ON DELETE CASCADE;

--
-- Constraints for table `olfactivenotes`
--
ALTER TABLE `olfactivenotes`
  ADD CONSTRAINT `fk_olfactivenotes_perfume` FOREIGN KEY (`idPerfume`) REFERENCES `perfumes` (`idPerfume`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE;

--
-- Constraints for table `perfumeimage`
--
ALTER TABLE `perfumeimage`
  ADD CONSTRAINT `fk_perfumeimage_perfume` FOREIGN KEY (`idPerfume`) REFERENCES `perfumes` (`idPerfume`) ON DELETE CASCADE;

--
-- Constraints for table `perfumes`
--
ALTER TABLE `perfumes`
  ADD CONSTRAINT `fk_perfumes_collection` FOREIGN KEY (`idCollection`) REFERENCES `collections` (`idCollection`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_perfume` FOREIGN KEY (`idPerfume`) REFERENCES `perfumes` (`idPerfume`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_perfume` FOREIGN KEY (`idPerfume`) REFERENCES `perfumes` (`idPerfume`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
