<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de rubriekenpagina</h2>
        <p>Op deze pagina kunt u rubrieken toevoegen.</p>
    </div>

    <div class="container">
        <h2 class="text-center">Voeg een nieuwe Rubriek toe</h2>
        <form method="post" action="">
            <input type="hidden" name="token" value="<?= $token ?>">
            <input type="hidden" name="category" value="addRubriek">

            <label class="offset-xl-3" for="addRubriekField">Nieuwe Rubriek:</label>
            <input class="form-control col-xl-6 offset-xl-3" type="text" name="newRubriek" id="addRubriekField" value="" placeholder="Nieuwe rubriek">
            <div class="text-center">
                <input class="voegRubriekToeButton form-control col-xl-2 offset-xl-5" type="submit" value="Voeg toe">
            </div>
        </form>
    </div>

    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>