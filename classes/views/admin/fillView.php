<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>
    <div class="container">
    <h3>Vul de database met een csv bestand:</h3>
        <div id="loader" style="display: none;"></div>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" id="fillProgress" role="progressbar"
                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                0%
            </div>
        </div>
        <div class="text-center">
            <button class="voegRubriekToeButton form-control col-xl-2 offset-xl-5" id="databaseFillButton"  onclick="startDatabaseFill()">Start Filling</button>
            <div id="outputField"></div>
        </div>
    </div>
    <div class="gaTerugKnopBox text-center">
        <a href="admin.php" class="gaTerugKnop">Ga terug</a>
    </div>
</main>