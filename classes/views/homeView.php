<main class="homePage">
    <!-- Slideshow: -->
    <div class="slideshow">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <!-- De navigatie onderaan: -->
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>

            <!-- De items in de slideshow zelf: -->
            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="5000">
                    <img src="images/foto2.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="sliderLinks" href="#"><h3>Bekijk het aanbod</h3></a>
                        <p>Bied op gebruikte producten en verkoop uw gebruikte producten</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="5000">
                    <img src="images/foto3.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="sliderLinks" href="#"><h3>Personaliseer</h3></a>
                        <p>Maak een account aan of log in.</p>
                    </div>
                </div>
                <div class="carousel-item" data-interval="5000">
                    <img src="images/foto1.jpg" class="d-block w-100" alt="Veiling">
                    <div class="carousel-caption d-none d-md-block">
                        <a class="sliderLinks" href="#"><h3>Over ons</h3></a>
                        <p>EenmaalAndermaal wil het beste voor haar gebruikers.</p>
                    </div>
                </div>
            </div>

            <!-- De navigatiepijltjes: -->
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div> <!-- Einde slideshow -->

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
