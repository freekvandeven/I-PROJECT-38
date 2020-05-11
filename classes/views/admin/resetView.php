<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
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

    <div class="text-center col-lg-12">
        <p class="gaTerugKnop"><a href="admin.php">Ga terug</a></p>
    </div>
</main>