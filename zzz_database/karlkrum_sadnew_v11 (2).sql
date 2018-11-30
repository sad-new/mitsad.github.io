-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2018 at 09:51 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karlkrum_sadnew_v11`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `accountID` int(11) NOT NULL,
  `userName` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `userType` varchar(45) DEFAULT NULL,
  `themeID_Accounts` int(11) DEFAULT NULL,
  `accountImage` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`accountID`, `userName`, `password`, `userType`, `themeID_Accounts`, `accountImage`) VALUES
(1, 'admin', 'admin', 'schoolAdministrator', NULL, NULL),
(2, 'Teacher1', 'Teacher1', 'teacher', NULL, NULL),
(3, 'teacher2', 'teacher2', 'teacher', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `classID` int(11) NOT NULL,
  `className` varchar(45) DEFAULT NULL,
  `sectionID_Classes` int(11) NOT NULL,
  `syTermID_Start_Classes` int(11) DEFAULT NULL,
  `gradeLevelID_Classes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`classID`, `className`, `sectionID_Classes`, `syTermID_Start_Classes`, `gradeLevelID_Classes`) VALUES
(7, NULL, 1, 1, 1),
(13, NULL, 4, 1, 1),
(14, NULL, 2, 5, 1),
(15, NULL, 2, 1, 1),
(16, NULL, 1, 5, 1),
(17, NULL, 3, 1, 2),
(18, NULL, 5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `classstudents`
--

CREATE TABLE `classstudents` (
  `classStudentID` int(11) NOT NULL,
  `classID_ClassStudents` int(11) NOT NULL,
  `studentInfoID_ClassStudents` int(11) DEFAULT NULL,
  `studentName` varchar(1000) NOT NULL,
  `studentNumber` varchar(40) NOT NULL,
  `studentGender` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classstudents`
--

INSERT INTO `classstudents` (`classStudentID`, `classID_ClassStudents`, `studentInfoID_ClassStudents`, `studentName`, `studentNumber`, `studentGender`) VALUES
(68, 13, NULL, 'School Mapping', 'TC004-ACTMGT', 'S'),
(69, 13, NULL, 'School management', 'TC005-SCHMGT', 'S'),
(70, 13, NULL, 'School (Profile) Management', 'TC006-SCHMGT', 'S'),
(71, 13, NULL, 'Teacher Management', 'TC007-TCHRMGT', 'T'),
(72, 13, NULL, 'Student Management', 'TC008-S2DTMGT', 'S'),
(73, 13, NULL, 'Class Management', 'TC009-CLSMGT', 'L'),
(74, 13, NULL, 'Class Population', 'TC010-CLSMGT', 'C'),
(75, 13, NULL, 'Subject assignment', 'TC011-CLSMGT', 'C'),
(76, 13, NULL, 'Record Viewing', 'TC012-RCDMGT', 'C'),
(77, 13, NULL, 'Record Grading', 'TC013-RCDMGT', 'C'),
(101, 7, NULL, 'School Mapping', 'TC004-ACTMGT', 'S'),
(102, 7, NULL, 'School management', 'TC005-SCHMGT', 'S'),
(103, 7, NULL, 'School (Profile) Management', 'TC006-SCHMGT', 'S'),
(104, 7, NULL, 'Teacher Management', 'TC007-TCHRMGT', 'T'),
(105, 7, NULL, 'Student Management', 'TC008-S2DTMGT', 'S'),
(106, 7, NULL, 'Class Management', 'TC009-CLSMGT', 'L'),
(107, 7, NULL, 'Class Population', 'TC010-CLSMGT', 'C'),
(108, 7, NULL, 'Subject assignment', 'TC011-CLSMGT', 'C'),
(109, 7, NULL, 'Record Viewing', 'TC012-RCDMGT', 'C'),
(110, 7, NULL, 'Record Grading', 'TC013-RCDMGT', 'C'),
(111, 18, NULL, 'FIRSTNAME LASTNAME', 'TEST', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `classsubjects`
--

CREATE TABLE `classsubjects` (
  `classSubjectID` int(11) NOT NULL,
  `subjectID_ClassSubjects` int(11) DEFAULT NULL,
  `classID_ClassSubjects` int(11) DEFAULT NULL,
  `teacherID_ClassSubjects` int(11) DEFAULT NULL,
  `syTermID_ClassSubjects` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classsubjects`
--

INSERT INTO `classsubjects` (`classSubjectID`, `subjectID_ClassSubjects`, `classID_ClassSubjects`, `teacherID_ClassSubjects`, `syTermID_ClassSubjects`) VALUES
(19, 2, 7, 2, 1),
(27, 1, 7, 1, 1),
(28, 1, 14, 1, 5),
(29, 1, 13, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employeeID` int(11) NOT NULL,
  `accountID_Employees` int(11) NOT NULL,
  `employeeName` varchar(45) DEFAULT NULL,
  `employeeAddress` varchar(100) NOT NULL,
  `employeePhoneNumber` varchar(45) NOT NULL,
  `employeeEmail` varchar(100) NOT NULL,
  `dateEntered` datetime DEFAULT NULL,
  `employeeImage` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employeeID`, `accountID_Employees`, `employeeName`, `employeeAddress`, `employeePhoneNumber`, `employeeEmail`, `dateEntered`, `employeeImage`) VALUES
(1, 2, 'Teacher1', '', '', '', NULL, NULL),
(2, 3, 'Teacher2', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gradeentries`
--

CREATE TABLE `gradeentries` (
  `gradeEntryID` int(11) NOT NULL,
  `gradeSheetID_GradeEntries` int(11) NOT NULL,
  `classStudentID_GradeEntries` int(11) NOT NULL,
  `gradeEntryMark` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gradelevels`
--

CREATE TABLE `gradelevels` (
  `gradeLevelID` int(11) NOT NULL,
  `gradeLevelNumber` varchar(45) DEFAULT NULL,
  `gradeLevelDivision` varchar(45) DEFAULT NULL,
  `gradeLevelName` varchar(45) DEFAULT NULL,
  `gradeLevelVersion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gradelevels`
--

INSERT INTO `gradelevels` (`gradeLevelID`, `gradeLevelNumber`, `gradeLevelDivision`, `gradeLevelName`, `gradeLevelVersion`) VALUES
(1, '1', 'Grade School', 'Grade 1', NULL),
(2, '2', 'Grade School', 'Grade 2', NULL),
(3, '3', 'Grade School', 'Grade 3', NULL),
(4, '4', 'Grade School', 'Grade 4', NULL),
(5, '5', 'Grade School', 'Grade 5', NULL),
(6, '6', 'Grade School', 'Grade 6', NULL),
(7, '7', 'Junior High School', 'Grade 7', NULL),
(8, '8', 'Junior High School', 'Grade 8', NULL),
(9, '9', 'Junior High School', 'Grade 9', NULL),
(10, '10', 'Junior High School', 'Grade 10', NULL),
(11, '11', 'Senior High School', 'Grade 11', NULL),
(12, '12', 'Senior High School', 'Grade 12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gradesheetcomponents`
--

CREATE TABLE `gradesheetcomponents` (
  `gradeSheetComponentID` int(11) NOT NULL,
  `gradeSheetID_GradeSheetComponents` int(11) NOT NULL,
  `componentName` varchar(45) DEFAULT NULL,
  `componentValue` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gradesheets`
--

CREATE TABLE `gradesheets` (
  `gradeSheetID` int(11) NOT NULL,
  `classSubjectID_GradeSheets` int(11) DEFAULT NULL,
  `accountID_GradeSheets` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `reportID` int(11) NOT NULL,
  `accountID_Reports` int(11) DEFAULT NULL,
  `reportType` varchar(45) DEFAULT NULL,
  `reportDateIssued` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `sectionID` int(11) NOT NULL,
  `sectionName` varchar(45) DEFAULT NULL,
  `sectionYearLevel` int(11) DEFAULT NULL,
  `gradeLevelID_Sections` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`sectionID`, `sectionName`, `sectionYearLevel`, `gradeLevelID_Sections`) VALUES
(1, 'Section 1', NULL, 1),
(2, 'Section 2', NULL, 1),
(3, 'Section 3', NULL, 2),
(4, 'Section 3', NULL, 1),
(5, 'Section 4', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `studentinfo`
--

CREATE TABLE `studentinfo` (
  `studentInfoID` int(11) NOT NULL,
  `studentLRN` varchar(45) NOT NULL,
  `studentName` varchar(45) DEFAULT NULL,
  `studentGender` varchar(45) DEFAULT NULL,
  `isAutoGenerated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjectID` int(11) NOT NULL,
  `subjectName` varchar(45) DEFAULT NULL,
  `subjectGroup` varchar(45) DEFAULT NULL,
  `subjectYearLevel` int(11) DEFAULT NULL,
  `subjectDateIssued` datetime DEFAULT NULL,
  `gradeLevelID_Subjects` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjectID`, `subjectName`, `subjectGroup`, `subjectYearLevel`, `subjectDateIssued`, `gradeLevelID_Subjects`) VALUES
(1, 'Math 1', NULL, NULL, NULL, 1),
(2, 'Science 1', NULL, NULL, NULL, 1),
(3, 'Civics 1', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `syterms`
--

CREATE TABLE `syterms` (
  `syTermID` int(11) NOT NULL,
  `schoolYear` year(4) DEFAULT NULL,
  `termNumber` int(11) DEFAULT NULL,
  `termStart` date DEFAULT NULL,
  `termEnd` date DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `syterms`
--

INSERT INTO `syterms` (`syTermID`, `schoolYear`, `termNumber`, `termStart`, `termEnd`, `isActive`) VALUES
(1, 2018, 1, NULL, NULL, 1),
(2, 2018, 2, NULL, NULL, 0),
(3, 2018, 3, NULL, NULL, 0),
(4, 2018, 4, NULL, NULL, 0),
(5, 2019, 1, NULL, NULL, 0),
(6, 2019, 2, NULL, NULL, 0),
(7, 2019, 3, NULL, NULL, 0),
(8, 2019, 4, NULL, NULL, 0),
(9, 2020, 1, NULL, NULL, 0),
(10, 2020, 2, NULL, NULL, 0),
(11, 2020, 3, NULL, NULL, 0),
(12, 2020, 4, NULL, NULL, 0);

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
  ADD PRIMARY KEY (`classID`),
  ADD KEY `sectinID_Class_idx` (`sectionID_Classes`),
  ADD KEY `syTermID_Start_idx` (`syTermID_Start_Classes`),
  ADD KEY `gradeLevelID_Class_idx` (`gradeLevelID_Classes`);

--
-- Indexes for table `classstudents`
--
ALTER TABLE `classstudents`
  ADD PRIMARY KEY (`classStudentID`),
  ADD KEY `classID_ClasList_idx` (`classID_ClassStudents`),
  ADD KEY `studentInfoID_ClassStudents_idx` (`studentInfoID_ClassStudents`);

--
-- Indexes for table `classsubjects`
--
ALTER TABLE `classsubjects`
  ADD PRIMARY KEY (`classSubjectID`),
  ADD KEY `classID_ClassSubject_idx` (`classID_ClassSubjects`),
  ADD KEY `adviserID_ClassSubject_idx` (`teacherID_ClassSubjects`),
  ADD KEY `subjectID_ClassSubjects_idx` (`subjectID_ClassSubjects`),
  ADD KEY `syTermID_Start_idx` (`syTermID_ClassSubjects`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employeeID`),
  ADD KEY `accountID_Employees_idx` (`accountID_Employees`);

--
-- Indexes for table `gradeentries`
--
ALTER TABLE `gradeentries`
  ADD PRIMARY KEY (`gradeEntryID`),
  ADD KEY `classListID_idx` (`classStudentID_GradeEntries`),
  ADD KEY `gradeSheetID` (`gradeSheetID_GradeEntries`);

--
-- Indexes for table `gradelevels`
--
ALTER TABLE `gradelevels`
  ADD PRIMARY KEY (`gradeLevelID`);

--
-- Indexes for table `gradesheetcomponents`
--
ALTER TABLE `gradesheetcomponents`
  ADD PRIMARY KEY (`gradeSheetComponentID`),
  ADD KEY `gradeSheetID_GradeSheet_idx` (`gradeSheetID_GradeSheetComponents`);

--
-- Indexes for table `gradesheets`
--
ALTER TABLE `gradesheets`
  ADD PRIMARY KEY (`gradeSheetID`),
  ADD KEY `classSubjectID_GradeSheet_idx` (`classSubjectID_GradeSheets`),
  ADD KEY `accountID_GradeSheet_idx` (`accountID_GradeSheets`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `accountID_Reports_idx` (`accountID_Reports`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`sectionID`),
  ADD KEY `gradeLevelID_Sections_idx` (`gradeLevelID_Sections`);

--
-- Indexes for table `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD PRIMARY KEY (`studentInfoID`,`studentLRN`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjectID`),
  ADD KEY `gradeLevelID_Subjects_idx` (`gradeLevelID_Subjects`);

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
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `classID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `classstudents`
--
ALTER TABLE `classstudents`
  MODIFY `classStudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `classsubjects`
--
ALTER TABLE `classsubjects`
  MODIFY `classSubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gradeentries`
--
ALTER TABLE `gradeentries`
  MODIFY `gradeEntryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gradelevels`
--
ALTER TABLE `gradelevels`
  MODIFY `gradeLevelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `sectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `studentinfo`
--
ALTER TABLE `studentinfo`
  MODIFY `studentInfoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `syterms`
--
ALTER TABLE `syterms`
  MODIFY `syTermID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `classID_ClasList` FOREIGN KEY (`classID_ClassStudents`) REFERENCES `classes` (`classID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `studentInfoID_ClassStudents` FOREIGN KEY (`studentInfoID_ClassStudents`) REFERENCES `studentinfo` (`studentInfoID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
