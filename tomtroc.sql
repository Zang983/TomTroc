-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 10 août 2024 à 02:08
-- Version du serveur : 8.0.38
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `idBook` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb3_czech_ci,
  `available` tinyint DEFAULT NULL,
  `author` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `availability` tinyint DEFAULT '1',
  `imageFilename` varchar(255) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL,
  `ownerId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`idBook`, `title`, `description`, `available`, `author`, `availability`, `imageFilename`, `createdAt`, `updatedAt`, `ownerId`) VALUES
(1, 'Dune ', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque ducimus laborum minima sed magnam, sint, quisquam quam vel, amet nihil consectetur? Hic, officiis adipisci. A consequatur saepe molestiae animi voluptatem.\r\nTemporibus excepturi nostrum reiciendis quos libero veritatis. Dolore soluta nam totam, numquam maiores, aliquam aperiam obcaecati earum laboriosam molestias corporis enim distinctio praesentium ipsam corrupti! Doloremque ea amet quos nihil?\r\nLaudantium quisquam ab asperiores, molestias aliquid deserunt at. Deserunt fugit sequi amet fuga dignissimos. Tempore corrupti perferendis illo incidunt quos dicta dignissimos eaque omnis cumque? Quo sapiente quod alias neque.\r\nNobis laboriosam dolorum vitae non aspernatur quidem corrupti aliquid debitis unde explicabo. Optio officiis, quisquam velit accusantium reiciendis, fugit enim eos tempore dolorum molestiae perspiciatis eum est explicabo. Est, in.\r\nFacilis, beatae quos? Id unde voluptate cupiditate in. Repudiandae ad, earum culpa error iste, a sint, fugiat provident optio neque dicta ut. Consequatur labore unde voluptate laudantium aliquid veniam quisquam?', NULL, 'Frank Herbert', 0, NULL, '2024-08-09 23:57:12', NULL, 1),
(2, 'Dune 2', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque ducimus laborum minima sed magnam, sint, quisquam quam vel, amet nihil consectetur? Hic, officiis adipisci. A consequatur saepe molestiae animi voluptatem.\r\nTemporibus excepturi nostrum reiciendis quos libero veritatis. Dolore soluta nam totam, numquam maiores, aliquam aperiam obcaecati earum laboriosam molestias corporis enim distinctio praesentium ipsam corrupti! Doloremque ea amet quos nihil?\r\nLaudantium quisquam ab asperiores, molestias aliquid deserunt at. Deserunt fugit sequi amet fuga dignissimos. Tempore corrupti perferendis illo incidunt quos dicta dignissimos eaque omnis cumque? Quo sapiente quod alias neque.\r\nNobis laboriosam dolorum vitae non aspernatur quidem corrupti aliquid debitis unde explicabo. Optio officiis, quisquam velit accusantium reiciendis, fugit enim eos tempore dolorum molestiae perspiciatis eum est explicabo. Est, in.\r\nFacilis, beatae quos? Id unde voluptate cupiditate in. Repudiandae ad, earum culpa error iste, a sint, fugiat provident optio neque dicta ut. Consequatur labore unde voluptate laudantium aliquid veniam quisquam?', NULL, 'Frank Herbert', 1, NULL, '2024-08-09 23:57:19', NULL, 1),
(3, 'Les enfants de Dune', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque ducimus laborum minima sed magnam, sint, quisquam quam vel, amet nihil consectetur? Hic, officiis adipisci. A consequatur saepe molestiae animi voluptatem.\r\nTemporibus excepturi nostrum reiciendis quos libero veritatis. Dolore soluta nam totam, numquam maiores, aliquam aperiam obcaecati earum laboriosam molestias corporis enim distinctio praesentium ipsam corrupti! Doloremque ea amet quos nihil?\r\nLaudantium quisquam ab asperiores, molestias aliquid deserunt at. Deserunt fugit sequi amet fuga dignissimos. Tempore corrupti perferendis illo incidunt quos dicta dignissimos eaque omnis cumque? Quo sapiente quod alias neque.\r\nNobis laboriosam dolorum vitae non aspernatur quidem corrupti aliquid debitis unde explicabo. Optio officiis, quisquam velit accusantium reiciendis, fugit enim eos tempore dolorum molestiae perspiciatis eum est explicabo. Est, in.\r\nFacilis, beatae quos? Id unde voluptate cupiditate in. Repudiandae ad, earum culpa error iste, a sint, fugiat provident optio neque dicta ut. Consequatur labore unde voluptate laudantium aliquid veniam quisquam?', NULL, 'Frank Herbert', 0, NULL, '2024-08-09 23:57:28', NULL, 1),
(4, 'Le cycle de Dune', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque ducimus laborum minima sed magnam, sint, quisquam quam vel, amet nihil consectetur? Hic, officiis adipisci. A consequatur saepe molestiae animi voluptatem.\r\nTemporibus excepturi nostrum reiciendis quos libero veritatis. Dolore soluta nam totam, numquam maiores, aliquam aperiam obcaecati earum laboriosam molestias corporis enim distinctio praesentium ipsam corrupti! Doloremque ea amet quos nihil?\r\nLaudantium quisquam ab asperiores, molestias aliquid deserunt at. Deserunt fugit sequi amet fuga dignissimos. Tempore corrupti perferendis illo incidunt quos dicta dignissimos eaque omnis cumque? Quo sapiente quod alias neque.\r\nNobis laboriosam dolorum vitae non aspernatur quidem corrupti aliquid debitis unde explicabo. Optio officiis, quisquam velit accusantium reiciendis, fugit enim eos tempore dolorum molestiae perspiciatis eum est explicabo. Est, in.\r\nFacilis, beatae quos? Id unde voluptate cupiditate in. Repudiandae ad, earum culpa error iste, a sint, fugiat provident optio neque dicta ut. Consequatur labore unde voluptate laudantium aliquid veniam quisquam?', NULL, 'Frank Herbert ', 0, NULL, '2024-08-09 23:58:04', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

CREATE TABLE `conversations` (
  `idConversation` int NOT NULL,
  `contentLastMessage` longtext COLLATE utf8mb3_czech_ci,
  `timestampLastMessage` timestamp NULL DEFAULT NULL,
  `lastOpeningUser1` timestamp NULL DEFAULT NULL,
  `lastOpeningUser2` timestamp NULL DEFAULT NULL,
  `idUser_1` int NOT NULL,
  `idUser_2` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Déchargement des données de la table `conversations`
--

INSERT INTO `conversations` (`idConversation`, `contentLastMessage`, `timestampLastMessage`, `lastOpeningUser1`, `lastOpeningUser2`, `idUser_1`, `idUser_2`) VALUES
(1, 'Oh, toi aussi tu es fan de Dune ?', '2024-08-09 23:58:15', '2024-08-10 00:06:18', '2024-08-09 23:58:15', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `idMessage` int NOT NULL,
  `content` longtext COLLATE utf8mb3_czech_ci,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `conversationId` int NOT NULL,
  `authorId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`idMessage`, `content`, `createdAt`, `conversationId`, `authorId`) VALUES
(1, 'Oh, toi aussi tu es fan de Dune ?', '2024-08-09 23:58:15', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int NOT NULL,
  `username` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `avatarFilename` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `username`, `email`, `password`, `avatarFilename`, `createdAt`, `updatedAt`) VALUES
(1, 'Jean', 'Jean@test.com', '$2y$10$KcIbTnCkgMvYix9YdangHuT/9aBKGLgLOP2DX61mGwnZrXR4F7i82', 'no-image.svg', '2024-08-09 23:55:59', NULL),
(2, 'Emeline', 'Emeline@test.com', '$2y$10$XlbzTKrrocHs39/D3Gg/L.RlfgOB1oYx.Zh.BZObrMQnNgTWHFe7K', NULL, '2024-08-09 23:57:40', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`idBook`),
  ADD KEY `fk_books_users1_idx` (`ownerId`);

--
-- Index pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`idConversation`,`idUser_1`,`idUser_2`),
  ADD KEY `fk_conversations_users1_idx` (`idUser_1`),
  ADD KEY `fk_conversations_users2_idx` (`idUser_2`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `fk_messages_conversations1_idx` (`conversationId`),
  ADD KEY `fk_messages_users1_idx` (`authorId`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `idBook` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `idConversation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `idMessage` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_users1` FOREIGN KEY (`ownerId`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `fk_conversations_users1` FOREIGN KEY (`idUser_1`) REFERENCES `users` (`idUser`),
  ADD CONSTRAINT `fk_conversations_users2` FOREIGN KEY (`idUser_2`) REFERENCES `users` (`idUser`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_conversations1` FOREIGN KEY (`conversationId`) REFERENCES `conversations` (`idConversation`),
  ADD CONSTRAINT `fk_messages_users1` FOREIGN KEY (`authorId`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
