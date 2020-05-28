CREATE TABLE Bod
(
    Voorwerp    INTEGER        NOT NULL,
    Bodbedrag   NUMERIC(15, 2) NOT NULL,
    Gebruiker   VARCHAR(20)    NULL,
    BodTijdstip DATETIME       NOT NULL,
    CONSTRAINT PK_Bod PRIMARY KEY (Voorwerp, Bodbedrag)
);

CREATE TABLE KeyWords
(
    KeyWordNummer INTEGER AUTO_INCREMENT UNIQUE NOT NULL,
    KeyWord       VARCHAR(40)                   NOT NULL,
    CONSTRAINT PK_Keyword PRIMARY KEY (KeyWord)
);

CREATE TABLE KeyWordsLink
(
    KeywordNummer  INTEGER NOT NULL,
    VoorwerpNummer INTEGER NOT NULL,
    CONSTRAINT PK_KeyWordsLink PRIMARY KEY (KeyWordNummer, VoorwerpNummer)
);

CREATE TABLE Feedback
(
    Voorwerp       INTEGER      NOT NULL,
    SoortGebruiker VARCHAR(20)  NOT NULL,
    Feedbacksoort  VARCHAR(20)  NOT NULL,
    Datum          DATETIME     NOT NULL,
    Commentaar     VARCHAR(128) NULL,
    CONSTRAINT PK_Feedback PRIMARY KEY (Voorwerp, SoortGebruiker)
);

CREATE TABLE Gebruiker
(
    Gebruikersnaam VARCHAR(20)    NOT NULL,
    Voornaam       VARCHAR(40)    NOT NULL,
    Achternaam     VARCHAR(40)    NOT NULL,
    Adresregel_1   VARCHAR(50)    NOT NULL,
    Adresregel_2   VARCHAR(50)    NULL,
    Postcode       VARCHAR(7)     NOT NULL,
    Plaatsnaam     VARCHAR(50)    NOT NULL,
    Land           VARCHAR(50)    NOT NULL,
    Latitude       DECIMAL(10, 8) NULL,
    Longitude      DECIMAL(11, 8) NULL,
    Geboortedag    VARCHAR(10)    NOT NULL,
    Mailbox        VARCHAR(128)   NOT NULL,
    Wachtwoord     VARCHAR(128)   NOT NULL,
    Vraag          TINYINT        NOT NULL,
    Antwoordtekst  VARCHAR(20)    NOT NULL,
    Verkoper       BIT            NOT NULL,
    Action         BIT            NOT NULL,
    Bevestiging    BIT            NOT NULL,
    CONSTRAINT PK_Gebruiker PRIMARY KEY (Gebruikersnaam)
);

CREATE TABLE GebruikersInstellingen
(
    Gebruiker       VARCHAR(20) NOT NULL DEFAULT false,
    reccomendations BIT         NOT NULL DEFAULT false,
    darkmode        BIT         NOT NULL DEFAULT false,
    notifications   BIT         NOT NULL DEFAULT false,
    superTracking   BIT         NOT NULL DEFAULT false,
    emails          BIT         NOT NULL DEFAULT false,
    constraint PK_GebruikersInstellingen_Gebruiker PRIMARY KEY (Gebruiker)
);

CREATE TABLE Beoordeling
(
    BeoordelingsNr INTEGER     NOT NULL AUTO_INCREMENT,
    Gebruikersnaam VARCHAR(20) NULL,
    GegevenDoor    VARCHAR(20) NULL,
    Rating         NUMERIC(1)  NOT NULL,
    CONSTRAINT PK_Beoordeling PRIMARY KEY (BeoordelingsNr)
);

CREATE TABLE Comments
(
    FeedBackNr     INTEGER      NOT NULL,
    Gebruikersnaam VARCHAR(20)  NULL,
    FeedbackGever  VARCHAR(20)  NULL,
    Feedback       VARCHAR(255) NOT NULL,
    CONSTRAINT PK_Comments PRIMARY KEY (FeedBackNr)
);

CREATE TABLE Favorieten
(
    Gebruiker VARCHAR(20) NOT NULL,
    Voorwerp  INTEGER     NOT NULL,
    CONSTRAINT PK_Favorieten PRIMARY KEY (Gebruiker, Voorwerp)
);

CREATE TABLE GebruikersTelefoon
(
    Volgnr    INTEGER     NOT NULL AUTO_INCREMENT,
    Gebruiker VARCHAR(20) NOT NULL,
    Telefoon  VARCHAR(11) NOT NULL UNIQUE,
    CONSTRAINT PK_GebruikersTelefoon PRIMARY KEY (Volgnr, Gebruiker, Telefoon)
);

CREATE TABLE Rubriek
(
    Rubrieknummer INTEGER     NOT NULL,
    Rubrieknaam   VARCHAR(32) NOT NULL,
    Rubriek       INTEGER     NULL,
    Volgnr        INTEGER     NOT NULL,
    CONSTRAINT PK_Rubriek PRIMARY KEY (Rubrieknummer)
);

CREATE TABLE VoorwerpInRubriek
(
    Voorwerp               INTEGER NOT NULL,
    RubriekOpLaagsteNiveau INTEGER NOT NULL,
    CONSTRAINT PK_VoorwerpInRubriek PRIMARY KEY (Voorwerp, RubriekOpLaagsteNiveau)
);

CREATE TABLE Vraag
(
    Vraagnummer TINYINT      NOT NULL AUTO_INCREMENT,
    TekstVraag  VARCHAR(128) NOT NULL,
    CONSTRAINT PK_Vraag PRIMARY KEY (Vraagnummer)
);

CREATE TABLE Verkoper
(
    Gebruiker     VARCHAR(20) NOT NULL,
    Bank          VARCHAR(40) NULL,
    Bankrekening  VARCHAR(10) NULL,
    ControleOptie CHAR(10)    NOT NULL,
    Creditcard    CHAR(19)    NULL,
    CONSTRAINT PK_Verkoper PRIMARY KEY (Gebruiker)
);

CREATE TABLE Voorwerp
(
    Voorwerpnummer        INTEGER        NOT NULL AUTO_INCREMENT,
    Titel                 VARCHAR(100)   NOT NULL,
    Beschrijving          VARCHAR(4000)  NOT NULL,
    Startprijs            NUMERIC(15, 2) NOT NULL,
    Betalingswijze        VARCHAR(50)    NOT NULL,
    Betalingsinstructie   CHAR(25)       NULL,
    Plaatsnaam            VARCHAR(60)    NOT NULL,
    Land                  VARCHAR(50)    NOT NULL,
    LooptijdBeginTijdstip DATETIME       NOT NULL,
    Verzendkosten         NUMERIC(19, 2) NOT NULL,
    Verzendinstructies    VARCHAR(50)    NULL,
    Verkoper              VARCHAR(20)    NULL,
    Koper                 VARCHAR(20)    NULL,
    LooptijdEindeTijdstip DATETIME       NOT NULL,
    VeilingGesloten       BIT            NOT NULL,
    Verkoopprijs          NUMERIC(15, 2) NULL,
    Views                 INTEGER DEFAULT 0,
    CONSTRAINT PK_Voorwerpnummer PRIMARY KEY (Voorwerpnummer)
);

CREATE TABLE Bestand
(
    Filenaam VARCHAR(40) NOT NULL,
    Voorwerp INTEGER     NOT NULL,
    CONSTRAINT PK_filenaam PRIMARY KEY (Filenaam)
);

CREATE TABLE Notificaties
(
    Bericht   VARCHAR(256) NOT NULL,
    Link      VARCHAR(64) DEFAULT '#',
    Ontvanger VARCHAR(20)  NOT NULL,
    CONSTRAINT PK_Notificatie PRIMARY KEY (Bericht, Link, Ontvanger)
);

CREATE TABLE Bericht
(
    Message   VARCHAR(256) NOT NULL,
    Verzender VARCHAR(20)  NOT NULL,
    Ontvanger VARCHAR(20)  NOT NULL,
    Tijdstip  DATETIME DEFAULT CURRENT_TIMESTAMP
);