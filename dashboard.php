<?php

session_start();
if(!isset($_SESSION['user'])) header('Location: login.php');
$user = $_SESSION['user'];

//get graph data in purchase order by status
    include('database/po_status_pie_graph.php');
    include('database/supplier_product_bar_graph.php');
    include('database/delivery_history.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
</head>
<body>
    <div id="dashboardMainContainer">
    <?php include('partials/app-sidebar.php')?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <a href="" id="toggleBtn"><i class="fa fa-navicon"></i></a>
                <a href="database/logout.php" id="logoutBtn"><i class="fa fa-power-off"></i>Logout</a>
            </div>
                <div class="dashboard_content">
                    <div class="dashboard_content_main">
                        <div class="col50">
                            <figure class="highcharts-figure">
                            <div id="container"></div>
                            <p class="highcharts-description" style="text-align: center;">
                                It shows the present status of ordered products. </p>
                            </figure>
                        </div>
                        <div class="col50">
                            <figure class="highcharts-figure">
                            <div id="containerBarChart"></div>
                            <p class="highcharts-description" style="text-align: center;">
                                Here is total amount of orders assigned to the suppliers as of today. </p>
                            </figure>
                        </div>
                    </div>
                    <div>
                        <div id="deliveryHistory">

                        </div>
                    </div>
                </div>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>

            var graphData = <?= json_encode($results)?>;
            
        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Purchase Orders by Status'
            },
            tooltip: {
                pointFormatter: function(){ // this function will grant you more access to the data
                    var point = this,
                    series = point.series;

                    return `<b>${point.name}</b>: ${point.y}`
                }
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        format:'<b>{point.name}</b>: {point.y}',
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        style: {
                            fontSize: '1.2rem',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'point',
                            value: 10
                        }
                    }]
                }
            },
            series: [
                {
                    name: 'Percentage',
                    colorByPoint: true,
                    data: graphData
                }
            ]
        });


        var barGraphData = <?= json_encode($bar_chart_data)?>;
        var barGraphCategories = <?= json_encode($categories)?>;

        Highcharts.chart('containerBarChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Product Count Assigned To Supplier',
                align: 'center'
            },
            xAxis: {
                categories: barGraphCategories,
                crosshair: true,
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Product Count'
                }
            },
            tooltip: {
                        pointFormatter: function(){ // this function will grant you more access to the data
                            var point = this,
                            series = point.series;

                            return `<b>${point.category}</b>: ${point.y}`
                        }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: 'Suppliers',
                    data: barGraphData
                },

            ]
        });

        var lineCategories = <?= json_encode($line_categories)?>;
        var lineData = <?= json_encode($line_data)?>;
        Highcharts.chart('deliveryHistory', {
            chart:{
                type: 'spline'
            },
            title: {
            text: 'Delivery History Per Day',
            align: 'center'
            },

            yAxis: {
            title: {
                text: 'Product Delivered'
            }
            },

            xAxis: {
            categories: lineCategories,
            accessibility: {}
            },

            legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
            },

            plotOptions: {
            series: {
                label: {
                connectorAllowed: false
                },
            }
            },

            series: [{
            name: 'Product Delivered',
            data: lineData
            }],

            responsive: {
            rules: [{
                condition: {
                maxWidth: 500
                },
                chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
                }
            }]
            }

        });

    </script>
</body>
</html>