-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2023 at 12:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abodmaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MessageID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `MessageText` text DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `AttachmentURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`MessageID`, `SenderID`, `ReceiverID`, `MessageText`, `Timestamp`, `AttachmentURL`) VALUES
(1, 2, 3, 'Hi Jane, I saw your design skills. Would love to collaborate!', '2023-11-25 09:53:16', NULL),
(2, 3, 2, 'Sure! Im open to collaboration. Let\'s discuss further.', '2023-11-25 09:53:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `YourNeed` varchar(50) DEFAULT NULL,
  `YourProvide` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `UserID`, `YourNeed`, `YourProvide`, `Description`) VALUES
(1, 2, 'Web Development Help', 'Graphic Design', 'Looking for assistance in front-end development'),
(2, 3, 'Graphic Design Services', 'Illustrations', 'Offering custom illustration services for projects');

-- --------------------------------------------------------

--
-- Table structure for table `reviewsratings`
--

CREATE TABLE `reviewsratings` (
  `ReviewID` int(11) NOT NULL,
  `ReviewerID` int(11) DEFAULT NULL,
  `TargetUserID` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `ReviewText` text DEFAULT NULL,
  `ReviewDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviewsratings`
--

INSERT INTO `reviewsratings` (`ReviewID`, `ReviewerID`, `TargetUserID`, `Rating`, `ReviewText`, `ReviewDate`) VALUES
(1, 2, 3, 5, 'Great user to work with!', '2023-11-25 09:51:56'),
(2, 3, 2, 4, 'Good experience overall.', '2023-11-25 09:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `RolesID` int(11) NOT NULL,
  `Name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RolesID`, `Name`) VALUES
(1, 'Admin'),
(2, 'Moderator'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `SkillID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SkillName` varchar(50) DEFAULT NULL,
  `SkillCategory` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`SkillID`, `UserID`, `SkillName`, `SkillCategory`, `Description`) VALUES
(1, 2, 'Programming', 'IT', 'Proficient in Python and JavaScript'),
(2, 3, 'Graphic Design', 'Design', 'Skilled in Adobe Photoshop and Illustrator');

-- --------------------------------------------------------

--
-- Table structure for table `skillswaprequests`
--

CREATE TABLE `skillswaprequests` (
  `RequestID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `SkillID` int(11) DEFAULT NULL,
  `RequestStatus` enum('Pending','Accepted','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skillswaprequests`
--

INSERT INTO `skillswaprequests` (`RequestID`, `SenderID`, `ReceiverID`, `SkillID`, `RequestStatus`) VALUES
(1, 2, 3, 1, 'Pending'),
(2, 3, 2, 2, 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `RolesID` int(11) NOT NULL DEFAULT 1,
  `Username` varchar(50) DEFAULT NULL,
  `PasswordHash` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `ProfilePictureURL` varchar(255) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `Bio` text DEFAULT NULL,
  `RegistrationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `RolesID`, `Username`, `PasswordHash`, `Email`, `ProfilePictureURL`, `Location`, `Bio`, `RegistrationDate`) VALUES
(1, 1, 'admin123', 'abd12345', 'admin@example.com', 'profile_pics/admin.jpg', 'New York', 'Administrator account', '2023-11-25 10:15:49'),
(2, 3, 'john_doe', 'hashed_password', 'john@example.com', 'profile_pics/john.jpg', 'California', 'Regular user', '2023-11-25 09:51:46'),
(3, 3, 'jane_smith', 'hashed_password', 'jane@example.com', 'profile_pics/jane.jpg', 'Texas', 'Another user', '2023-11-25 09:51:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `ReceiverID` (`ReceiverID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `reviewsratings`
--
ALTER TABLE `reviewsratings`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `ReviewerID` (`ReviewerID`),
  ADD KEY `TargetUserID` (`TargetUserID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RolesID`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`SkillID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `skillswaprequests`
--
ALTER TABLE `skillswaprequests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `ReceiverID` (`ReceiverID`),
  ADD KEY `SkillID` (`SkillID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `RolesID` (`RolesID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviewsratings`
--
ALTER TABLE `reviewsratings`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RolesID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `SkillID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `skillswaprequests`
--
ALTER TABLE `skillswaprequests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`ReceiverID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviewsratings`
--
ALTER TABLE `reviewsratings`
  ADD CONSTRAINT `reviewsratings_ibfk_1` FOREIGN KEY (`ReviewerID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviewsratings_ibfk_2` FOREIGN KEY (`TargetUserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skillswaprequests`
--
ALTER TABLE `skillswaprequests`
  ADD CONSTRAINT `skillswaprequests_ibfk_1` FOREIGN KEY (`SenderID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skillswaprequests_ibfk_2` FOREIGN KEY (`ReceiverID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skillswaprequests_ibfk_3` FOREIGN KEY (`SkillID`) REFERENCES `skills` (`SkillID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RolesID`) REFERENCES `roles` (`RolesID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
