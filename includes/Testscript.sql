USE iproject38
GO

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
	Mailbox						VARCHAR(25)		NOT NULL,
	Wachtwoord					VARCHAR(15)		NOT NULL,
	Vraag						INTEGER			NOT NULL,
	Antwoordtekst				VARCHAR(10)		NOT NULL,
	Verkoper					Varchar(5)		NOT NULL,
	Action						INTEGER 		NOT NULL,
	CONSTRAINT PK_Gebruiker	PRIMARY KEY	(Gebruikersnaam)
);

insert into Gebruiker
values('PdeL42', 'Peter', 'de Later', 'Kastanjelaan 45','', '6666 AC', 'Heteren',
'Nederland', '01/04/1980', 'PdeL42@hotmail.com', 'WBEM1MAMV', 5, 'Poekie', 'Wel', 0 );
values('admin', 'Herman', 'Admin', 'Adminlaan', '', '2020 IP', 'Nijmegen', 'Nederland', '01/01/2000', 'admin@han.nl',
    '$2y$10$wPJCsxm9xEvJ5a2chNV2H.sRm37THtvFmZEgOkIpITdR6eKiv1LPC', 1, 'je moeder', 'Wel', 1);



