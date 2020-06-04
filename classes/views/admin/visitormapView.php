<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de footer beheerpagina</h2>
        <p>Op deze pagina kunt u de content op de footer pagina aanpassen.</p>
    </div>
    <div id="world-map" style="width: 600px; height: 400px"></div>
    <!-- https://jvectormap.com/tutorials/getting-started/ used resource -->
    <script>
        $(function(){
            $('#world-map').vectorMap({
                map: 'nl_mill',
                markerStyle: {
                    initial: {
                        fill: '#F8E23B',
                        stroke: '#383f47'
                    }
                },
                backgroundColor: '#383f47',
                markers: [
                    <?php
                        foreach(Admin::getAllUserLocations() as $location){
                            echo "{latLng: [" . $location['Latitude'] . ", " . $location['Longitude'] . "]},";
                        }
                        /*
                        foreach(Admin::getAllVisitorIPLocations() as $location){
                            echo "{latLng: [" . $location['Latitude'] . ", " . $location['Longitude'] . "]},";
                        } */
                ?>
                    {latLng: [51.9238772, 5.7104402], name: "Zetten"}
                ]
            });
        });
    </script>
    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>