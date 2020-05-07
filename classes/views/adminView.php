<?php

$bootstrapGrid = 'col-xl-4 col-md-6 col-sm-6';

?>

<main class="adminPagina">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>

    <div class="container">
        <h2>Website</h2>
        <div class="row">
            <div class="<?=$bootstrapGrid?>">
                <a href="admin.php?category=auction">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Bekijk alle veilingen</h4>
                            <img src="images/adminimages/veilingen.png" class="card-img">
                            <p>Bekijk hier een overzicht van alle veilingen.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="<?=$bootstrapGrid?>">
                <a href="admin.php?category=user">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Bekijk alle gebruikers</h4>
                            <img src="images/adminimages/gebruikers.png" class="card-img">
                            <p>Bekijk hier een overzicht van alle gebruikers.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="<?=$bootstrapGrid?>">
                <a href="admin.php?category=seller">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Bekijk alle verkopers</h4>
                            <img src="images/adminimages/verkopers.png" class="card-img">
                            <p>Bekijk hier een overzicht van alle verkopers.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="<?=$bootstrapGrid?>">
                <a href="admin.php?category=statistics">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Bekijk website statistieken</h4>
                            <img src="images/adminimages/statistieken.png" class="card-img">
                            <p>Bekijk hier de statistieken van de website.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="<?=$bootstrapGrid?>">
                <a href="admin.php?category=addRubriek">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Voeg een rubriek toe</h4>
                            <img src="images/adminimages/rubrieken.png" class="card-img">
                            <p>Op deze pagina is het mogelijk om een rubriek toe te voegen.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <h2>Database</h2>
        <div class="row">
            <div class="<?=$bootstrapGrid?>">
                <a href="admin.php?category=reset">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Reset de database</h4>
                            <img src="images/adminimages/reset.png" class="card-img">
                            <p>Op deze pagina is het mogelijk om de database te resetten.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="<?=$bootstrapGrid?>">
                <a href="admin.php?category=query">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">MS SQL Server Query Editor</h4>
                            <img src="images/adminimages/query.png" class="card-img">
                            <p>Bekijk hier het resultaat van uw MS SQL Server query</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

<!--    <ul>-->
<!--        <li><a href="admin.php?category=auction">Bekijk veilingen</a></li>-->
<!--        <li><a href="admin.php?category=user">Bekijk gebruikers</a></li>-->
<!--        <li><a href="admin.php?category=seller">Bekijk verkopers</a></li>-->
<!--        <li><a href="admin.php?category=statistics">Bekijk pagina statistieken</a></li>-->
<!--        <li><a href="admin.php?category=reset">Reset Database</a></li>-->
<!--        <li><a href="admin.php?category=fill">Vul database met CSV bestand</a></li>-->
<!--        <li><a href="admin.php?category=query">MS SQL Server Query Editor</a></li>-->
<!--        <li><a href="admin.php?category=addRubriek">Voeg een Rubriek toe</a></li>-->
<!--    </ul>-->
</main>