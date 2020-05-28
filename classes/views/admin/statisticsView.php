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
                        foreach(Admin::getSiteVisits() as $visit){
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

        <div>
        <?php
        Debug::dump(Admin::getBidsPerDay());
        Debug::dump(Admin::getAuctionsPerDay());
        ?>
        </div>
    </div>

    <div class="container">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        let myChart = document.getElementById('myChart').getContext('2d');

        // Global Options
        Chart.defaults.global.defaultFontFamily = 'Lato';
        Chart.defaults.global.defaultFontSize = 17;
        Chart.defaults.global.defaultFontColor = '#777';

        let massPopChart = new Chart(myChart, {
            type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
            data:{
                labels:['404', 'addProduct', 'admin', 'catalogus', 'contact', 'footer', 'forgotPassword', 'getCatalogus', 'index', 'item', 'loging', 'profile'],
                datasets:[{
                    label:'Site Activity',
                    data:[
                        117594,
                        181045,
                        153060,
                        106519,
                        105162,
                        95072,
                        117594,
                        181045,
                        253060,
                        106519,
                        105162,
                        95072
                    ],
                    //backgroundColor:'green',
                    backgroundColor:[
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(150, 99, 132, 0.6)',
                        'rgba(255, 33, 90, 0.6)',
                        'rgba(200, 196, 86, 0.6)',
                        'rgba(75, 192, 170, 11)',
                        'rgba(255, 200, 30, 200)',
                        'rgba(20, 250, 86, 131)',
                    ],
                    borderWidth:1,
                    borderColor:'#777',
                    hoverBorderWidth:3,
                    hoverBorderColor:'#000'
                }]
            },
            options:{
                title:{
                    display:true,
                    text:'Website statistieken van EenmaalAndermaal',
                    fontSize:25
                },
                legend:{
                    display:true,
                    position:'right',
                    labels:{
                        fontColor:'#000'
                    }
                },
                layout:{
                    padding:{
                        left:0,
                        right:0,
                        bottom:0,
                        top:0
                    }
                },
                tooltips:{
                    enabled:true
                }
            }
        });
    </script>

    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>