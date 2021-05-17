-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.24a-community-nt


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema laspotechDB
--

CREATE DATABASE IF NOT EXISTS laspotechDB;
USE laspotechDB;

--
-- Definition of table `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE `activities` (
  `userEmail` varchar(50) NOT NULL,
  `descriptions` varchar(250) NOT NULL,
  `activityDate` varchar(10) NOT NULL,
  `activityTime` varchar(10) NOT NULL,
  PRIMARY KEY  (`userEmail`,`activityDate`,`activityTime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;


--
-- Definition of table `amendedreasons`
--

DROP TABLE IF EXISTS `amendedreasons`;
CREATE TABLE `amendedreasons` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `programmecode` varchar(100) default NULL,
  `groupsession` varchar(10) default NULL,
  `studentlevel` varchar(50) default NULL,
  `sessiondescription` varchar(50) default NULL,
  `semester` varchar(50) default NULL,
  `coursecode` varchar(10) default NULL,
  `amendedtitle` varchar(45) default NULL,
  `amendreason` varchar(500) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Definition of table `amendedresults`
--

DROP TABLE IF EXISTS `amendedresults`;
CREATE TABLE `amendedresults` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(50) default NULL,
  `semester` varchar(50) default NULL,
  `coursecode` varchar(10) default NULL,
  `registrationnumber` varchar(30) default NULL,
  `marksdescription` varchar(100) default NULL,
  `marksobtained` double default NULL,
  `marksobtainable` double default NULL,
  `percentage` double default NULL,
  `studentlevel` varchar(50) default NULL,
  `programmecode` varchar(100) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `groupsession` varchar(10) default NULL,
  `amendreason` varchar(500) default NULL,
  `previousmark` double default NULL,
  `amendedmark` double default NULL,
  `amendedgradecode` varchar(10) default NULL,
  `amendedgradeunit` double default NULL,
  `amendedtitle` varchar(45) default NULL,
  `previousgradecode` varchar(10) default NULL,
  `previousgradeunit` double default NULL,
  `previoustitle` varchar(45) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Definition of table `cgpatable`
--

DROP TABLE IF EXISTS `cgpatable`;
CREATE TABLE `cgpatable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `cgpacode` varchar(50) default NULL,
  `lowerrange` double default NULL,
  `upperrange` double default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `coursesform`
--

DROP TABLE IF EXISTS `coursesform`;
CREATE TABLE `coursesform` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessioncode` varchar(50) default NULL,
  `semester` varchar(50) default NULL,
  `registrationnumber` varchar(30) default NULL,
  `coursecode` varchar(50) default NULL,
  `lecturerapproval` varchar(10) default NULL,
  `hodapproval` varchar(10) default NULL,
  `advisorapproval` varchar(10) default NULL,
  `examofficerapproval` varchar(10) default NULL,
  `leveldescription` varchar(50) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coursesform`
--

/*!40000 ALTER TABLE `coursesform` DISABLE KEYS */;
/*!40000 ALTER TABLE `coursesform` ENABLE KEYS */;


--
-- Definition of table `coursestable`
--

DROP TABLE IF EXISTS `coursestable`;
CREATE TABLE `coursestable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `coursecode` varchar(10) default NULL,
  `coursedescription` varchar(50) default NULL,
  `courseunit` double default NULL,
  `coursetype` varchar(30) default NULL,
  `minimumscore` double default NULL,
  `programmecode` varchar(100) default NULL,
  `lecturerid` varchar(30) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `sessiondescription` varchar(10) default NULL,
  `semesterdescription` varchar(10) default NULL,
  `studentlevel` varchar(50) default NULL,
  `groupsession` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `departmentstable`
--

DROP TABLE IF EXISTS `departmentstable`;
CREATE TABLE `departmentstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `departmentdescription` varchar(100) default NULL,
  `facultycode` varchar(100) default NULL,
  `hod` varchar(30) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `examresultstable`
--

DROP TABLE IF EXISTS `examresultstable`;
CREATE TABLE `examresultstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(50) default NULL,
  `semester` varchar(50) default NULL,
  `coursecode` varchar(10) default NULL,
  `registrationnumber` varchar(30) default NULL,
  `marksdescription` varchar(100) default NULL,
  `marksobtained` double default NULL,
  `marksobtainable` double default NULL,
  `percentage` double default NULL,
  `studentlevel` varchar(50) default NULL,
  `programmecode` varchar(100) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `groupsession` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `facultiestable`
--

DROP TABLE IF EXISTS `facultiestable`;
CREATE TABLE `facultiestable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `facultydescription` varchar(100) default NULL,
  `dof` varchar(50) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Definition of table `finalresultstable`
--

DROP TABLE IF EXISTS `finalresultstable`;
CREATE TABLE `finalresultstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(10) default NULL,
  `semester` varchar(50) default NULL,
  `coursecode` varchar(10) default NULL,
  `registrationnumber` varchar(30) default NULL,
  `marksobtained` double default NULL,
  `gradecode` varchar(10) default NULL,
  `gradeunit` double default NULL,
  `studentlevel` varchar(50) default NULL,
  `programmecode` varchar(100) default NULL,
  `coursestatus` varchar(10) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `groupsession` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `gradestable`
--

DROP TABLE IF EXISTS `gradestable`;
CREATE TABLE `gradestable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `gradecode` varchar(10) default NULL,
  `lowerrange` double default NULL,
  `upperrange` double default NULL,
  `gradeunit` double default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `image_table`
--

DROP TABLE IF EXISTS `image_table`;
CREATE TABLE `image_table` (
  `image_name` varchar(500) NOT NULL,
  `image` longblob NOT NULL,
  `id` varchar(45) NOT NULL,
  `contentType` varchar(45) NOT NULL,
  `filesize` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image_table`
--

/*!40000 ALTER TABLE `image_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `image_table` ENABLE KEYS */;


--
-- Definition of table `paymentstable`
--

DROP TABLE IF EXISTS `paymentstable`;
CREATE TABLE `paymentstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(10) default NULL,
  `registrationnumber` varchar(30) default NULL,
  `paymentdescription` varchar(255) default NULL,
  `amount` double default NULL,
  `balance` double default NULL,
  `paytype` varchar(10) default NULL,
  `receiptno` varchar(45) default NULL,
  `confirmno` varchar(45) default NULL,
  `pinnumber` varchar(45) default NULL,
  `paydate` varchar(19) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paymentstable`
--

/*!40000 ALTER TABLE `paymentstable` DISABLE KEYS */;
/*!40000 ALTER TABLE `paymentstable` ENABLE KEYS */;


--
-- Definition of table `pintable`
--

DROP TABLE IF EXISTS `pintable`;
CREATE TABLE `pintable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `amount` double default NULL,
  `receiptno` varchar(45) default NULL,
  `confirmno` varchar(45) default NULL,
  `pinnumber` varchar(45) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




--
-- Definition of table `programmestable`
--

DROP TABLE IF EXISTS `programmestable`;
CREATE TABLE `programmestable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `programmedescription` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `courseadvisor` varchar(30) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `qualificationstable`
--

DROP TABLE IF EXISTS `qualificationstable`;
CREATE TABLE `qualificationstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `qualificationcode` varchar(10) default NULL,
  `qualificationdescription` varchar(100) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `registration`
--

DROP TABLE IF EXISTS `registration`;
CREATE TABLE `registration` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `regNumber` varchar(30) default NULL,
  `studentlevel` varchar(50) default NULL,
  `sessions` varchar(10) default NULL,
  `semester` varchar(50) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `regularstudents`
--

DROP TABLE IF EXISTS `regularstudents`;
CREATE TABLE `regularstudents` (
  `serialno` int(10) NOT NULL auto_increment,
  `regNumber` varchar(30) default NULL,
  `firstName` varchar(50) default NULL,
  `lastName` varchar(50) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `programmecode` varchar(100) default NULL,
  `gender` varchar(10) default NULL,
  `dateOfBirth` date default NULL,
  `userName` varchar(50) default NULL,
  `userPassword` varchar(10) default NULL,
  `middleName` varchar(50) default NULL,
  `userEmail` varchar(100) default NULL,
  `userAddress` varchar(250) default NULL,
  `postCode` varchar(10) default NULL,
  `userPicture` varchar(50) default NULL,
  `userType` varchar(10) default NULL,
  `active` varchar(10) character set latin1 collate latin1_bin default 'No',
  `validate` varchar(10) default NULL,
  `receiptNo` varchar(45) default NULL,
  `pinNo` varchar(45) default NULL,
  `confirmNo` varchar(45) default NULL,
  `payApproved` varchar(10) default NULL,
  `maidenName` varchar(50) default NULL,
  `contactAddress` varchar(250) default NULL,
  `nationality` varchar(50) default NULL,
  `originState` varchar(50) default NULL,
  `lga` varchar(50) default NULL,
  `birthPlace` varchar(50) default NULL,
  `maritalStatus` varchar(20) default NULL,
  `religion` varchar(50) default NULL,
  `spouseName` varchar(45) default NULL,
  `title` varchar(10) default NULL,
  `guardianName` varchar(100) default NULL,
  `guardianAddress` varchar(250) default NULL,
  `guardianRelationship` varchar(30) default NULL,
  `disability` varchar(250) default NULL,
  `wascresults` varchar(1000) default NULL,
  `cgpacode` varchar(50) default NULL,
  `supportindocuments` varchar(1000) default NULL,
  `studentlevel` varchar(50) default NULL,
  `guardianEmail` varchar(100) default NULL,
  `ignorepay` varchar(10) default NULL,
  `lockrec` varchar(10) default NULL,
  `qualificationcode` varchar(10) default NULL,
  `minimumunit` double default NULL,
  `tcp` double default NULL,
  `tnu` double default NULL,
  `gpa` double default NULL,
  `tnup` double default NULL,
  `entryyear` varchar(10) default NULL,
  `phoneno` varchar(15) default NULL,
  `guardianphoneno` varchar(15) default NULL,
  `admissiontype` varchar(10) default NULL,
  `carryover` varchar(500) default NULL,
  PRIMARY KEY  USING BTREE (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `retakecourses`
--

DROP TABLE IF EXISTS `retakecourses`;
CREATE TABLE `retakecourses` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(50) default NULL,
  `semester` varchar(50) default NULL,
  `coursecode` varchar(10) default NULL,
  `registrationnumber` varchar(30) default NULL,
  `coursestatus` varchar(10) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `programmecode` varchar(100) default NULL,
  `studentlevel` varchar(50) default NULL,
  `groupsession` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `schoolinformation`
--

DROP TABLE IF EXISTS `schoolinformation`;
CREATE TABLE `schoolinformation` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `schoolname` varchar(100) default NULL,
  `addressline1` varchar(100) default NULL,
  `addressline2` varchar(100) default NULL,
  `addressline3` varchar(100) default NULL,
  `addressline4` varchar(100) default NULL,
  `telephonenumber` varchar(255) default NULL,
  `faxnumber` varchar(255) default NULL,
  `emailaddress` varchar(255) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schoolinformation`
--

/*!40000 ALTER TABLE `schoolinformation` DISABLE KEYS */;
INSERT INTO `schoolinformation` (`serialno`,`schoolname`,`addressline1`,`addressline2`,`addressline3`,`addressline4`,`telephonenumber`,`faxnumber`,`emailaddress`) VALUES 
 (1,'LAGOS STATE POLYTECHNIC','IKORODU','LAGOS STATE','NIGERIA','WEST AFRICA','','','');
/*!40000 ALTER TABLE `schoolinformation` ENABLE KEYS */;


--
-- Definition of table `sessionstable`
--

DROP TABLE IF EXISTS `sessionstable`;
CREATE TABLE `sessionstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(50) default NULL,
  `semesterdescription` varchar(50) default NULL,
  `semesterstartdate` varchar(10) default NULL,
  `semesterenddate` varchar(10) default NULL,
  `currentperiod` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessionstable`
--

/*!40000 ALTER TABLE `sessionstable` DISABLE KEYS */;
INSERT INTO `sessionstable` (`serialno`,`sessiondescription`,`semesterdescription`,`semesterstartdate`,`semesterenddate`,`currentperiod`) VALUES 
 (3,'2002/2003','HARMATTAN','','','No'),
 (4,'2002/2003','RAIN','','','No'),
 (5,'2003/2004','HARMATTAN','','','No'),
 (6,'2003/2004','RAIN','','','No'),
 (7,'2005/2006','HARMATTAN','','','No'),
 (8,'2005/2006','RAIN','','','No'),
 (9,'2006/2007','HARMATTAN','','','No'),
 (10,'2006/2007','RAIN','','','No'),
 (11,'2007/2008','HARMATTAN','','','No'),
 (12,'2007/2008','RAIN','','','Yes'),
 (14,'2009/2010','HARMATTAN','','','No'),
 (15,'2009/2010','RAIN','','','No'),
 (16,'2010/2011','HARMATTAN','','','No'),
 (17,'2010/2011','RAIN','','','No'),
 (18,'2004/2005','HARMATTAN','','',''),
 (19,'2004/2005','RAIN','','',''),
 (20,'2011/2012','HARMATTAN','','',''),
 (21,'2011/2012','RAIN','','',''),
 (22,'2012/2013','HARMATTAN','','',''),
 (23,'2012/2013','RAIN','','',''),
 (24,'2013/2014','HARMATTAN','','',''),
 (25,'2013/2014','RAIN','','','');
/*!40000 ALTER TABLE `sessionstable` ENABLE KEYS */;


--
-- Definition of table `signatoriestable`
--

DROP TABLE IF EXISTS `signatoriestable`;
CREATE TABLE `signatoriestable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `signatoryposition` varchar(100) default NULL,
  `signatoryname` varchar(100) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `specialfeatures`
--

DROP TABLE IF EXISTS `specialfeatures`;
CREATE TABLE `specialfeatures` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `registrationnumber` varchar(30) default NULL,
  `sessiondescription` varchar(10) default NULL,
  `semester` varchar(10) default NULL,
  `feature` varchar(500) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `programmecode` varchar(100) default NULL,
  `studentlevel` varchar(50) default NULL,
  `groupsession` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specialfeatures`
--

/*!40000 ALTER TABLE `specialfeatures` DISABLE KEYS */;
/*!40000 ALTER TABLE `specialfeatures` ENABLE KEYS */;


--
-- Definition of table `studentsfeestable`
--

DROP TABLE IF EXISTS `studentsfeestable`;
CREATE TABLE `studentsfeestable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(10) default NULL,
  `studentlevel` varchar(50) default NULL,
  `amountdue` double default NULL,
  `minimumpayment` double default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `programmecode` varchar(100) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentsfeestable`
--

/*!40000 ALTER TABLE `studentsfeestable` DISABLE KEYS */;
/*!40000 ALTER TABLE `studentsfeestable` ENABLE KEYS */;


--
-- Definition of table `studentslevels`
--

DROP TABLE IF EXISTS `studentslevels`;
CREATE TABLE `studentslevels` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `leveldescription` varchar(50) default NULL,
  `examofficer` varchar(30) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `summaryreport`
--

DROP TABLE IF EXISTS `summaryreport`;
CREATE TABLE `summaryreport` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `matricno` varchar(30) default NULL,
  `fullname` varchar(100) default NULL,
  `gender` varchar(10) default NULL,
  `cgpa` double default NULL,
  `ctnup` double default NULL,
  `remark` text,
  `reporttype` varchar(20) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `serialno` int(10) NOT NULL auto_increment,
  `userPassword` varchar(10) default NULL,
  `userName` varchar(50) default NULL,
  `firstName` varchar(50) default NULL,
  `lastName` varchar(50) default NULL,
  `userType` varchar(10) default NULL,
  `active` varchar(10) character set latin1 collate latin1_bin default 'No',
  `userEmail` varchar(100) default NULL,
  `validate` varchar(10) default NULL,
  `loggedIn` varchar(1) default NULL,
  `userPicture` varchar(50) default NULL,
  `friends` varchar(1000) default NULL,
  `friendrequests` varchar(1000) default NULL,
  PRIMARY KEY  USING BTREE (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`serialno`,`userPassword`,`userName`,`firstName`,`lastName`,`userType`,`active`,`userEmail`,`validate`,`loggedIn`,`userPicture`,`friends`,`friendrequests`) VALUES 
 (1,'admins','Admin','Administrator','Administer','Admin',0x596573,'adewaleazeez@gmail.com','Yes','1','1294944445242','','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


--
-- Definition of table `usersmenu`
--

DROP TABLE IF EXISTS `usersmenu`;
CREATE TABLE `usersmenu` (
  `serialno` int(11) NOT NULL auto_increment,
  `userName` varchar(50) NOT NULL,
  `menuOption` varchar(50) NOT NULL,
  `accessible` varchar(10) NOT NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usersmenu`
--

/*!40000 ALTER TABLE `usersmenu` DISABLE KEYS */;
INSERT INTO `usersmenu` (`serialno`,`userName`,`menuOption`,`accessible`) VALUES 
 (1,'','Institution Information','No'),
 (2,'','Schools Setup','No'),
 (3,'','Departments Setup','No'),
 (4,'','Programmes Setup','No'),
 (5,'','Courses Setup','No'),
 (6,'','Student Levels Setup','No'),
 (7,'','Qualifications Setup','No'),
 (8,'','Session Semester Setup','No'),
 (9,'','Grades Setup','No'),
 (10,'','CGPA Setup','No'),
 (11,'','Student Details Update','No'),
 (12,'','Update Student Marks','No'),
 (13,'','Master Score Sheet','No'),
 (14,'','Summary of Results','No'),
 (15,'','Student Transcript','No'),
 (16,'','Manage Users','No'),
 (17,'','Users Access Control','No'),
 (18,'Admin','Institution Information','Yes'),
 (19,'Admin','Schools Setup','Yes'),
 (20,'Admin','Departments Setup','Yes'),
 (21,'Admin','Programmes Setup','Yes'),
 (22,'Admin','Courses Setup','Yes'),
 (23,'Admin','Student Levels Setup','Yes'),
 (24,'Admin','Qualifications Setup','Yes'),
 (25,'Admin','Session Semester Setup','Yes'),
 (26,'Admin','Grades Setup','Yes'),
 (27,'Admin','CGPA Setup','Yes'),
 (28,'Admin','Student Details Update','Yes'),
 (29,'Admin','Update Student Marks','Yes'),
 (30,'Admin','Master Score Sheet','Yes'),
 (31,'Admin','Summary of Results','Yes'),
 (32,'Admin','Student Transcript','Yes'),
 (33,'Admin','Manage Users','Yes'),
 (34,'Admin','Users Access Control','Yes');
/*!40000 ALTER TABLE `usersmenu` ENABLE KEYS */;

--
-- Create schema laspotechDBonline
--

CREATE DATABASE IF NOT EXISTS laspotechDBonline;
USE laspotechDBonline;

--
-- Definition of table `cgpatable`
--

DROP TABLE IF EXISTS `cgpatable`;
CREATE TABLE `cgpatable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `cgpacode` varchar(50) default NULL,
  `lowerrange` double default NULL,
  `upperrange` double default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `coursestable`
--

DROP TABLE IF EXISTS `coursestable`;
CREATE TABLE `coursestable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `coursecode` varchar(10) default NULL,
  `coursedescription` varchar(50) default NULL,
  `courseunit` double default NULL,
  `coursetype` varchar(30) default NULL,
  `minimumscore` double default NULL,
  `programmecode` varchar(100) default NULL,
  `lecturerid` varchar(30) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `sessiondescription` varchar(10) default NULL,
  `semesterdescription` varchar(10) default NULL,
  `studentlevel` varchar(50) default NULL,
  `groupsession` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `finalresultstable`
--

DROP TABLE IF EXISTS `finalresultstable`;
CREATE TABLE `finalresultstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(10) default NULL,
  `semester` varchar(50) default NULL,
  `coursecode` varchar(10) default NULL,
  `registrationnumber` varchar(30) default NULL,
  `marksobtained` double default NULL,
  `gradecode` varchar(10) default NULL,
  `gradeunit` double default NULL,
  `studentlevel` varchar(50) default NULL,
  `programmecode` varchar(100) default NULL,
  `coursestatus` varchar(10) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `groupsession` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `gradestable`
--

DROP TABLE IF EXISTS `gradestable`;
CREATE TABLE `gradestable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `gradecode` varchar(10) default NULL,
  `lowerrange` double default NULL,
  `upperrange` double default NULL,
  `gradeunit` double default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `pintable`
--

DROP TABLE IF EXISTS `pintable`;
CREATE TABLE `pintable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `regNumber` varchar(30) default NULL,
  `sessiondescription` varchar(50) default NULL,
  `semesterdescription` varchar(50) default NULL,
  `pinnumber` varchar(30) default NULL,
  `serialcode` varchar(30) default NULL,
  `cardstatus` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pintable`
--

/*!40000 ALTER TABLE `pintable` DISABLE KEYS */;
INSERT INTO `pintable` (`serialno`,`regNumber`,`sessiondescription`,`semesterdescription`,`pinnumber`,`serialcode`,`cardstatus`) VALUES 
 (1,'CSB09731600','2009/2010','HARMATTAN','0000000000','0000000001','closed'),
 (2,'CSB09731600','2009/2010','RAIN','1111111111','0000000002','closed');
/*!40000 ALTER TABLE `pintable` ENABLE KEYS */;


--
-- Definition of table `qualificationstable`
--

DROP TABLE IF EXISTS `qualificationstable`;
CREATE TABLE `qualificationstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `qualificationcode` varchar(10) default NULL,
  `qualificationdescription` varchar(100) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `registration`
--

DROP TABLE IF EXISTS `registration`;
CREATE TABLE `registration` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `regNumber` varchar(30) default NULL,
  `studentlevel` varchar(50) default NULL,
  `sessions` varchar(10) default NULL,
  `semester` varchar(50) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `regularstudents`
--

DROP TABLE IF EXISTS `regularstudents`;
CREATE TABLE `regularstudents` (
  `serialno` int(10) NOT NULL auto_increment,
  `regNumber` varchar(30) default NULL,
  `firstName` varchar(50) default NULL,
  `lastName` varchar(50) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `programmecode` varchar(100) default NULL,
  `gender` varchar(10) default NULL,
  `dateOfBirth` date default NULL,
  `userName` varchar(50) default NULL,
  `userPassword` varchar(10) default NULL,
  `middleName` varchar(50) default NULL,
  `userEmail` varchar(100) default NULL,
  `userAddress` varchar(250) default NULL,
  `postCode` varchar(10) default NULL,
  `userPicture` varchar(50) default NULL,
  `userType` varchar(10) default NULL,
  `active` varchar(10) character set latin1 collate latin1_bin default 'No',
  `validate` varchar(10) default NULL,
  `receiptNo` varchar(45) default NULL,
  `pinNo` varchar(45) default NULL,
  `confirmNo` varchar(45) default NULL,
  `payApproved` varchar(10) default NULL,
  `maidenName` varchar(50) default NULL,
  `contactAddress` varchar(250) default NULL,
  `nationality` varchar(50) default NULL,
  `originState` varchar(50) default NULL,
  `lga` varchar(50) default NULL,
  `birthPlace` varchar(50) default NULL,
  `maritalStatus` varchar(20) default NULL,
  `religion` varchar(50) default NULL,
  `spouseName` varchar(45) default NULL,
  `title` varchar(10) default NULL,
  `guardianName` varchar(100) default NULL,
  `guardianAddress` varchar(250) default NULL,
  `guardianRelationship` varchar(30) default NULL,
  `disability` varchar(250) default NULL,
  `wascresults` varchar(1000) default NULL,
  `cgpacode` varchar(50) default NULL,
  `supportindocuments` varchar(1000) default NULL,
  `studentlevel` varchar(50) default NULL,
  `guardianEmail` varchar(100) default NULL,
  `ignorepay` varchar(10) default NULL,
  `lockrec` varchar(10) default NULL,
  `qualificationcode` varchar(10) default NULL,
  `minimumunit` double default NULL,
  `tcp` double default NULL,
  `tnu` double default NULL,
  `gpa` double default NULL,
  `tnup` double default NULL,
  `entryyear` varchar(10) default NULL,
  `phoneno` varchar(15) default NULL,
  `guardianphoneno` varchar(15) default NULL,
  `admissiontype` varchar(10) default NULL,
  PRIMARY KEY  USING BTREE (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `retakecourses`
--

DROP TABLE IF EXISTS `retakecourses`;
CREATE TABLE `retakecourses` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(50) default NULL,
  `semester` varchar(50) default NULL,
  `coursecode` varchar(10) default NULL,
  `registrationnumber` varchar(30) default NULL,
  `coursestatus` varchar(10) default NULL,
  `facultycode` varchar(100) default NULL,
  `departmentcode` varchar(100) default NULL,
  `programmecode` varchar(100) default NULL,
  `studentlevel` varchar(50) default NULL,
  `groupsession` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `schoolinformation`
--

DROP TABLE IF EXISTS `schoolinformation`;
CREATE TABLE `schoolinformation` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `schoolname` varchar(100) default NULL,
  `addressline1` varchar(100) default NULL,
  `addressline2` varchar(100) default NULL,
  `addressline3` varchar(100) default NULL,
  `addressline4` varchar(100) default NULL,
  `telephonenumber` varchar(255) default NULL,
  `faxnumber` varchar(255) default NULL,
  `emailaddress` varchar(255) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schoolinformation`
--

/*!40000 ALTER TABLE `schoolinformation` DISABLE KEYS */;
INSERT INTO `schoolinformation` (`serialno`,`schoolname`,`addressline1`,`addressline2`,`addressline3`,`addressline4`,`telephonenumber`,`faxnumber`,`emailaddress`) VALUES 
 (1,'LAGOS STATE POLYTECHNIC','IKORODU','LAGOS STATE','NIGERIA','WEST AFRICA','','','');
/*!40000 ALTER TABLE `schoolinformation` ENABLE KEYS */;


--
-- Definition of table `sessionstable`
--

DROP TABLE IF EXISTS `sessionstable`;
CREATE TABLE `sessionstable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `sessiondescription` varchar(50) default NULL,
  `semesterdescription` varchar(50) default NULL,
  `semesterstartdate` varchar(10) default NULL,
  `semesterenddate` varchar(10) default NULL,
  `currentperiod` varchar(10) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessionstable`
--

/*!40000 ALTER TABLE `sessionstable` DISABLE KEYS */;
INSERT INTO `sessionstable` (`serialno`,`sessiondescription`,`semesterdescription`,`semesterstartdate`,`semesterenddate`,`currentperiod`) VALUES 
 (14,'2009/2010','HARMATTAN',NULL,NULL,'No'),
 (15,'2009/2010','RAIN',NULL,NULL,'No');
/*!40000 ALTER TABLE `sessionstable` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
