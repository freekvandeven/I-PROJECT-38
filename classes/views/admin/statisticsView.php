<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<main class="adminPaginaSub">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de statistiekenpagina</h2>
        <p>Op deze pagina kunt u de statistieken van de website inzien.</p>
    </div>

    <div class="container col-xl-10 col-lg-11 col-md-11 col-sm-11 col-11">
        <h2 class="text-center">Bekijk de pagina statistieken:</h2>

        <?php
        //Debug::dump(Admin::getBidsPerDay());
        //Debug::dump(Admin::getAuctionsPerDay());
        ?>

    </div>
    <div class="container">
        <canvas id="pageVisitChart"></canvas>
    </div>
    <div class="container">
        <canvas id="auctionChart"></canvas>
    </div>
    <div class="container">
        <canvas id="bidsChart"></canvas>
    </div>

    <?php
    $info = Admin::getSiteVisits();
    $auctions = Admin::getAuctionsPerDay();
    $bids = Admin::getBidsPerDay();
    ?>

    <script>
        let pageChart = document.getElementById('pageVisitChart').getContext('2d');

        // Global Options
        Chart.defaults.global.defaultFontFamily = 'Lato';
        Chart.defaults.global.defaultFontSize = 17;
        Chart.defaults.global.defaultFontColor = '#777';

        let massPopChart1 = new Chart(pageChart, {
            type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
            data:{
                labels:<?=json_encode(array_column($info, "PageName"));?>,
                datasets:[{
                    label:'Site Activity',
                    data:
                        <?=json_encode(array_map('intval',array_column($info,"Visits"))); ?>
                    ,
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
                    text:'Pagina bezoeken',
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
    <script>
        let auctionChart = document.getElementById('auctionChart').getContext('2d');


        let massPopChart2 = new Chart(auctionChart, {
            type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
            data:{
                labels:<?=json_encode(array_column($auctions, "Day"));?>,
                datasets:[{
                    label:'Site Activity',
                    data:
                    <?=json_encode(array_map('intval',array_column($auctions,"aantal"))); ?>
                    ,
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
                    text:'Afgelopen veilingen',
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
    <script>
        let bidsChart = document.getElementById('bidsChart').getContext('2d');


        let massPopChart3 = new Chart(bidsChart, {
            type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
            data:{
                labels:<?=json_encode(array_column($bids, "Day"));?>,
                datasets:[{
                    label:'Site Activity',
                    data:
                    <?=json_encode(array_map('intval',array_column($auctions,"aantal"))); ?>
                    ,
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
                    text:'Biedingen',
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