<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de activieitpagina</h2>
        <p>Op deze pagina kunt u de activiteit van de gebruikers inzien.</p>
    </div>

    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <h2 class="text-center">Bekijk de gebruikers statistieken:</h2>
        <?php
        $uniqueVisitors = Admin::getUniqueVisitors();
        $users = User::getUsers();
        ?>
        <p>We hebben <?=count($uniqueVisitors)?> unieke bezoekers op de website</p>
        <p>We hebben <?=count($users)?> geregistreerde gebruikers op de website</p>
    </div>

    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>