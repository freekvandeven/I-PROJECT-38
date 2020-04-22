<main>
    <div id="register">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-10">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="registerForm" action="#" method="post">
                            <h2 class="text-center">Registreren</h2>
                            <!-- ACCOUNTGEGEVENS-->
                            <div class="container">
                                <h5>Accountgegevens en beveiliging</h5>
                                <div class="form-row">
                                    <!-- GEBRUIKERSNAAM -->
                                    <div class="form-group col-md-4">
                                        <label for="gebruikersnaam">Gebruikersnaam</label>
                                        <input type="text" class="form-control" id="gebruikersnaam" placeholder="Uw gebruikersnaam">
                                    </div>
                                    <!-- WACHTWOORD 1 -->
                                    <div class="form-group col-md-4">
                                        <label for="password1">Wachtwoord</label>
                                        <input type="password" class="form-control" id="password1" placeholder="Uw wachtwoord">
                                    </div>
                                    <!-- WACHTWOORD 2 -->
                                    <div class="form-group col-md-4">
                                        <label for="password2">Herhaal wachtwoord</label>
                                        <input type="password" class="form-control" id="password2" placeholder="Herhaal uw wachtwoord">
                                    </div>
                                    <!-- GEHEIME VRAAG -->
                                    <div class="form-group col-md-4">
                                        <label for="geheimeVraag">Geheime vraag</label>
                                        <select class="custom-select" id="geheimeVraag">
                                            <option value="1">Wie is de beste kok?</option>
                                        </select>
                                    </div>
                                    <!-- ANTWOORD GEHEIME VRAAG -->
                                    <div class="form-group col-md-4">
                                        <label for="antwGeheimeVraag">Antwoord</label>
                                        <input type="text" class="form-control" id="antwGeheimeVraag" placeholder="Uw antwoord">
                                    </div>
                                </div>
                            </div>
                            <!-- PERSOONLIJKE GEGEVENS-->
                            <div class="container">
                                <h5>Persoonlijke gegevens</h5>
                                <div class="form-row">
                                    <!-- EMAILADRES -->
                                    <div class="form-group col-md-4">
                                        <label for="email">Emailadres</label>
                                        <input type="email" class="form-control" id="email" placeholder="Uw emailadres">
                                    </div>
                                    <!-- VOORNAAM -->
                                    <div class="form-group col-md-4">
                                        <label for="voornaam">Voornaam</label>
                                        <input type="text" class="form-control" id="voornaam" placeholder="Uw voornaam">
                                    </div>
                                    <!-- ACHTERNAAM -->
                                    <div class="form-group col-md-4">
                                        <label for="achternaam">Achternaam</label>
                                        <input type="text" class="form-control" id="achternaam" placeholder="Uw achternaam">
                                    </div>
                                    <!-- GEBOORTEDATUM -->
                                    <div class="form-group col-md-4">
                                        <label for="geboortedatum">Geboortedatum</label>
                                        <input type="date" class="form-control" id="geboortedatum" placeholder="Uw geboortedatum">
                                    </div>
                                    <!-- TELEFOONNUMMER 1 -->
                                    <div class="form-group col-md-4">
                                        <label for="telnr1">Telefoonnummer</label>
                                        <input type="tel" class="form-control" id="telnr1" placeholder="Uw telefoonnummer">
                                    </div>
                                    <!-- TELEFOONNUMMER 2 -->
                                    <div class="form-group col-md-4">
                                        <label for="telnr2">Tweede telefoonnummer</label>
                                        <input type="tel" class="form-control" id="telnr2" placeholder="Uw tweede telefoonnummer">
                                    </div>
                                    <!-- ADRES 1 -->
                                    <div class="form-group col-md-6">
                                        <label for="adres1">Adres</label>
                                        <input type="text" class="form-control" id="adres1" placeholder="Uw adres">
                                    </div>
                                    <!-- ADRES 2 -->
                                    <div class="form-group col-md-6">
                                        <label for="adres2">Adres 2</label>
                                        <input type="text" class="form-control" id="adres2" placeholder="Uw tweede adres">
                                    </div>
                                    <!-- LAND -->
                                    <div class="form-group col-md-5">
                                        <label for="land">Land</label>
                                        <input type="text" class="form-control" id="land" placeholder="Uw land">
                                    </div>
                                    <!-- PLAATS -->
                                    <div class="form-group col-md-5">
                                        <label for="plaats">Plaats</label>
                                        <input type="text" class="form-control" id="plaats" placeholder="Uw plaats">
                                    </div>
                                    <!-- POSTCODE -->
                                    <div class="form-group col-md-2">
                                        <label for="postcode">Postcode</label>
                                        <input type="text" class="form-control" id="postcode" placeholder="Uw postcode">
                                    </div>
                                </div>
                            </div>
                            <!-- SUBMIT-KNOP -->

                            <div class="form-group text-center">
                                <a href="login.php"><p>Ik heb al een account.</p></a><br>
                                <input type="submit" name="submit" value="Registreer">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>