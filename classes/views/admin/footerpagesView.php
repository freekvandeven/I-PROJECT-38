<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de footer beheerpagina</h2>
        <p>Op deze pagina kunt u de content op de footer pagina aanpassen.</p>
    </div>

    <div id="accordion">
        <!-- item 1 -->
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Faq page beheer
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <input type="hidden" name="category" value="footerpages">
                        <label for="question">Vraag:</label><input type="text" id="question" name="question" value="">
                        <label for="answer">Antwoord:</label><input type="text" id="answer" name="answer" value="">
                        <button type="submit" name="footerUpdate" value="faq">Voeg toe</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- item 2 -->
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Vacature beheer
                    </button>
                </h5>
            </div>

            <div id="collapseTwo" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <input type="hidden" name="category" value="footerpages">
                        <label for="question">Functieomschrijving:</label><input type="text" id="question" name="question" value="">
                        <label for="answer">Vereisten:</label><input type="text" id="answer" name="answer" value="">
                        <label for="uren">Aantal uren:</label><input type="number" id="uren" name="uren" value=""><br>
                        <label for="beschrijving">Beschrijving:</label><textarea type="text" id="beschrijving" name="beschrijving" value=""></textarea>
                        <button type="submit" name="footerUpdate" value="vacature">Voeg toe</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- item 3 -->
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Adverteren beheer
                    </button>
                </h5>
            </div>

            <div id="collapseThree" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">

                </div>
            </div>
        </div>



    </div>
    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>