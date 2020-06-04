<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de footer beheerpagina</h2>
        <p>Op deze pagina kunt u de content op de footer pagina aanpassen.</p>
    </div>
    <div class="row">
        <div class="col-4" id="nederland-map" style="width: 600px; height: 400px"></div>
        <div class="col-4" id="europa-map" style="width: 600px; height: 400px"></div>
        <div class="col-4" id="world-map" style="width: 600px; height: 400px"></div>
        <!-- https://jvectormap.com/tutorials/getting-started/ used resource -->
    </div>
    <script>
        $(function(){
            $('#nederland-map').vectorMap({
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
                            echo "{latLng: [" . $location['Latitude'] . ", " . $location['Longitude'] . "], name: 'gebruiker'},";
                        }

                        foreach(Admin::getAllVisitorIPLocations() as $location){
                            echo "{latLng: [" . $location['Latitude'] . ", " . $location['Longitude'] . "], name: '" . $location['TotalVisits'] . "'},";
                        }
                ?>
                    {latLng: [51.9238772, 5.7104402], name: "Zetten"}
                ]
            });
        });
        $(function(){
            $('#europa-map').vectorMap({
                map: 'europe_mill',
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
                        echo "{latLng: [" . $location['Latitude'] . ", " . $location['Longitude'] . "], name: 'gebruiker'},";
                    }

                    foreach(Admin::getAllVisitorIPLocations() as $location){
                        echo "{latLng: [" . $location['Latitude'] . ", " . $location['Longitude'] . "], name: '" . $location['TotalVisits'] . "'},";
                    }
                    ?>
                    {latLng: [51.9238772, 5.7104402], name: "Zetten"}
                ]
            });
        });
        $(function(){
            $('#world-map').vectorMap({
                map: 'world_mill',
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
                        echo "{latLng: [" . $location['Latitude'] . ", " . $location['Longitude'] . "], name: 'gebruiker'},";
                    }

                    foreach(Admin::getAllVisitorIPLocations() as $location){
                        echo "{latLng: [" . $location['Latitude'] . ", " . $location['Longitude'] . "], name: '" . $location['TotalVisits'] . "'},";
                    }
                    ?>
                    {latLng: [51.9238772, 5.7104402], name: "Zetten"}
                ]
            });
        });
    </script>
    <div class="gaTerugKnopBox text-center">
        <button class="gaTerugKnop" href="admin.php">Ga terug</button>
    </div>
</main>