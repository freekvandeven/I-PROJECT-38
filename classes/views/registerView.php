<main class="registerPagina">
    <div class="container">
        <form class="registerForm" action="" method="post">
            <h2 class="text-center">Maak een account aan.</h2>
            <?php if (isset($err)) { ?>
                <div class="errorMessage">
                    <span><?=$err?></span>
                </div>
            <?php } ?>
            <input type="hidden" name="token" value="<?=$token?>">
            <!-- ACCOUNTGEGEVENS-->
            <div class="subcontainer">
                <h5>Accountgegevens en beveiliging</h5>
                <div class="inputVelden">
                    <div class="row">
                        <!-- GEBRUIKERSNAAM -->
                        <div class="form-group col-md-6">
                            <label for="username">Gebruikersnaam *</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Uw gebruikersnaam" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>">
                        </div>
                        <!-- EMAILADRES -->
                        <div class="form-group col-md-6">
                            <label for="email">Emailadres *</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Uw emailadres"  value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <!-- WACHTWOORD 1 -->
                        <div class="form-group col-md-6">
                            <label for="password">Wachtwoord *</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Uw wachtwoord"  value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password'], ENT_QUOTES) : ''; ?>">
                        </div>

                        <!-- WACHTWOORD 2 -->
                        <div class="form-group col-md-6">
                            <label for="confirmationPassword">Herhaal wachtwoord *</label>
                            <input type="password" class="form-control" name="confirmation" id="confirmationPassword" placeholder="Herhaal uw wachtwoord"  value="<?php echo isset($_POST['confirmation']) ? htmlspecialchars($_POST['confirmation'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="row"
                        <!-- GEHEIME VRAAG -->
                        <div class="form-group col-md-6">
                            <label for="geheimeVraag">Geheime vraag *</label>
                            <select class="custom-select" name="secret-question" id="geheimeVraag"  value="<?php echo isset($_POST['secret-question']) ? htmlspecialchars($_POST['secret-question'], ENT_QUOTES) : ''; ?>">
                                <?php
                                foreach(User::getQuestions() as $question){
                                    echo "<option value='".$question['Vraagnummer']."'>".$question['TekstVraag']."</option>";
                                } ?>
                            </select>
                        </div>

                        <!-- ANTWOORD GEHEIME VRAAG -->
                        <div class="form-group col-md-6">
                            <label for="antwGeheimeVraag">Antwoord *</label>
                            <input type="text" class="form-control" name="secret-answer" id="antwGeheimeVraag" placeholder="Uw antwoord"  value="<?php echo isset($_POST['secret-answer']) ? htmlspecialchars($_POST['secret-answer'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- PERSOONLIJKE GEGEVENS-->
            <div class="subcontainer">
                <h5>Persoonlijke gegevens</h5>
                <div class="inputVelden">
                    <div class="row">
                        <!-- VOORNAAM -->
                        <div class="form-group col-md-6">
                            <label for="voornaam">Voornaam *</label>
                            <input type="text" class="form-control" name="first-name" id="voornaam" placeholder="Uw voornaam" value="<?php echo isset($_POST['first-name']) ? htmlspecialchars($_POST['first-name'], ENT_QUOTES) : ''; ?>">
                        </div>
                        <!-- ACHTERNAAM -->
                        <div class="form-group col-md-6">
                            <label for="achternaam">Achternaam *</label>
                            <input type="text" class="form-control" name="surname" id="achternaam" placeholder="Uw achternaam" value="<?php echo isset($_POST['surname']) ? htmlspecialchars($_POST['surname'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <!-- GEBOORTEDATUM -->
                        <div class="form-group col-md-6">
                            <label for="geboortedatum">Geboortedatum *</label>
                            <input type="date" class="form-control" name="birth-date" id="geboortedatum" placeholder="Uw geboortedatum" value="<?php echo isset($_POST['birth-date']) ? htmlspecialchars($_POST['birth-date'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <!-- LAND -->
                        <div class="form-group col-md-5">
                            <label for="land">Land *</label>
                            <input type="text" class="form-control" name="country" id="land" placeholder="Uw land" value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country'], ENT_QUOTES) : ''; ?>">
                        </div>
                        <!-- PLAATS -->
                        <div class="form-group col-md-5">
                            <label for="plaats">Plaats *</label>
                            <input type="text" class="form-control" name="place" id="plaats" placeholder="Uw plaats" value="<?php echo isset($_POST['place']) ? htmlspecialchars($_POST['place'], ENT_QUOTES) : ''; ?>">
                        </div>
                        <!-- POSTCODE -->
                        <div class="form-group col-md-2">
                            <label for="postcode">Postcode *</label>
                            <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Uw postcode" value="<?php echo isset($_POST['postcode']) ? htmlspecialchars($_POST['postcode'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <!-- ADRES 1 -->
                        <div class="form-group col-md-6">
                            <label for="adres1">Adres *</label>
                            <input type="text" class="form-control" name="adress" id="adres1" placeholder="Uw adres" value="<?php echo isset($_POST['adress']) ? htmlspecialchars($_POST['adress'], ENT_QUOTES) : ''; ?>">
                        </div>
                        <!-- ADRES 2 -->
                        <div class="form-group col-md-6">
                            <label for="adres2">Adres 2</label>
                            <input type="text" class="form-control" name="adress2" id="adres2" placeholder="Uw tweede adres" value="<?php echo isset($_POST['adress2']) ? htmlspecialchars($_POST['adress2'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <!-- TELEFOONNUMMER 1 -->
                        <div class="form-group col-md-6">
                            <label for="telnr1">Telefoonnummer *</label>
                            <input type="tel" class="form-control" id="telnr1" name="phone-number" placeholder="Uw telefoonnummer" value="<?php echo isset($_POST['phone-number']) ? htmlspecialchars($_POST['phone-number'], ENT_QUOTES) : ''; ?>">
                        </div>
                        <!-- TELEFOONNUMMER 2 -->
                        <div class="form-group col-md-6">
                            <label for="telnr2">Tweede telefoonnummer</label>
                            <input type="tel" class="form-control" id="telnr2" name="phone-number2" placeholder="Uw tweede telefoonnummer" value="<?php echo isset($_POST['phone-number2']) ? htmlspecialchars($_POST['phone-number2'], ENT_QUOTES) : ''; ?>">
                        </div>
                    </div>

                </div>
            </div>
            <!-- SUBMIT-KNOP -->

            <div class="gaTerugKnopBox text-center">
                <a href="login.php" class="gaTerugKnop text-center">Ik heb al een account.</a>
            </div>

            <div class="form-group text-center">
                <button class="registerButton" type="submit" name="submit" value="register">Registreer</button>
            </div>
        </form>
    </div>
</main>