<main>
    <h2>Welkom master op de Admin pagina</h2>
    <ul>
        <li><a href="admin.php?category=auction">Bekijk veilingen</a></li>
        <li><a href="admin.php?category=user">Bekijk gebruikers</a></li>
        <li><a href="admin.php?category=seller">Bekijk verkopers</a></li>
        <li><a href="admin.php?category=statistics">Bekijk pagina statistieken</a></li>
        <li><a href="admin.php?category=reset">Reset Database</a></li>
        <li><a href="admin.php?category=fill">Vul database met CSV bestand</a></li>
    </ul>
    <div id="piechart"></div>
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
</main>