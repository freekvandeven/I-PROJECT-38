<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de querypagina</h2>
        <p>Op deze pagina kunt u uw informatiebehoefte inzien aan de hand van een SQL-statement.</p>
    </div>

    <div class="container">
        <h2 class="text-center">Verzend uw SQL query</h2>
        <form method="post" action="">
            <input type="hidden" name="token" value="<?= $token ?>">
            <input type="hidden" name="category" value="query">

            <label class="offset-xl-3" for="queryField">SQL Query</label>
            <input class="form-control col-lg-6 offset-xl-3" type="text" name="queryString" id="queryField" value="">
            <div class="text-center">
                <input class="voegRubriekToeButton form-control col-xl-2 offset-xl-5" type="submit" value="Zoeken">
            </div>
        </form>
        <p>
            <?php if (isset($result)) {
                echo "Query: " . $_POST['queryString'] . " gave result:<br>";
                echo $result;
            } ?>
        </p>
    </div>

    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>
