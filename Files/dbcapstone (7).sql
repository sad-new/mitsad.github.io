-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2018 at 07:31 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbcapstone`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `accountID` int(11) NOT NULL,
  `userName` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `userType` varchar(45) DEFAULT NULL,
  `themeID_Accounts` int(11) DEFAULT NULL,
  `accountImage` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`accountID`, `userName`, `password`, `userType`, `themeID_Accounts`, `accountImage`) VALUES
(3, 'admin', 'admin', 'schoolAdministrator', NULL, NULL),
(4, 'teacher', 'teacher', 'teacher', NULL, NULL),
(5, 'teacher2', 'teacher2', 'teacher', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `classID` int(11) NOT NULL,
  `className` varchar(45) DEFAULT NULL,
  `sectionID_Classes` int(11) NOT NULL,
  `syTermID_Start_Classes` int(11) DEFAULT NULL,
  `gradeLevelID_Classes` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=big5;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`classID`, `className`, `sectionID_Classes`, `syTermID_Start_Classes`, `gradeLevelID_Classes`) VALUES
(3, NULL, 7, 9, 1),
(4, NULL, 7, 13, 1),
(5, NULL, 10, 9, 2),
(6, NULL, 8, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `classstudents`
--

CREATE TABLE IF NOT EXISTS `classstudents` (
  `classStudentID` int(11) NOT NULL,
  `classID_ClassStudents` int(11) NOT NULL,
  `studentLRN` varchar(45) DEFAULT NULL,
  `studentName` varchar(45) DEFAULT NULL,
  `studentGender` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classstudents`
--

INSERT INTO `classstudents` (`classStudentID`, `classID_ClassStudents`, `studentLRN`, `studentName`, `studentGender`) VALUES
(1, 3, '1111111', 'FIRSTTEST', 'M'),
(2, 3, '2222222', 'SECONDTEST', 'M'),
(3, 3, '3333333', 'THIRDTEST', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `classsubjects`
--

CREATE TABLE IF NOT EXISTS `classsubjects` (
  `classSubjectID` int(11) NOT NULL,
  `subjectID_ClassSubjects` int(11) DEFAULT NULL,
  `classID_ClassSubjects` int(11) DEFAULT NULL,
  `teacherID_ClassSubjects` int(11) DEFAULT NULL,
  `syTermID_ClassSubjects` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classsubjects`
--

INSERT INTO `classsubjects` (`classSubjectID`, `subjectID_ClassSubjects`, `classID_ClassSubjects`, `teacherID_ClassSubjects`, `syTermID_ClassSubjects`) VALUES
(1, 3, 3, 2, 9),
(6, 5, 3, 3, 9),
(13, 3, 3, 2, 10),
(14, 6, 5, 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `employeeID` int(11) NOT NULL,
  `accountID_Employees` int(11) NOT NULL,
  `employeeName` varchar(45) DEFAULT NULL,
  `employeeAddress` varchar(100) NOT NULL,
  `employeePhoneNumber` varchar(45) NOT NULL,
  `employeeEmail` varchar(100) NOT NULL,
  `dateEntered` datetime DEFAULT NULL,
  `employeeImage` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employeeID`, `accountID_Employees`, `employeeName`, `employeeAddress`, `employeePhoneNumber`, `employeeEmail`, `dateEntered`, `employeeImage`) VALUES
(2, 4, 'teacher', '', '', '', NULL, NULL),
(3, 5, 'teacher2', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gradeentries`
--

CREATE TABLE IF NOT EXISTS `gradeentries` (
  `gradeEntryID` int(11) NOT NULL,
  `gradeSheetID_GradeEntries` int(11) DEFAULT NULL,
  `classStudentID_GradeEntries` int(11) NOT NULL,
  `gradeEntryMark` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gradelevels`
--

CREATE TABLE IF NOT EXISTS `gradelevels` (
  `gradeLevelID` int(11) NOT NULL,
  `gradeLevelNumber` varchar(45) DEFAULT NULL,
  `gradeLevelDivision` varchar(45) DEFAULT NULL,
  `gradeLevelName` varchar(45) DEFAULT NULL,
  `gradeLevelVersion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gradelevels`
--

INSERT INTO `gradelevels` (`gradeLevelID`, `gradeLevelNumber`, `gradeLevelDivision`, `gradeLevelName`, `gradeLevelVersion`) VALUES
(1, '1', 'Grade School', 'Grade 1', '1'),
(2, '2', 'Grade School', 'Grade 2', '1'),
(3, '3', 'Grade School', 'Grade 3', '1'),
(4, '4', 'Grade School', 'Grade 4', '1'),
(5, '5', 'Grade School', 'Grade 5', '1'),
(6, '5', 'Grade School', 'Grade 6', '1'),
(7, '7', 'Junior High School', 'Grade 7', '1'),
(8, '8', 'Junior High School', 'Grade 8', '1'),
(9, '9', 'Junior High School', 'Grade 9', '1'),
(10, '10', 'Junior High School', 'Grade 10', '1'),
(11, '11', 'Senior High School', 'Grade 11', '1'),
(12, '12', 'Senior High School', 'Grade 12', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gradesheetcomponents`
--

CREATE TABLE IF NOT EXISTS `gradesheetcomponents` (
  `gradeSheetComponentID` int(11) NOT NULL,
  `gradeSheetID_GradeSheetComponents` int(11) NOT NULL,
  `componentName` varchar(45) DEFAULT NULL,
  `componentValue` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gradesheets`
--

CREATE TABLE IF NOT EXISTS `gradesheets` (
  `gradeSheetID` int(11) NOT NULL,
  `classSubjectID_GradeSheets` int(11) DEFAULT NULL,
  `accountID_GradeSheets` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `reportID` int(11) NOT NULL,
  `accountID_Reports` int(11) DEFAULT NULL,
  `reportType` varchar(45) DEFAULT NULL,
  `reportDateIssued` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `sectionID` int(11) NOT NULL,
  `sectionName` varchar(45) DEFAULT NULL,
  `sectionYearLevel` int(11) DEFAULT NULL,
  `gradeLevelID_Sections` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`sectionID`, `sectionName`, `sectionYearLevel`, `gradeLevelID_Sections`) VALUES
(7, 'MANGGA', NULL, 1),
(8, 'KAHEL', NULL, 1),
(9, 'ARATILIS', NULL, 1),
(10, 'MALUNGGAY', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `subjectID` int(11) NOT NULL,
  `subjectName` varchar(45) DEFAULT NULL,
  `subjectGroup` varchar(45) DEFAULT NULL,
  `subjectYearLevel` int(11) DEFAULT NULL,
  `subjectDateIssued` datetime DEFAULT NULL,
  `gradeLevelID_Subjects` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjectID`, `subjectName`, `subjectGroup`, `subjectYearLevel`, `subjectDateIssued`, `gradeLevelID_Subjects`) VALUES
(3, 'MATH 1', NULL, NULL, NULL, 1),
(4, 'SCIENCE 1', NULL, NULL, NULL, 1),
(5, 'ENGLISH 1', NULL, NULL, NULL, 1),
(6, 'MATH 2', NULL, NULL, NULL, 2),
(7, 'SCIENCE 2', NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `syterms`
--

CREATE TABLE IF NOT EXISTS `syterms` (
  `syTermID` int(11) NOT NULL,
  `schoolYear` year(4) DEFAULT NULL,
  `termNumber` int(11) DEFAULT NULL,
  `termStart` date DEFAULT NULL,
  `termEnd` date DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `syterms`
--

INSERT INTO `syterms` (`syTermID`, `schoolYear`, `termNumber`, `termStart`, `termEnd`, `isActive`) VALUES
(9, 2018, 1, NULL, NULL, 1),
(10, 2018, 2, NULL, NULL, 0),
(11, 2018, 3, NULL, NULL, 0),
(12, 2018, 4, NULL, NULL, 0),
(13, 2019, 1, NULL, NULL, 0),
(14, 2019, 2, NULL, NULL, 0),
(15, 2019, 3, NULL, NULL, 0),
(16, 2019, 4, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classID`), ADD KEY `sectinID_Class_idx` (`sectionID_Classes`), ADD KEY `syTermID_Start_idx` (`syTermID_Start_Classes`), ADD KEY `gradeLevelID_Class_idx` (`gradeLevelID_Classes`);

--
-- Indexes for table `classstudents`
--
ALTER TABLE `classstudents`
  ADD PRIMARY KEY (`classStudentID`), ADD KEY `classID_ClasList_idx` (`classID_ClassStudents`);

--
-- Indexes for table `classsubjects`
--
ALTER TABLE `classsubjects`
  ADD PRIMARY KEY (`classSubjectID`), ADD KEY `classID_ClassSubject_idx` (`classID_ClassSubjects`), ADD KEY `adviserID_ClassSubject_idx` (`teacherID_ClassSubjects`), ADD KEY `subjectID_ClassSubjects_idx` (`subjectID_ClassSubjects`), ADD KEY `syTermID_Start_idx` (`syTermID_ClassSubjects`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employeeID`), ADD KEY `accountID_Employees_idx` (`accountID_Employees`);

--
-- Indexes for table `gradeentries`
--
ALTER TABLE `gradeentries`
  ADD PRIMARY KEY (`gradeEntryID`), ADD KEY `classListID_idx` (`classStudentID_GradeEntries`), ADD KEY `gradeSheetID` (`gradeSheetID_GradeEntries`);

--
-- Indexes for table `gradelevels`
--
ALTER TABLE `gradelevels`
  ADD PRIMARY KEY (`gradeLevelID`);

--
-- Indexes for table `gradesheetcomponents`
--
ALTER TABLE `gradesheetcomponents`
  ADD PRIMARY KEY (`gradeSheetComponentID`), ADD KEY `gradeSheetID_GradeSheet_idx` (`gradeSheetID_GradeSheetComponents`);

--
-- Indexes for table `gradesheets`
--
ALTER TABLE `gradesheets`
  ADD PRIMARY KEY (`gradeSheetID`), ADD KEY `classSubjectID_GradeSheet_idx` (`classSubjectID_GradeSheets`), ADD KEY `accountID_GradeSheet_idx` (`accountID_GradeSheets`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportID`), ADD KEY `accountID_Reports_idx` (`accountID_Reports`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`sectionID`), ADD KEY `gradeLevelID_Sections_idx` (`gradeLevelID_Sections`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjectID`), ADD KEY `gradeLevelID_Subjects_idx` (`gradeLevelID_Subjects`);

--
-- Indexes for table `syterms`
--
ALTER TABLE `syterms`
  ADD PRIMARY KEY (`syTermID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `classID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `classstudents`
--
ALTER TABLE `classstudents`
  MODIFY `classStudentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `classsubjects`
--
ALTER TABLE `classsubjects`
  MODIFY `classSubjectID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `gradeentries`
--
ALTER TABLE `gradeentries`
  MODIFY `gradeEntryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gradelevels`
--
ALTER TABLE `gradelevels`
  MODIFY `gradeLevelID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `gradesheetcomponents`
--
ALTER TABLE `gradesheetcomponents`
  MODIFY `gradeSheetComponentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gradesheets`
--
ALTER TABLE `gradesheets`
  MODIFY `gradeSheetID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `sectionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subjectID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `syterms`
--
ALTER TABLE `syterms`
  MODIFY `syTermID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
ADD CONSTRAINT `gradeLevelID_Class` FOREIGN KEY (`gradeLevelID_Classes`) REFERENCES `gradelevels` (`gradeLevelID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `sectionID_Class` FOREIGN KEY (`sectionID_Classes`) REFERENCES `sections` (`sectionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `syTermID_Start` FOREIGN KEY (`syTermID_Start_Classes`) REFERENCES `syterms` (`syTermID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `classstudents`
--
ALTER TABLE `classstudents`
ADD CONSTRAINT `classID_ClasList` FOREIGN KEY (`classID_ClassStudents`) REFERENCES `classes` (`classID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `classsubjects`
--
ALTER TABLE `classsubjects`
ADD CONSTRAINT `adviserID_ClassSubjects` FOREIGN KEY (`teacherID_ClassSubjects`) REFERENCES `employees` (`employeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `classID_ClassSubjects` FOREIGN KEY (`classID_ClassSubjects`) REFERENCES `classes` (`classID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `subjectID_ClassSubjects` FOREIGN KEY (`subjectID_ClassSubjects`) REFERENCES `subjects` (`subjectID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `syTermID_ClassSubjects` FOREIGN KEY (`syTermID_ClassSubjects`) REFERENCES `syterms` (`syTermID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
ADD CONSTRAINT `accountID_Employees` FOREIGN KEY (`accountID_Employees`) REFERENCES `accounts` (`accountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `gradeentries`
--
ALTER TABLE `gradeentries`
ADD CONSTRAINT `classStudentID` FOREIGN KEY (`classStudentID_GradeEntries`) REFERENCES `classstudents` (`classStudentID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `gradeSheetID` FOREIGN KEY (`gradeSheetID_GradeEntries`) REFERENCES `gradesheets` (`gradeSheetID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `gradesheetcomponents`
--
ALTER TABLE `gradesheetcomponents`
ADD CONSTRAINT `gradeSheetID_GradeSheet` FOREIGN KEY (`gradeSheetID_GradeSheetComponents`) REFERENCES `gradesheets` (`gradeSheetID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `gradesheets`
--
ALTER TABLE `gradesheets`
ADD CONSTRAINT `accountID_GradeSheet` FOREIGN KEY (`accountID_GradeSheets`) REFERENCES `accounts` (`accountID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `classSubjectID_GradeSheet` FOREIGN KEY (`classSubjectID_GradeSheets`) REFERENCES `classsubjects` (`classSubjectID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
ADD CONSTRAINT `accountID_reports` FOREIGN KEY (`accountID_Reports`) REFERENCES `accounts` (`accountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
ADD CONSTRAINT `gradeLevelID_Sections` FOREIGN KEY (`gradeLevelID_Sections`) REFERENCES `gradelevels` (`gradeLevelID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
ADD CONSTRAINT `gradeLevelID_Subjects` FOREIGN KEY (`gradeLevelID_Subjects`) REFERENCES `gradelevels` (`gradeLevelID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
