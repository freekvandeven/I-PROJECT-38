DROP TABLE IF EXISTS Favorieten;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Beoordeling;
DROP TABLE IF EXISTS Bod;
DROP TABLE IF EXISTS Feedback;
DROP TABLE IF EXISTS Bestand;
DROP TABLE IF EXISTS VoorwerpInRubriek;
DROP TABLE IF EXISTS Rubriek;
DROP TABLE IF EXISTS Voorwerp;
DROP TABLE IF EXISTS Verkoper;
DROP TABLE IF EXISTS GebruikersTelefoon;
DROP TABLE IF EXISTS Gebruiker;
DROP TABLE IF EXISTS Vraag;



CREATE TABLE Bod(
	Voorwerp					INTEGER      	NOT NULL,
	Bodbedrag					NUMERIC(15,2)	NOT NULL,
	Gebruiker					VARCHAR(20)		NULL,
	BodTijdstip					DATETIME		NOT NULL,
	CONSTRAINT PK_Bod	PRIMARY KEY	(Voorwerp, Bodbedrag)
);


CREATE TABLE Feedback(
	Voorwerp					INTEGER      	NOT NULL,
	SoortGebruiker				VARCHAR(20)		NOT NULL,
	Feedbacksoort				VARCHAR(20)		NOT NULL,
	Datum						DATETIME		NOT NULL,
	Commentaar					VARCHAR(128)		NULL,
	CONSTRAINT PK_Feedback	PRIMARY KEY	(Voorwerp, SoortGebruiker)
);


CREATE TABLE Gebruiker(
	Gebruikersnaam				VARCHAR(20)		NOT NULL,
	Voornaam					VARCHAR(40)		NOT NULL,
	Achternaam					VARCHAR(40)		NOT NULL,
	Adresregel_1				VARCHAR(50)		NOT NULL,
	Adresregel_2				VARCHAR(50)			NULL,
	Postcode					VARCHAR(7)		NOT NULL,
	Plaatsnaam					VARCHAR(50)		NOT NULL,
	Land						VARCHAR(50)		NOT NULL,
	Latitude                    DECIMAL(10, 8)      NULL,
	Longitude                   DECIMAL(11, 8)      NULL,
	Geboortedag					VARCHAR(10)		NOT NULL,
	Mailbox						VARCHAR(128)	NOT NULL,
	Wachtwoord					VARCHAR(128)	NOT NULL,
	Vraag						TINYINT 		NOT NULL,
	Antwoordtekst				VARCHAR(20)		NOT NULL,
	Verkoper					BIT				NOT NULL,
	Action						BIT 		    NOT NULL,
	Bevestiging                 BIT             NOT NULL,
	CONSTRAINT PK_Gebruiker	PRIMARY KEY	(Gebruikersnaam)
);

CREATE TABLE Beoordeling (
    BeoordelingsNr 				INTEGER      	NOT NULL IDENTITY,
    Gebruikersnaam              VARCHAR(20)     NULL,
    GegevenDoor                 VARCHAR(20)     NULL,
    Rating                      NUMERIC(1)      NOT NULL,
    CONSTRAINT PK_Beoordeling PRIMARY KEY(BeoordelingsNr)
);

CREATE TABLE Comments (
    FeedBackNr                  INTEGER         NOT NULL IDENTITY,
    Gebruikersnaam              VARCHAR(20)     NULL,
    FeedbackGever               VARCHAR(20)     NULL,
    Feedback                    VARCHAR(255)    NOT NULL,
    CONSTRAINT PK_Comments PRIMARY KEY(FeedBackNr)
);

CREATE TABLE Favorieten (
    Gebruiker                  INTEGER     NOT NULL,
    Voorwerp                   VARCHAR(20) NOT NULL,
    CONSTRAINT PK_Favorieten PRIMARY KEY(Gebruiker, Voorwerp)
);

CREATE TABLE GebruikersTelefoon(
	Volgnr						INTEGER	        NOT NULL IDENTITY,
	Gebruiker					VARCHAR(20)		NOT NULL,
	Telefoon					VARCHAR(11)		NOT NULL UNIQUE,
	CONSTRAINT PK_GebruikersTelefoon	PRIMARY KEY	(Gebruiker, Telefoon)
);

CREATE TABLE Rubriek(
    Rubrieknummer				INTEGER          	NOT NULL,
    Rubrieknaam					VARCHAR(32)		    NOT NULL,
    Rubriek						INTEGER 			NULL,
    Volgnr						INTEGER             NOT NULL IDENTITY,
    CONSTRAINT PK_Rubriek PRIMARY KEY (Rubrieknummer)
);

CREATE TABLE VoorwerpInRubriek(
	Voorwerp						INTEGER 			NOT NULL IDENTITY,
	RubriekOpLaagsteNiveau			INTEGER 			NOT NULL,
	CONSTRAINT PK_VoorwerpInRubriek	PRIMARY KEY	(Voorwerp, RubriekOpLaagsteNiveau)
);

CREATE TABLE Vraag(
	Vraagnummer				TINYINT		        NOT NULL IDENTITY,
	TekstVraag				VARCHAR(128)		NOT NULL,
	CONSTRAINT PK_Vraag	PRIMARY KEY	(Vraagnummer)
);

CREATE TABLE Verkoper(
	Gebruiker					VARCHAR(20) NOT NULL,
	Bank						VARCHAR(40)     NULL,
	Bankrekening				VARCHAR(10)     NULL,
	ControleOptie				CHAR(10)    NOT NULL,
	Creditcard					CHAR(19)        NULL,
	CONSTRAINT PK_Verkoper PRIMARY KEY (gebruiker)
);



CREATE TABLE Voorwerp(
	Voorwerpnummer				INTEGER 		NOT NULL IDENTITY,
	Titel						VARCHAR(100)	NOT NULL,
	Beschrijving				VARCHAR(4000)	NOT NULL,
	Startprijs					NUMERIC(15, 2)	NOT NULL,
	Betalingswijze				VARCHAR(50)		NOT NULL,
	Betalingsinstructie			CHAR(25)		NULL,
	Plaatsnaam					VARCHAR(60) 	NOT NULL,
	Land						VARCHAR(50)		NOT NULL,
	LooptijdBeginTijdstip		DATETIME		NOT NULL,
	Verzendkosten				NUMERIC(19, 2)	NOT NULL,
	Verzendinstructies			VARCHAR(50)		NULL,
	Verkoper					VARCHAR(20)		NULL,
	Koper						VARCHAR(20)		NULL,
	LooptijdEindeTijdstip		DATETIME		NOT NULL,
	VeilingGesloten			    BIT			    NOT NULL,
	Verkoopprijs				NUMERIC(15, 2)	NULL,
	Views                       INTEGER         DEFAULT 0,
	CONSTRAINT PK_Voorwerpnummer PRIMARY KEY (Voorwerpnummer)
);

CREATE TABLE Bestand(
	Filenaam VARCHAR(40) NOT NULL,
	Voorwerp INTEGER     NOT NULL,
	CONSTRAINT PK_filenaam PRIMARY KEY (Filenaam)
);

ALTER TABLE Feedback
ADD CONSTRAINT FK_Feedback_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp(Voorwerpnummer)
		ON UPDATE CASCADE
		ON DELETE CASCADE;

ALTER TABLE Comments
ADD CONSTRAINT FK_Comments_gebruiker FOREIGN KEY (Gebruikersnaam)
        REFERENCES Gebruiker(Gebruikersnaam)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
CONSTRAINT FK_Comments_gever FOREIGN KEY (Gebruikersnaam)
        REFERENCES Gebruiker(Gebruikersnaam)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION;

Alter TABLE Favorieten
ADD CONSTRAINT FK_Favorieten_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp (voorwerpnummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION,

ALTER TABLE Bod
ADD CONSTRAINT FK_Bod_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp (voorwerpnummer)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
CONSTRAINT FK_Bod_gebruikersnaam FOREIGN KEY (Gebruiker)
		REFERENCES Gebruiker (gebruikersnaam)
		ON UPDATE CASCADE
		ON DELETE CASCADE;

ALTER TABLE Gebruiker
ADD CONSTRAINT FK_Gebruiker_vraagnummer FOREIGN KEY (Vraag)
		REFERENCES Vraag (vraagnummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION;

ALTER TABLE GebruikersTelefoon
ADD CONSTRAINT FK_GebruikersTelefoon_Gebruikersnaam FOREIGN KEY (Gebruiker)
		REFERENCES Gebruiker (gebruikersnaam)
		ON UPDATE CASCADE
		ON DELETE CASCADE;

ALTER TABLE VoorwerpInRubriek
ADD CONSTRAINT FK_VoorwerpInRubriek_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp (voorwerpnummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION;

ALTER TABLE VoorwerpInRubriek
ADD	CONSTRAINT FK_VoorwerpInRubriek_rubrieknummer FOREIGN KEY (RubriekOpLaagsteNiveau)
		REFERENCES Rubriek (Rubrieknummer)
		ON UPDATE CASCADE
		ON DELETE CASCADE;

ALTER TABLE Verkoper
ADD CONSTRAINT FK_Verkoper_gebruikersnaam FOREIGN KEY (Gebruiker)
		REFERENCES Gebruiker (gebruikersnaam)
		ON UPDATE CASCADE
		ON DELETE CASCADE;

ALTER TABLE Voorwerp
ADD CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper FOREIGN KEY (verkoper)
		REFERENCES Verkoper(gebruiker)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION,
CONSTRAINT FK_Voorwerp_Gebruiker_Koper FOREIGN KEY (koper)
		REFERENCES Gebruiker(gebruikersnaam)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION;

ALTER TABLE Bestand
ADD  CONSTRAINT FK_Bestand_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp (voorwerpnummer)
		ON UPDATE CASCADE
		ON DELETE CASCADE;

ALTER TABLE Rubriek
ADD CONSTRAINT FK_ParentRubriek FOREIGN KEY (Rubriek)
        REFERENCES Rubriek (Rubrieknummer)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION;

insert into Vraag (tekstvraag)
values(
       'Wie kan het beste koken?'),(
       'Wat is je geboorteplaats?'
       );


insert into Gebruiker
values('admin', 'Herman', 'Admin', 'Adminlaan', '', '2020 IP', 'Nijmegen', 'Nederland', '51.9238772', '5.7104402' '01/01/2000', 'admin@han.nl',
'$2y$10$wPJCsxm9xEvJ5a2chNV2H.sRm37THtvFmZEgOkIpITdR6eKiv1LPC', 1, 'je moeder', 0, 1, 1);

insert into Rubriek (RubriekNaam, Rubrieknummer)values(
'Autos, boten en motoren',1),(
'Baby',	2),(
'Muziek en instrumenten',3),(
'Elektronica',4),(
'Mode',	5);


