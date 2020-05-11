<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de statistiekenpagina</h2>
        <p>Op deze pagina kunt u de statistieken van de website inzien.</p>
    </div>

    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <h2 class="text-center">Bekijk de website statistieken:</h2>
        <div id="piechart">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

            <script type="text/javascript">
                // Load google charts
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                // Draw the chart and set the chart values
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Page', 'Views'],
                        <?php
                        foreach(getSiteVisits() as $visit){
                            echo "['".$visit["PageName"]."', ".$visit["Visits"]."],";
                        } ?>
                    ]);

                    // Optional; add a title and set the width and height of the chart
                    var options = {'title':'Site Activity', 'width':550, 'height':400};

                    // Display the chart inside the <div> element with id="piechart"
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                    chart.draw(data, options);
                }
            </script>
        </div>
    </div>

    <div class="text-center col-lg-12">
        <p class="gaTerugKnop"><a href="admin.php">Ga terug</a></p>
    </div>
</main>