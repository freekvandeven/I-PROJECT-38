<main>
    <div id="register">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-10">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="registerForm" action="" method="post">
                            <h2 class="text-center">Registreren</h2>
                            <?php if(isset($err))echo $err;?>
                            <input type="hidden" name="token" value="<?=$token?>">
                            <!-- ACCOUNTGEGEVENS-->
                            <div class="container">
                                <h5>Accountgegevens en beveiliging</h5>
                                <div class="form-row">
                                    <!-- GEBRUIKERSNAAM -->
                                    <div class="form-group col-md-4">
                                        <label for="username">Gebruikersnaam</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Uw gebruikersnaam">
                                    </div>
                                    <!-- WACHTWOORD 1 -->
                                    <div class="form-group col-md-4">
                                        <label for="password">Wachtwoord</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Uw wachtwoord">
                                    </div>
                                    <!-- WACHTWOORD 2 -->
                                    <div class="form-group col-md-4">
                                        <label for="confirmationPassword">Herhaal wachtwoord</label>
                                        <input type="password" class="form-control" name="confirmation" id="confirmationPassword" placeholder="Herhaal uw wachtwoord">
                                    </div>

                                    <!-- GEHEIME VRAAG -->
                                    <div class="form-group col-md-4">
                                        <label for="geheimeVraag">Geheime vraag</label>
                                        <select class="custom-select" name="secret-question" id="geheimeVraag">
                                            <?php
                                            foreach(User::getQuestions() as $question){
                                                echo "<option value='".$question['Vraagnummer']."'>".$question['TekstVraag']."</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <!-- ANTWOORD GEHEIME VRAAG -->
                                    <div class="form-group col-md-4">
                                        <label for="antwGeheimeVraag">Antwoord</label>
                                        <input type="text" class="form-control" name="secret-answer" id="antwGeheimeVraag" placeholder="Uw antwoord">
                                    </div>
                                </div>
                            </div>
                            <!-- PERSOONLIJKE GEGEVENS-->
                            <div class="container">
                                <h5>Persoonlijke gegevens</h5>
                                <div class="form-row test-row">
                                    <!-- EMAILADRES -->
                                    <div class="form-group col-md-4">
                                        <label for="email">Emailadres</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Uw emailadres">
                                    </div>
                                    <!-- VOORNAAM -->
                                    <div class="form-group col-md-4">
                                        <label for="voornaam">Voornaam</label>
                                        <input type="text" class="form-control" name="first-name" id="voornaam" placeholder="Uw voornaam">
                                    </div>
                                    <!-- ACHTERNAAM -->
                                    <div class="form-group col-md-4">
                                        <label for="achternaam">Achternaam</label>
                                        <input type="text" class="form-control" name="surname" id="achternaam" placeholder="Uw achternaam">
                                    </div>
                                    <!-- GEBOORTEDATUM -->
                                    <div class="form-group col-md-4">
                                        <label for="geboortedatum">Geboortedatum</label>
                                        <input type="date" class="form-control" name="birth-date" id="geboortedatum" placeholder="Uw geboortedatum">
                                    </div>
                                    <!-- TELEFOONNUMMER 1 -->
                                        <div class="form-group col-md-4 telephone">
                                            <label for="telnr1">Telefoonnummer</label>
                                            <input type="tel" class="form-control" id="telnr1" name="phone-number" placeholder="Uw telefoonnummer">
                                        </div>
                                        <div class="form-group col-md-4">
                                        <button class="add_form_field">Extra telefoonnummer
                                            <span style="font-size:16px; font-weight:bold;">+ </span>
                                        </button>
                                        </div>
                                    <!-- TELEFOONNUMMER 2 -->
                                    <!--
                                    <div class="form-group col-md-4">
                                        <label for="telnr2">Tweede telefoonnummer</label>
                                        <input type="tel" class="form-control" id="telnr2" name="phone-number2" placeholder="Uw tweede telefoonnummer">
                                    </div> -->
                                    <!-- ADRES 1 -->
                                    <div class="form-group col-md-6">
                                        <label for="adres1">Adres</label>
                                        <input type="text" class="form-control" name="adress" id="adres1" placeholder="Uw adres">
                                    </div>
                                    <!-- ADRES 2 -->
                                    <div class="form-group col-md-6">
                                        <label for="adres2">Adres 2</label>
                                        <input type="text" class="form-control" name="adress2" id="adres2" placeholder="Uw tweede adres">
                                    </div>
                                    <!-- LAND -->
                                    <div class="form-group col-md-5">
                                        <label for="land">Land</label>
                                        <input type="text" class="form-control" name="country" id="land" placeholder="Uw land">
                                    </div>
                                    <!-- PLAATS -->
                                    <div class="form-group col-md-5">
                                        <label for="plaats">Plaats</label>
                                        <input type="text" class="form-control" name="place" id="plaats" placeholder="Uw plaats">
                                    </div>
                                    <!-- POSTCODE -->
                                    <div class="form-group col-md-2">
                                        <label for="postcode">Postcode</label>
                                        <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Uw postcode">
                                    </div>
                                </div>
                            </div>
                            <!-- SUBMIT-KNOP -->

                            <div class="form-group text-center">
                                <a href="login.php"><p>Ik heb al een account.</p></a><br>
                                <button class="registerButton" type="submit" name="submit" value="register">Registreer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>

    $(document).ready(function() {
        var max_fields = 5;
        var wrapper = $(".test-row");
        var add_button = $(".add_form_field");
        Element.prototype.appendAfter = function (element) {
            element.parentNode.insertBefore(this, element.nextSibling);
        }, false;
        var x = 1;
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                alert("test");
                x++;
                var lastDiv = document.querySelectorAll(".telephone:last-child")
                var newTelephone = document.createElement('div');
                newTelephone.innerHTML = '<div class="form-group col-md-4"><label for="telnr1">Telefoonnummer</label><input type="tel" class="form-control" id="telnr1" name="phone-number" placeholder="Uw telefoonnummer"><a href="#" class="delete">Delete</a></div>'
                newTelephone.appendAfter(lastDiv);
                //lastDiv.parentNode.insertBefore(newTelephone, lastDiv.nextSibling);
                /*
                $(wrapper).append('<div class="form-group col-md-4">\n' +
                    '                                        <label for="telnr1">Telefoonnummer ' + x  + '</label>\n' +
                    '                                        <input type="tel" class="form-control" id="telnr1" name="phone-number" placeholder="Uw telefoonnummer">\n' +
                    '                                    ' +
                    '<a href="#" class="delete">Delete</a></div>'); //add input box

                 */
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });
</script>