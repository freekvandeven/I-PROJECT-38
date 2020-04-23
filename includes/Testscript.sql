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
	Voorwerp					INTEGER(20)		NOT NULL,
	Bodbedrag					VARCHAR(8)		NOT NULL,
	Gebruiker					VARCHAR(20)		NOT NULL,
	BodDag						VARCHAR(10)		NOT NULL,
	BodTijdstip					VARCHAR(10)		NOT NULL,
	CONSTRAINT PK_Bod	PRIMARY KEY	(Voorwerp, Bodbedrag)

);


CREATE TABLE Feedback(
	Voorwerp					INTEGER(20)		NOT NULL,
	SoortGebruiker				VARCHAR(20)		NOT NULL,
	Feedbacksoort				VARCHAR(20)		NOT NULL,
	Dag							VARCHAR(10)		NOT NULL,
	Tijdstip					VARCHAR(10)		NOT NULL,
	Commentaar					VARCHAR(128)		NULL,
	CONSTRAINT PK_Feedback	PRIMARY KEY	(Voorwerp, SoortGebruiker)
);


CREATE TABLE Gebruiker(
	Gebruikersnaam				VARCHAR(20)		NOT NULL,
	Voornaam					VARCHAR(20)		NOT NULL,
	Achternaam					VARCHAR(25)		NOT NULL,
	Adresregel_1				VARCHAR(25)		NOT NULL,
	Adresregel_2				VARCHAR(25)			NULL,
	Postcode					VARCHAR(7)		NOT NULL,
	Plaatsnaam					VARCHAR(15)		NOT NULL,
	Land						VARCHAR(9)		NOT NULL,
	Geboortedag					VARCHAR(10)		NOT NULL,
	Mailbox						VARCHAR(128)	NOT NULL,
	Wachtwoord					VARCHAR(128)	NOT NULL,
	Vraag						INTEGER			NOT NULL,
	Antwoordtekst				VARCHAR(10)		NOT NULL,
	Verkoper					BIT				NOT NULL,
	Action						INTEGER 		NOT NULL,
	CONSTRAINT PK_Gebruiker	PRIMARY KEY	(Gebruikersnaam)
);



CREATE TABLE GebruikersTelefoon(
	Volgnr						INTEGER			NOT NULL,
	Gebruiker					VARCHAR(20)		NOT NULL,
	Telefoon					VARCHAR(11)		NOT NULL,
	CONSTRAINT PK_GebruikersTelefoon	PRIMARY KEY	(Volgnr, Gebruiker)
);

CREATE TABLE Rubriek(
	Rubrieknummer				INTEGER(20)		NOT NULL,
	Rubrieknaam					VARCHAR(32)		NOT NULL,
	Rubriek						INTEGER(20)			NULL,
	Volgnr						INTEGER			NOT NULL,
	CONSTRAINT PK_Rubriek	PRIMARY KEY	(Rubrieknummer)
);

CREATE TABLE VoorwerpInRubriek(
	Voorwerp						INTEGER(20)			NOT NULL,
	RubriekOpLaagsteNiveau			INTEGER(20)			NOT NULL,
	CONSTRAINT PK_VoorwerpInRubriek	PRIMARY KEY	(Voorwerp, RubriekOpLaagsteNiveau)

);


CREATE TABLE Vraag(
	Vraagnummer				INTEGER				NOT NULL AUTO_INCREMENT,
	TekstVraag				VARCHAR(128)		NOT NULL,
	CONSTRAINT PK_Vraag	PRIMARY KEY	(Vraagnummer)
);

CREATE TABLE Verkoper(
	Gebruiker					VARCHAR(20) NOT NULL,
	Bank						CHAR(8)NULL,
	Bankrekening				VARCHAR(10) NULL,
	ControleOptie				CHAR(10) NOT NULL,
	Creditcard					CHAR(19) NULL,
	CONSTRAINT PK_Verkoper PRIMARY KEY (gebruiker)
);



CREATE TABLE Voorwerp(
	Voorwerpnummer				INTEGER(20)		NOT NULL AUTO_INCREMENT,
	Titel						VARCHAR(100)	NOT NULL,
	Beschrijving				VARCHAR(255)	NOT NULL,
	Startprijs					NUMERIC(19, 7)	NOT NULL,
	Betalingswijze				VARCHAR(50)		NOT NULL,
	Betalingsinstructie			CHAR(25)		NULL,
	Plaatsnaam					VARCHAR(255)	NOT NULL,
	Land						CHAR(10)		NOT NULL,
	Looptijd					CHAR(6)			NOT NULL,
	LooptijdBeginDag			DATETIME		NOT NULL,
	LooptijdBeginTijdstip		VARCHAR(8)		NOT NULL,
	Verzendkosten				NUMERIC(19, 7)	NOT NULL,
	Verzendinstructies			VARCHAR(50)		NOT NULL,
	Verkoper					VARCHAR(20)		NOT NULL,
	Koper						VARCHAR(20)		NULL,
	LooptijdEindeDag			DATETIME		NOT NULL,
	LooptijdEindeTijdstip		VARCHAR(8)		NOT NULL,
	VeilingGesloten				CHAR(4)			NOT NULL,
	Verkoopprijs				NUMERIC(19, 7)	NULL,
	CONSTRAINT PK_Voorwerpnummer PRIMARY KEY (Voorwerpnummer)

);

CREATE TABLE Bestand(
	Filenaam VARCHAR(40) NOT NULL,
	Voorwerp INTEGER(20) NOT NULL,
	CONSTRAINT PK_filenaam PRIMARY KEY (Filenaam)
);

ALTER TABLE Feedback
ADD CONSTRAINT FK_Feedback_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp(Voorwerpnummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION;

ALTER TABLE Bod
ADD CONSTRAINT FK_Bod_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp (voorwerpnummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION,
ADD CONSTRAINT FK_Bod_gebruikersnaam FOREIGN KEY (Gebruiker)
		REFERENCES Gebruiker (gebruikersnaam)
		ON UPDATE CASCADE
		ON DELETE NO ACTION;

ALTER TABLE Gebruiker
ADD CONSTRAINT FK_Gebruiker_vraagnummer FOREIGN KEY (Vraag)
		REFERENCES Vraag (vraagnummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION;

ALTER TABLE GebruikersTelefoon
ADD CONSTRAINT FK_GebruikersTelefoon_Gebruikersnaam FOREIGN KEY (Gebruiker)
		REFERENCES Gebruiker (gebruikersnaam)
		ON UPDATE CASCADE
		ON DELETE NO ACTION;

ALTER TABLE Rubriek
ADD CONSTRAINT FK_Rubriek_rubrieknummer FOREIGN KEY (Rubriek)
		REFERENCES Rubriek (rubrieknummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION;

ALTER TABLE VoorwerpInRubriek
ADD CONSTRAINT FK_VoorwerpInRubriek_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp (voorwerpnummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION,
ADD	CONSTRAINT FK_VoorwerpInRubriek_rubrieknummer FOREIGN KEY (RubriekOpLaagsteNiveau)
		REFERENCES Rubriek (rubrieknummer)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION;

ALTER TABLE Verkoper
ADD CONSTRAINT FK_Verkoper_gebruikersnaam FOREIGN KEY (Gebruiker)
		REFERENCES Gebruiker (gebruikersnaam)
		ON UPDATE CASCADE
		ON DELETE NO ACTION;

ALTER TABLE Voorwerp
ADD CONSTRAINT FK_Voorwerp_Gebruiker_Verkoper FOREIGN KEY (verkoper)
		REFERENCES Verkoper(gebruiker)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION,
ADD	CONSTRAINT FK_Voorwerp_Gebruiker_Koper FOREIGN KEY (koper)
		REFERENCES Gebruiker(gebruikersnaam)
		ON UPDATE CASCADE
		ON DELETE NO ACTION;

ALTER TABLE Bestand
ADD  CONSTRAINT FK_Bestand_voorwerpnummer FOREIGN KEY (Voorwerp)
		REFERENCES Voorwerp (voorwerpnummer)
		ON UPDATE CASCADE
		ON DELETE NO ACTION;

insert into Vraag (tekstvraag)
values('Wie kan het beste koken?');


insert into Gebruiker
values('admin', 'Herman', 'Admin', 'Adminlaan', '', '2020 IP', 'Nijmegen', 'Nederland', '01/01/2000', 'admin@han.nl',
'$2y$10$wPJCsxm9xEvJ5a2chNV2H.sRm37THtvFmZEgOkIpITdR6eKiv1LPC', 1, 'je moeder', 1 , 1);
