<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u de mogelijkeid om de website/server instellingen aan te passen.</p>
    </div>

    <div class="container">
        <h2 class="text-center">Reset de database:</h2>
        <form method="post" action="">
            <input type="hidden" name="token" value="<?=$token?>">
            <input type="hidden" name="category" value="reset">
            <div class="text-center">
                <input class="voegRubriekToeButton form-control col-xl-2 offset-xl-5" type="submit" value="Reset">
            </div>
        </form>
    </div>

    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>