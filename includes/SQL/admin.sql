DROP TABLE IF EXISTS Denied;
DROP TABLE IF EXISTS Pages;
DROP TABLE IF EXISTS Whitelist;
DROP TABLE IF EXISTS Blacklist;
DROP TABLE IF EXISTS Visitors;

CREATE TABLE Pages(
    PageName            VARCHAR(20) NOT NULL,
    Visits              INTEGER(5) NULL,
    CONSTRAINT PK_Pages     PRIMARY KEY (PageName)
);

CREATE TABLE Whitelist(
    IP                  VARCHAR(15) NOT NULL,
    Name                VARCHAR(20) NULL,
    CONSTRAINT PK_Whitelist     PRIMARY KEY (IP)
);

CREATE TABLE Blacklist(
    IP                  VARCHAR(15) NOT NULL,
    Name                VARCHAR(20) NULL,
    CONSTRAINT PK_Blacklist     PRIMARY KEY (IP)
);

CREATE TABLE Visitors(
    IP                 VARCHAR(15) NOT NULL,
    TotalVisits        INTEGER(5) NULL,
    CONSTRAINT PK_Visitors  PRIMARY KEY (IP)
);

CREATE TABLE Denied(
    IP                VARCHAR(15) NOT NULL
);

INSERT INTO Whitelist (IP, Name) VALUES ('80.100.205.64', 'Freek'), ('86.92.74.42', 'Joons');
