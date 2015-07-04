-- Table structure for table `Questions`
CREATE TABLE IF NOT EXISTS `Questions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Question` text NOT NULL,
  `Ch1` varchar(150) NOT NULL,
  `Ch2` varchar(150) NOT NULL,
  `Ch3` varchar(150) NOT NULL,
  `Ch4` varchar(150) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Ans` varchar(150) NOT NULL,
  `User` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `User` (`User`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- Table structure for table `Userdata`

CREATE TABLE IF NOT EXISTS `Userdata` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` text NOT NULL,
  `Score` int(11) NOT NULL,
  `Answered` text NOT NULL,
  PRIMARY KEY (`Username`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
-- Constraints for table `Questions`
ALTER TABLE `Questions`
  ADD CONSTRAINT `Questions_ibfk_1` FOREIGN KEY (`User`) REFERENCES `Userdata` (`Username`);