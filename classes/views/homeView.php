<?php

function displayPersonaliseren($phoneView) { // Om de tekst onder het kopje 'Personaliseren' te printen. Komt 2x voor, dus vandaar de functie.
    if (isset($_SESSION['loggedin'])) {
        $link = 'profile.php';
        $tekst = 'Laat iedereen weten wie u bent en waar u voor staat.';
    } else {
        $link = 'register.php';
        $tekst = 'Maak een account aan of log in.';
    }
    echo '<p>'.$tekst.'</p>';
    if(!$phoneView): echo '<a href="'.$link.'" class="slideshowButton">Aan de slag!</a>'; endif;
    if($phoneView): echo '<p class="buttonPhoneView"><a href="'.$link.'">Aan de slag!</a></p>'; endif;
}

function displayVeilingAanbieden($phoneView) { // Om de tekst onder het kopje 'Veiling aanbieden' te printen. Komt 2x voor, dus vandaar de functie.
    if (isset($_SESSION['loggedin'])) {
        $profile_data = User::getUser($_SESSION['name']);
        if ($profile_data['Verkoper']) {
            $tekst = 'Bied een veiling aan.';
            $link = 'addProduct.php';
        } else {
            $tekst = 'Om veilingen aan te kunnen bieden, is het noodzakelijk dat u een verkoper bent.';
            $link = 'profile.php?action=upgrade';
        }
    } else {
        $tekst = 'Om een veiling aan te bieden, is het noodzakelijk dat u bent ingelogd en een verkoper bent.';
        $link = 'register.php';
    }
    echo '<p>'.$tekst.'</p>';
    if(!$phoneView): echo '<a href="'.$link.'" class="slideshowButton">Aan de slag!</a>'; endif;
    if($phoneView): echo '<p class="buttonPhoneView"><a href="'.$link.'">Aan de slag!</a></p>'; endif;
} ?>

<main class="homePage">
     <!-- Slideshow: -->
    <div class="slideshow">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <!-- Indicatoren onderaan -->
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>


            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="5000">
                    <img src="images/homepage/foto1.jpg" class="d-block w-100" alt="Slideshow foto">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Het aanbod</h5>
                        <p>Bekijk ons grootschalig aanbod.</p>
                        <p><a href="catalogus.php" class="slideshowButton">Bekijk veilingen</a></p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="5000">
                    <img src="images/homepage/foto2.png" class="d-block w-100" alt="Slideshow foto">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Personaliseer</h5>
                        <?php displayPersonaliseren(0)?>
                    </div>
                </div>
                <div class="carousel-item" data-interval="5000">
                    <img src="images/homepage/foto3.jpg" class="d-block w-100" alt="Slideshow foto">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Veiling aanbieden</h5>
                        <?php displayVeilingAanbieden(0)?>
                    </div>
                </div>

            </div>

            <!-- Pijltjes aan de zijkanten -->
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="phoneViewContainer container">
        <div class="phoneview row">
            <div class="row col-10 offset-1">
                <div class="image col-6">
                    <img src="images/homepage/foto1.jpg" alt="Foto hoofdpagina 1">
                </div>
                <div class="text col-6">
                    <h3>Het aanbod</h3>
                    <p>Bekijk ons grootschalig aanbod.</p>
                    <p class="buttonPhoneView"><a href="catalogus.php">Aan de slag!</a></p>
                </div>
            </div>
            <div class="row col-10 offset-1">
                <div class="image col-6">
                    <img src="images/homepage/foto2.png" alt="Foto hoofdpagina 2">
                </div>
                <div class="text col-6">
                    <h3>Personaliseer</h3>
                    <?=displayPersonaliseren(1)?>
                </div>
            </div>
            <div class="row col-10 offset-1">
                <div class="image col-6">
                    <img src="images/homepage/foto3.jpg" alt="Foto hoofdpagina 3">
                </div>
                <div class="text col-6">
                    <h3>Veiling aanbieden</h3>
                    <?=displayVeilingAanbieden(1)?>
                </div>
            </div>
        </div>
    </div>

    <!-- De trending producten -->
    <div class="products">
        <h3>Bekijk hier de de meest trending producten:</h3>
        <div class="productsList">
            <?php       // orders by hotness score (10 - days left) * page views  = score,
            $items = selectFromCatalog(array(":order" => "(10-DATEDIFF_BIG(second,getdate(),LooptijdEindeTijdstip)/86400.0)*Views DESC",":offset"=>" ", ":limit" => "8"));
            generateCatalog($items);
            ?>
        </div>
    </div>
    <!-- De nieuwste producten      -->
    <div class="products">
        <h3>Bekijk hier de nieuwste producten:</h3>
        <div class="productsList">
            <?php
            $items2 = selectFromCatalog(array(":order" => "abs(datediff_BIG(second,looptijdbegintijdstip, getdate()))",":offset"=>" ", ":limit" => "8")); // orders by hotness score (10 - days left) * page views  = score,
            generateCatalog($items2,8,true);

            ?>
        </div>
    </div>

    <script type="text/javascript">
        <?php $totalItems = array_merge($items,$items2);
        $timerDates = array_column($totalItems, 'LooptijdEindeTijdstip');
        for($i=0;$i<count($timerDates);$i++){
            $timerDates[$i] = explode(".", $timerDates[$i])[0];
        }?>
        var timerDates = <?php echo json_encode($timerDates); ?>;
        initializeCountdownDates(timerDates);
        if(!countdown) { // if countdown hasn't been started
            setupCountdownTimers();
        }
    </script>
</main>
