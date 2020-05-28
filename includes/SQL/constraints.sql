ALTER TABLE Bericht
    ADD CONSTRAINT FK_Bericht_Verzender FOREIGN KEY (Verzender)
        REFERENCES Gebruiker(Gebruikersnaam)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE Notificaties
    ADD CONSTRAINT FK_Notificatie_ontvanger FOREIGN KEY (Ontvanger)
        REFERENCES Gebruiker(Gebruikersnaam)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE Feedback
    ADD CONSTRAINT FK_Feedback_voorwerpnummer FOREIGN KEY (Voorwerp)
        REFERENCES Voorwerp(Voorwerpnummer)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE Comments
    ADD CONSTRAINT FK_Comments_gebruiker FOREIGN KEY (Gebruikersnaam)
        REFERENCES Gebruiker(Gebruikersnaam)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE Comments
    ADD CONSTRAINT FK_Comments_gever FOREIGN KEY (Gebruikersnaam)
        REFERENCES Gebruiker(Gebruikersnaam)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION;

Alter TABLE Favorieten
    ADD CONSTRAINT FK_Favorieten_voorwerpnummer FOREIGN KEY (Voorwerp)
        REFERENCES Voorwerp (voorwerpnummer)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION;

ALTER TABLE Bod
    ADD CONSTRAINT FK_Bod_voorwerpnummer FOREIGN KEY (Voorwerp)
        REFERENCES Voorwerp (voorwerpnummer)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE Bod
    ADD CONSTRAINT FK_Bod_gebruikersnaam FOREIGN KEY (Gebruiker)
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
        ON UPDATE CASCADE
        ON DELETE CASCADE;

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
        ON DELETE NO ACTION;

ALTER TABLE Voorwerp
    ADD CONSTRAINT FK_Voorwerp_Gebruiker_Koper FOREIGN KEY (koper)
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

ALTER TABLE GebruikersInstellingen
    ADD CONSTRAINT FK_Gebruiker_GebruikersInstellingen FOREIGN KEY (Gebruiker)
        REFERENCES Gebruiker(Gebruikersnaam)
        ON UPDATE CASCADE
        ON DELETE CASCADE;

ALTER TABLE KeyWordsLink
    ADD CONSTRAINT FK_KeyWordNummer_Keyword FOREIGN KEY (KeyWordNummer) REFERENCES KeyWords(KeyWordNummer)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION