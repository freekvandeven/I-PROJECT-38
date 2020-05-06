<main>
    <!-- Welkom tekst: -->
    <div class="contactpaginaJumbotron jumbotron">
        <h2 class="display-5">Welkom op de contactpagina van EenmaalAndermaal</h2>
    </div>

    <div class="container">
        <h4 class="contactpaginaWelkom text-center font-weight-normal">Heeft u vragen en/of feedback? Vul hieronder het formulier in.</h4>
        <h5 class="text-center font-weight-normal">Wij proberen zo snel mogelijk te antwoorden.</h5>

        <form class="contactpaginaFormulier text-center" method="POST" action="">
            <input type="hidden" name="token" value="<?=$token?>">
            <div class="form-row text-left">
                <div class="form-group col-lg-3 col-md-6 ">
                    <label for="voornaam">Voornaam</label>
                    <input type="text" name="first-name" id="voornaam" class="form-control" placeholder="Uw voornaam" autofocus required>
                </div>

                <div class="form-group col-lg-4 col-md-6">
                    <label for="achternaam">Achternaam</label>
                    <input type="text" name="surname" id="achternaam" class="form-control" placeholder="Uw achternaam" required>
                </div>

                <div class="form-group col-lg-5 col-md-12">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Uw emailadres" required>
                </div>

                <div class="form-group col-lg-12">
                    <label for="bericht">Bericht</label>
                    <textarea name="message" id="bericht" class="form-control" rows="3" placeholder="Uw vraag en/of feedback" required></textarea>
                </div>
            </div>

            <button type="button" name="submit" value="submit" class="contactpaginaButton">Verzenden</button>
        </form>
    </div>
</main>
