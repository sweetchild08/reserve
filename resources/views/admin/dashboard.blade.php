@extends('layouts.admin.app')
@section('container')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content header-elements-lg-inline">
            <div class="page-title d-flex">
                <h4>{{$title}}</h4>
            </div>

            <div class="header-elements text-center mb-3 mb-lg-0">
                <div class="btn-group">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_default"
                       class="btn btn-indigo">Search</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <form method="POST" action="{{url('admin/search')}}" data-parsley-validate>
        @csrf
        <div id="modal_default" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Search</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">From</label>
                            <input type="date" class="form-control" name="search_from"
                                   value="{{isset($from) ? $from : ''}}" required>
                        </div>

                        <div class="form-group">
                            <label for="">To</label>
                            <input type="date" class="form-control" name="search_to" value="{{isset($to) ? $to : ''}}"
                                   required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content pt-0">

        <div class="row justify-content-center">
            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($rooms)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Rooms</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($cottages)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Cottages</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($foods)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Foods</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($events)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Events</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($activities)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Activities</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">₱{{number_format($sales_rooms,2)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Daily Sales - Rooms</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">₱{{number_format($sales_cottages,2)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Daily Sales - Cottages</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">₱{{number_format($sales_foods,2)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Daily Sales - Foods</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">₱{{number_format($sales_events,2)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Daily Sales - Events</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">₱{{number_format($sales_activities,2)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Daily Sales - Activities</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($pending)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Pending</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($approved)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Approved</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($completed)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Completed</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-12">
                <div class="card card-body">
                    <div class="media">
                        <div class="">
                            <i class=""></i>
                        </div>

                        <div class="media-body text-center">
                            <h3 class="font-weight-semibold mb-0">{{number_format($cancelled)}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Cancelled</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Sales Chart</h5>
            </div>

            <!-- <div class="card-body">
                <div class="chart-container">
                    <div class="chart" id="google-column"></div>
                </div>
            </div> -->

            <div class="card-body">
                <div class="chart-container">
                    <div id="container"></div>
                </div>
            </div>

            <!-- <div class="card-body">
                <div class="chart-container">
                    <div id="provinceGraph" ></div>
                </div>
            </div> -->
        </div>

    </div>
    <!-- /content area -->
@endsection
@section('custom')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        /* ------------------------------------------------------------------------------
     *
     *  # Google Visualization - columns
     *
     *  Google Visualization column chart demonstration
     *
     * ---------------------------------------------------------------------------- */


        // Setup module
        // ------------------------------

        var GoogleColumnBasic = function () {


//
// Setup module components
//

// Column chart
            var _googleColumnBasic = function () {
                if (typeof google == 'undefined') {
                    console.warn('Warning - Google Charts library is not loaded.');
                    return;
                }

                // Initialize chart
                google.charts.load('current', {
                    callback: function () {

                        // Draw chart
                        drawColumn();

                        // Resize on sidebar width change
                        var sidebarToggle = document.querySelectorAll('.sidebar-control');
                        if (sidebarToggle) {
                            sidebarToggle.forEach(function (togglers) {
                                togglers.addEventListener('click', drawColumn);
                            });
                        }

                        // Resize on window resize
                        var resizeColumn;
                        window.addEventListener('resize', function () {
                            clearTimeout(resizeColumn);
                            resizeColumn = setTimeout(function () {
                                drawColumn();
                            }, 200);
                        });
                    },
                    packages: ['corechart']
                });

                // Chart settings
                function drawColumn() {

                    // Define charts element
                    var line_chart_element = document.getElementById('google-column');

                    // Data
                    var data = google.visualization.arrayToDataTable([
                        ['Category', 'Income'],
                        ['Rooms', Number({{$incomeRooms}})],
                        ['Cottages', Number({{$incomeCottages}})],
                        ['Foods', Number({{$incomeFoods}})],
                        ['Events', Number({{$incomeEvents}})],
                        ['Activities', Number({{$incomeActivities}})],
                    ]);

                    // Options
                    var options_column = {
                        fontName: 'Roboto',
                        height: 400,
                        fontSize: 12,
                        backgroundColor: 'transparent',
                        chartArea: {
                            left: '5%',
                            width: '95%',
                            height: 350
                        },
                        tooltip: {
                            textStyle: {
                                fontName: 'Roboto',
                                fontSize: 13
                            }
                        },
                        vAxis: {
                            title: 'Accommodation Income',
                            titleTextStyle: {
                                fontSize: 13,
                                italic: false,
                                color: '#333'
                            },
                            textStyle: {
                                color: '#333'
                            },
                            baselineColor: '#ccc',
                            gridlines: {
                                color: '#eee',
                                count: 10
                            },
                            minValue: 0
                        },
                        hAxis: {
                            textStyle: {
                                color: '#333'
                            }
                        },
                        legend: {
                            position: 'top',
                            alignment: 'center',
                            textStyle: {
                                color: '#333'
                            }
                        },
                        series: {
                            0: {color: '#336699'},
                        }
                    };

                    // Draw chart
                    var column = new google.visualization.ColumnChart(line_chart_element);
                    column.draw(data, options_column);
                }
            };


//
// Return objects assigned to module
//

            return {
                init: function () {
                    _googleColumnBasic();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        GoogleColumnBasic.init();
    </script>
    <script>
        $('#dashboard').addClass('active')
    </script>

    <script type="text/javascript">
        // Create the chart
        let salesData = <?php echo $sales_data; ?>;
        console.info('salesData', salesData)


        let yearlyChartSeries = [
            {
                name: "Yearly Sales",
                colorByPoint: true,
                data: []
            }
        ]

        let drilldownSeries = []

        for (const salesDatum of salesData) {
            const foundIndex = yearlyChartSeries[0].data.findIndex(d => d.name === `${salesDatum.year}`)

            if (foundIndex < 0) {
                yearlyChartSeries[0].data.push({
                    name: `${salesDatum.year}`,
                    y: salesDatum.sales,
                    drilldown: `${salesDatum.year}`
                })
            } else {
                yearlyChartSeries[0].data[foundIndex].y += salesDatum.sales
            }

            const foundYearlyDrillIndex = drilldownSeries.findIndex(d => d.id === `${salesDatum.year}`)

            if (foundYearlyDrillIndex < 0) {
                drilldownSeries.push({
                    name: `Monthly Sales`,
                    id: `${salesDatum.year}`,
                    data: [
                        {
                            name: `${salesDatum.month}`,
                            y: salesDatum.sales,
                            drilldown: `${salesDatum.year}-${salesDatum.month}`
                        }
                    ]
                })

                // drilldownSeries.push({
                //     name: `Weekly Sales`,
                //     id: `${salesDatum.year}-${salesDatum.month}`,
                //     data: [
                //         {
                //             name: `${salesDatum.month}-${salesDatum.week}`,
                //             y: salesDatum.sales,
                //             drilldown: `${salesDatum.year}-${salesDatum.month}-${salesDatum.week}`
                //         }
                //     ]
                // })
                //
                // drilldownSeries.push({
                //     name: `Daily Sales`,
                //     id: `${salesDatum.year}-${salesDatum.month}-${salesDatum.week}`,
                //     data: [
                //         [`D-${salesDatum.day}`, salesDatum.sales]
                //     ]
                // })
            } else {
                const monthIndex = drilldownSeries[foundYearlyDrillIndex].data
                    .findIndex(d => d.name === `${salesDatum.month}`)

                if (monthIndex < 0) {
                    drilldownSeries[foundYearlyDrillIndex].data.push({
                        name: `${salesDatum.month}`,
                        y: salesDatum.sales,
                        drilldown: `${salesDatum.year}-${salesDatum.month}`
                    })
                } else {
                    drilldownSeries[foundYearlyDrillIndex].data[monthIndex].y += salesDatum.sales;
                }
            }

            const foundMonthlyDrillIndex = drilldownSeries.findIndex(d => d.id === `${salesDatum.year}-${salesDatum.month}`)

            if (foundMonthlyDrillIndex < 0) {
                drilldownSeries.push({
                    name: `Weekly Sales`,
                    id: `${salesDatum.year}-${salesDatum.month}`,
                    data: [
                        {
                            name: `${salesDatum.month}-${salesDatum.week}`,
                            y: salesDatum.sales,
                            drilldown: `${salesDatum.year}-${salesDatum.month}-${salesDatum.week}`
                        }
                    ]
                })
            } else {
                const weeklyIndex = drilldownSeries[foundMonthlyDrillIndex].data
                    .findIndex(d => d.name === `${salesDatum.month}-${salesDatum.week}`)

                if (weeklyIndex < 0) {
                    drilldownSeries[foundMonthlyDrillIndex].data.push({
                        name: `${salesDatum.month}-${salesDatum.week}`,
                        y: salesDatum.sales,
                        drilldown: `${salesDatum.year}-${salesDatum.month}-${salesDatum.week}`
                    })
                } else {
                    drilldownSeries[foundMonthlyDrillIndex].data[weeklyIndex].y += salesDatum.sales
                }
            }

            drilldownSeries.push({
                name: `Weekly Sales`,
                id: `${salesDatum.year}-${salesDatum.month}-${salesDatum.week}`,
                data: [
                    [`D-${salesDatum.day}`, salesDatum.sales]
                ]
            })
        }

        console.info('yearlyChartSeries', yearlyChartSeries)
        console.info('drilldownSeries', drilldownSeries)

        @if(isset($year))
        var year = <?php echo $year; ?>;
        var month = <?php echo $monthKey; ?>;
        console.log('year', year);
        console.log('month', month);
        @endif
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Yearly And Monthly Sales'
            },
            subtitle: {
                text: 'Click the columns to view Visualization of Data Per Year.'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'YEARLY AND MONTHLY GRAPH'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '₱{point.y:,.0f}.00'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>₱{point.y:,.0f}.00</b> of total<br/>'
            },

            series: yearlyChartSeries,
            drilldown: {
                series: drilldownSeries
            }
        });

        Highcharts.chart('provinceGraph', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Dito yung province na may pinakamataas na nagpapareserve dipa tapos'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [
                    {
                        name: 'Chrome',
                        y: 70.67,
                        sliced: true,
                        selected: true
                    },
                    {
                        name: 'Edge',
                        y: 14.77
                    },
                    {
                        name: 'Firefox',
                        y: 4.86
                    },
                    {
                        name: 'Safari',
                        y: 2.63
                    },
                    {
                        name: 'Internet Explorer',
                        y: 1.53
                    },
                    {
                        name: 'Opera',
                        y: 1.40
                    },
                    {
                        name: 'Sogou Explorer',
                        y: 0.84
                    },
                    {
                        name: 'QQ',
                        y: 0.51
                    },
                    {
                        name: 'Other',
                        y: 2.6
                    }
                ]
            }]
        });

    </script>
@endsection
