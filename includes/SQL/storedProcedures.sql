CREATE PROCEDURE voorwerpRubriekInsert (
    @Voorwerp INT,
    @Rubriek INT
)
AS
BEGIN
    INSERT INTO VoorwerpInRubriek VALUES(@Voorwerp, @Rubriek)
END;

CREATE PROCEDURE fileInsert(
    @file VARCHAR(40),
    @voorwerp INT
)
AS
BEGIN
    INSERT INTO Bestand VALUES (@file, @voorwerp)
END;

/*
CREATE PROCEDURE rubriekInsert

END;

CREATE PROCEDURE itemInsert ()
AS

Titel, Beschrijving, Startprijs, Betalingswijze, Plaatsnaam, Land, LooptijdBeginTijdstip, Verzendkosten,Verzendinstructies, Verkoper, LooptijdEindeTijdstip, VeilingGesloten
 */