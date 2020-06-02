CREATE PROCEDURE voorwerpRubriekInsert (
    @Voorwerp INT,
    @Rubriek INT
)
AS
BEGIN
    INSERT INTO VoorwerpInRubriek VALUES(@Voorwerp, @Rubriek)
END;

CREATE PROCEDURE voorwerpInsert (
    @Titel VARCHAR(100),
    @Beschrijving VARCHAR(4000),
    @Startprijs NUMERIC(15, 2),
    @Betalingswijze VARCHAR(50),
    @Plaatsnaam VARCHAR(60),
    @Land VARCHAR(50),
    @LooptijdBeginTijdstip DATETIME,
    @Verzendkosten NUMERIC(19, 2),
    @Verzendinstructies VARCHAR(50),
    @Verkoper VARCHAR(20),
    @LooptijdEindeTijdstip DATETIME,
    @VeilingGesloten BIT
)
AS
BEGIN
    INSERT INTO Voorwerp(Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeTijdstip, VeilingGesloten)
    VALUES(@Titel, @Beschrijving, @Startprijs, @Betalingswijze, @Plaatsnaam, @Land, @LooptijdBeginTijdstip, @Verzendkosten, @Verzendinstructies, @Verkoper, @LooptijdEindeTijdstip, @VeilingGesloten)
END;

CREATE PROCEDURE fileInsert(
    @file VARCHAR(40),
    @voorwerp INT
)
AS
BEGIN
    INSERT INTO Bestand VALUES (@file, @voorwerp)
END;

CREATE PROCEDURE KeyWordInsert(
    @text VARCHAR(40)
)
AS
BEGIN
    INSERT INTO KeyWords VALUES (@text)
END;

CREATE PROCEDURE KeyWordLinkInsert(
    @KeyWordNr INT,
    @VoorwerpNummer INT
)
AS
BEGIN
    INSERT INTO KeyWordsLink VALUES (@KeyWordNr,@VoorwerpNummer)
END;

CREATE PROCEDURE getKeyWordId(
    @KeyWord varchar(40)
)
AS
BEGIN
    SELECT KeyWordNummer From KeyWords WHERE  KeyWord = @KeyWord
END;


/*
CREATE PROCEDURE rubriekInsert

END;

CREATE PROCEDURE itemInsert ()
AS

Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeTijdstip, VeilingGesloten
 */