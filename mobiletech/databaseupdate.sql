-- update usersmenu set menuoption=REPLACE(menuoption,'Staff','Users') where indexkey<280;
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Staff Update','Yes',280);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','View Staff','Yes',290);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Staff Reports','Yes',300);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Appraisal Update','Yes',310);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','View Appraisal','Yes',320);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Appraisal Reports','Yes',330);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Leave Update','Yes',340);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Leave Supervisor Approval','Yes',350);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Leave Admin Approval','Yes',360);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','View Leave','Yes',370);
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Leave Reports','Yes',380);

-- SELECT * FROM usersmenu where menuoption like '%Staff%';
-- SELECT * FROM usersmenu where menuoption like '%User%';
-- SELECT * FROM usersmenu order by indexkey;
-- update usersmenu set menuoption=REPLACE(menuoption,'Staff','Users') where indexkey<280;
-- insert into usersmenu (userName,menuOption,accessible,indexkey) value ('Admin','Leave Reports','Yes',360);
-- delete from usersmenu where serialno=669;
-- ALTER TABLE `kkontechdb`.`stafftable` ADD COLUMN `active` VARCHAR(10) AFTER `middlename`;

--ALTER TABLE `kkontechdb`.`appraisaltable` ADD COLUMN `appraisalstartdate` VARCHAR(10) AFTER `appraisalend`, ADD COLUMN `appraisalenddate` VARCHAR(10) AFTER `appraisalstartdate`;

DROP TABLE IF EXISTS `kkontechdb`.`stafftable`;
CREATE TABLE  `kkontechdb`.`stafftable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `staffid` varchar(30) default NULL,
  `lastname` varchar(50) default NULL,
  `firstname` varchar(50) default NULL,
  `middlename` varchar(50) default NULL,
  `active` varchar(10) default NULL,
  `gender` varchar(10) default NULL,
  `jobtitle` varchar(50) default NULL,
  `department` varchar(50) default NULL,
  `supervisorid` varchar(45) default NULL,
  `level` varchar(50) default NULL,
  `employmentdate` date default NULL,
  `previouscontactaddress` varchar(300) default NULL,
  `newcontactaddress` varchar(300) default NULL,
  `mobilephonenumber` varchar(50) default NULL,
  `homephonenumber` varchar(45) default NULL,
  `birthdate` date default NULL,
  `emailaddress` varchar(100) default NULL,
  `maritalstatus` varchar(15) default NULL,
  `maidenname` varchar(100) default NULL,
  `spousename` varchar(100) default NULL,
  `spousephonenumber` varchar(50) default NULL,
  `nextofkin` varchar(100) default NULL,
  `nextofkinaddress` varchar(300) default NULL,
  `nextofkinrelationship` varchar(15) default NULL,
  `nextofkinphonenumber` varchar(50) default NULL,
  `staffPicture` varchar(50) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `kkontechdb`.`appraisaltable`;
CREATE TABLE  `kkontechdb`.`appraisaltable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `staffid` varchar(30) default NULL,
  `duties` varchar(500) default NULL,
  `difficultduties` varchar(500) default NULL,
  `interestingduties` varchar(500) default NULL,
  `performanceimprove` varchar(500) default NULL,
  `queryorsuspension` varchar(500) default NULL,
  `training` varchar(500) default NULL,
  `accomplishments` varchar(500) default NULL,
  `appraisaldate` date default NULL,
  `appraisalstart` varchar(10) default NULL,
  `appraisalend` varchar(10) default NULL,
  `appraisalstartdate` varchar(10) default NULL,
  `appraisalenddate` varchar(10) default NULL,
  `userName` varchar(50) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `kkontechdb`.`leavetable`;
CREATE TABLE  `kkontechdb`.`leavetable` (
  `serialno` int(10) unsigned NOT NULL auto_increment,
  `staffid` varchar(30) default NULL,
  `leavetype` varchar(20) default NULL,
  `leavestart` datetime default NULL,
  `leaveend` datetime default NULL,
  `supervisorid` varchar(30) default NULL,
  `supervisorapproval` varchar(20) default NULL,
  `leaveapplydate` datetime default NULL,
  `entitlement` double default NULL,
  `resumptiondate` datetime default NULL,
  `adminid` varchar(30) default NULL,
  `adminapproval` varchar(20) default NULL,
  `leaveapprovedate` date default NULL,
  `userName` varchar(50) default NULL,
  PRIMARY KEY  (`serialno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

