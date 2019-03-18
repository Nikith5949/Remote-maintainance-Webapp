-- to create database and delete data base if existing 
DROP DATABASE IF EXISTS Project;
CREATE DATABASE Project;
USE Project;

--
CREATE TABLE Registration (
  RegistrationID       INT(11) AUTO_INCREMENT,
  FirstName     VARCHAR(25)   NOT NULL,
  LastName		VARCHAR(25)	  NOT NULL,
  EmailID		VARCHAR(35)	  NOT NULL Unique ,
  Password		VARCHAR(256)	  NOT NULL,
  City		VARCHAR(30)	  NOT NULL,
  PhoneNumber INT(12),
  PRIMARY KEY (RegistrationID)
);






CREATE TABLE Building(
  BID       INT(11) AUTO_INCREMENT,
  Bname    VARCHAR(25) unique,
  Address     VARCHAR(50),
  PRIMARY KEY (BID)
);

CREATE TABLE Manager(
  MID       INT(11) AUTO_INCREMENT,
  Mname    VARCHAR(25),
  Address     VARCHAR(50),
  Phno        INT(11),
  email       VARCHAR(25) unique,
  PRIMARY KEY (MID)
);

CREATE TABLE Technician(
  TID       INT(11) AUTO_INCREMENT,
  Tname    VARCHAR(25) unique,
  Address     VARCHAR(50),
  Phno        INT(11),
  email       VARCHAR(25) unique,
  PRIMARY KEY (TID)
);


CREATE TABLE BuildingTechnician(
TID       INT(11),
BID       INT(11),
FOREIGN KEY (BID) REFERENCES Building(BID),
FOREIGN KEY (TID) REFERENCES Technician(TID),
PRIMARY KEY(TID,BID)
);
CREATE TABLE Form(
FID       INT(11) AUTO_INCREMENT,
Fname       VARCHAR(15),
FQN         INT(100),
PRIMARY KEY(FID)
);
CREATE TABLE BuildingManager(
MID       INT(11),
BID       INT(11),
FOREIGN KEY (BID) REFERENCES Building(BID),
FOREIGN KEY (MID) REFERENCES Manager(MID),
PRIMARY KEY(MID,BID)
);



CREATE TABLE BuildingForm(
FID       INT(11),
BID       INT(11),
FOREIGN KEY (BID) REFERENCES Building(BID),
FOREIGN KEY (FID) REFERENCES Form(FID),
PRIMARY KEY(FID,BID)
);

CREATE TABLE TextBox (
  TextBoxID       INT(112),
  FID             INT(112),
  Typeof          VARCHAR(25),
  Question     VARCHAR(25)   NOT NULL unique,
  Min INT(112),
  Max INT(112),
  FOREIGN KEY (FID) REFERENCES Form(FID),
  PRIMARY KEY (TextBoxID,FID)
);

CREATE TABLE RadioOption (
  TextBoxID       INT(111),
  FID             INT(112),
  OptionID      INT(11),
  Optiont     VARCHAR(25)  NOT NULL,
   PRIMARY KEY (FID,TextBoxID,OptionID),
  FOREIGN KEY (FID) REFERENCES Form(FID),
  FOREIGN KEY (TextBoxID) REFERENCES TextBox(TextBoxID)
);



CREATE TABLE FormResults(
FRID        INT(11) AUTO_INCREMENT,
  RID       INT(11),
  FID       INT(11),
 TID        INT(11),
Typeof      VARCHAR(25),
Answer      VARCHAR(25),
Dateinserted       DATETIME,
 PRIMARY KEY (FRID)
);

