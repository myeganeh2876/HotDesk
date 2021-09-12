@extends('voyager::master')

@section('content')

    <div class="col-lg-8 col-md-12 col-sm-12">
        <div class="row">
            <div class="padding-item col-lg-12 col-md-12 col-sm-12">
                <h5 class="title">
                    گزارشات
                </h5>
            </div>
            <div class="padding-item col-lg-12 col-md-12 col-sm-12">
                <div id="box" class="box">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="chart-row">
                                <div class="flex-box chart-title">
                                    <span class="dark-pink"></span>
                                    کاربر جدید
                                </div>
                                <h5>
                                    ۴۲۴
                                </h5>
                                <canvas style="height: 60px" id="new-user-chart"></canvas>
                                <a class="flex-box more">
                                    <img src="assets/icon/arrow.svg">
                                    لیست کاربران

                                </a>
                                <div class="line"></div>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="chart-row">
                                <div class="flex-box chart-title">
                                    <span class="green"></span>
                                    مبلغ فروش
                                </div>
                                <h5>
                                    ۲۴.۳۴۰.۰۰۰
                                </h5>
                                <canvas style="height: 60px" id="sale-chart"></canvas>
                                <a class="flex-box more">
                                    <img src="assets/icon/arrow.svg">
                                    گزارش فروش

                                </a>
                                <div class="line"></div>

                            </div>

                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="chart-row">
                                <div class="flex-box chart-title">
                                    <span class="light-pink"></span>
                                    تعداد فروش
                                </div>
                                <h5>
                                    ۷۳۸
                                </h5>
                                <canvas style="height: 60px"
                                        id="sale-number-chart"></canvas>
                                <a class="flex-box more">
                                    <img src="assets/icon/arrow.svg">
                                    لیست سفارشات

                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('voyager::dashboard.personalizemenus')
            @include('voyager::dashboard.smspack')
        </div>
    </div>

    @include('voyager::dashboard.notes')

@endsection

@section('javascript')

    <script>
        var newuserdeailsdata = {
            pointBorderWidth: 0,
            pointHoverRadius: 0,
            pointRadius: 0,
            label: '', // Name the series
            data: [200,	140,	200,	120,	130,	240,	120,200,	120,	130,	240,	120,	250,	130, 270], // Specify the data values array
            fill: false,
            borderColor: '#FF5793', // Add custom color border (Line)
            backgroundColor: '#FF5793', // Add custom color background (Points and Fill)
            borderWidth: 4 // Specify bar border width

        };
        var saledetailsdata = {
            pointBorderWidth: 0,
            pointHoverRadius: 0,
            pointRadius: 0,
            label: '', // Name the series
            data: [200000,	140000,	200000,	120000,	130000,	240000,	120000,200000,	120000,	130000,	240000,	120000,	250000,	130000, 270000], // Specify the data values array
            fill: false,
            borderColor: '#66C48C', // Add custom color border (Line)
            backgroundColor: '#66C48C', // Add custom color background (Points and Fill)
            borderWidth: 4 // Specify bar border width

        };
        var salenumberdetailsdata = {
            pointBorderWidth: 0,
            pointHoverRadius: 0,
            pointRadius: 0,
            label: '', // Name the series
            data: [20,	14,	20,	25,	16,	24,	12,20,	12,	17,	29,	30,	27,	32, 37], // Specify the data values array
            fill: false,
            borderColor: '#FC96C3', // Add custom color border (Line)
            backgroundColor: '#FC96C3', // Add custom color background (Points and Fill)
            borderWidth: 4 // Specify bar border width

        };
        // Custom Tooltip
        var customTooltips = function (tooltipModel) {
            // Tooltip Element
            var tooltipEl = document.getElementById('chartjs-tooltip')

            let index = 0;
            if (tooltipModel.dataPoints) {
                index = tooltipModel.dataPoints[0].index
            }

            if (!tooltipEl) {
                tooltipEl = document.createElement('div');
                tooltipEl.id = 'chartjs-tooltip';
                tooltipEl.innerHTML = '' +
                    '<span class="triangle triangle-5"></span>' +

                    '<h6 id="tooltip-register-label" dir="rtl">' +
                    newuserdeailsdata.data[index]  +
                    '</h6>'  +
                    '<p id="tooltip-date-label">' +
                    tooltipModel.dataPoints[0].label +
                    '</p>'+
                    '<div class="toottipe-extra-item ">' +
                    '<img src="assets/icon/circle-toottipe.svg">' +
                    '<img class="line-tooltipe" src="assets/icon/line-tooltipe.svg">' +
                    '</div>'
                ;
                tooltipEl.classList.add('chart-tooltip')
                document.body.appendChild(tooltipEl);
            }
            // Hide if no tooltip
            if (tooltipModel.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
            }


            // set content
            let date_label = document.getElementById('tooltip-date-label')
            date_label.innerHTML = tooltipModel.dataPoints[0].label

            let register_label = document.getElementById('tooltip-register-label')
            register_label.innerHTML = newuserdeailsdata.data[index]

            // Set caret Position
            tooltipEl.classList.remove('above', 'below', 'no-transform');
            if (tooltipModel.yAlign) {
                tooltipEl.classList.add(tooltipModel.yAlign);
            } else {
                tooltipEl.classList.add('no-transform');
            }
            // `this` will be the overall tooltip
            var position = this._chart.canvas.getBoundingClientRect();

            // Display, position, and set styles for font
            tooltipEl.style.opacity = 1;
            tooltipEl.style.position = 'absolute';
            tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
            tooltipEl.style.top = position.top + window.pageYOffset - tooltipEl.offsetHeight - 25 + tooltipModel.caretY + 'px';
            tooltipEl.style.zIndex = 999;
            tooltipEl.style.pointerEvents = 'none';
        }
        var customTooltips2 = function (tooltipModel) {
            // Tooltip Element
            var tooltipEl = document.getElementById('chartjs-tooltip')

            let index = 0;
            if (tooltipModel.dataPoints) {
                index = tooltipModel.dataPoints[0].index
            }

            if (!tooltipEl) {
                tooltipEl = document.createElement('div');
                tooltipEl.id = 'chartjs-tooltip';
                tooltipEl.innerHTML = '' +
                    '<span class="triangle triangle-5"></span>' +

                    '<h6 id="tooltip-register-label" dir="rtl">' +
                    saledetailsdata.data[index]  +
                    '</h6>'  +
                    '<p id="tooltip-date-label">' +
                    tooltipModel.dataPoints[0].label +
                    '</p>'+
                    '<div class="toottipe-extra-item ">' +
                    '<img src="assets/icon/circle-toottipe.svg">' +
                    '<img class="line-tooltipe" src="assets/icon/line-tooltipe.svg">' +
                    '</div>'
                ;
                tooltipEl.classList.add('chart-tooltip')
                document.body.appendChild(tooltipEl);
            }
            // Hide if no tooltip
            if (tooltipModel.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
            }


            // set content
            let date_label = document.getElementById('tooltip-date-label')
            date_label.innerHTML = tooltipModel.dataPoints[0].label

            let register_label = document.getElementById('tooltip-register-label')
            register_label.innerHTML = saledetailsdata.data[index]

            // Set caret Position
            tooltipEl.classList.remove('above', 'below', 'no-transform');
            if (tooltipModel.yAlign) {
                tooltipEl.classList.add(tooltipModel.yAlign);
            } else {
                tooltipEl.classList.add('no-transform');
            }
            // `this` will be the overall tooltip
            var position = this._chart.canvas.getBoundingClientRect();

            // Display, position, and set styles for font
            tooltipEl.style.opacity = 1;
            tooltipEl.style.position = 'absolute';
            tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
            tooltipEl.style.top = position.top + window.pageYOffset - tooltipEl.offsetHeight - 25 + tooltipModel.caretY + 'px';
            tooltipEl.style.zIndex = 999;
            tooltipEl.style.pointerEvents = 'none';
        }
        var customTooltips3 = function (tooltipModel) {
            // Tooltip Element
            var tooltipEl = document.getElementById('chartjs-tooltip')

            let index = 0;
            if (tooltipModel.dataPoints) {
                index = tooltipModel.dataPoints[0].index
            }

            if (!tooltipEl) {
                tooltipEl = document.createElement('div');
                tooltipEl.id = 'chartjs-tooltip';
                tooltipEl.innerHTML = '' +
                    '<span class="triangle triangle-5"></span>' +

                    '<h6 id="tooltip-register-label" dir="rtl">' +
                    salenumberdetailsdata.data[index]  +
                    '</h6>'  +
                    '<p id="tooltip-date-label">' +
                    tooltipModel.dataPoints[0].label +
                    '</p>'+
                    '<div class="toottipe-extra-item ">' +
                    '<img src="assets/icon/circle-toottipe.svg">' +
                    '<img class="line-tooltipe" src="assets/icon/line-tooltipe.svg">' +
                    '</div>'
                ;
                tooltipEl.classList.add('chart-tooltip')
                document.body.appendChild(tooltipEl);
            }
            // Hide if no tooltip
            if (tooltipModel.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
            }


            // set content
            let date_label = document.getElementById('tooltip-date-label')
            date_label.innerHTML = tooltipModel.dataPoints[0].label

            let register_label = document.getElementById('tooltip-register-label')
            register_label.innerHTML = salenumberdetailsdata.data[index]

            // Set caret Position
            tooltipEl.classList.remove('above', 'below', 'no-transform');
            if (tooltipModel.yAlign) {
                tooltipEl.classList.add(tooltipModel.yAlign);
            } else {
                tooltipEl.classList.add('no-transform');
            }
            // `this` will be the overall tooltip
            var position = this._chart.canvas.getBoundingClientRect();

            // Display, position, and set styles for font
            tooltipEl.style.opacity = 1;
            tooltipEl.style.position = 'absolute';
            tooltipEl.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
            tooltipEl.style.top = position.top + window.pageYOffset - tooltipEl.offsetHeight - 25 + tooltipModel.caretY + 'px';
            tooltipEl.style.zIndex = 999;
            tooltipEl.style.pointerEvents = 'none';
        }

        var newuserchart = document.getElementById('new-user-chart');
        var salechart = document.getElementById('sale-chart');
        var salenumberchart = document.getElementById('sale-number-chart');
        window.myLine = new Chart(newuserchart, {
            type: "line",
            data: {
                labels: ["شنبه ۲۰ آبان ۹۹", "یکشنبه ۲۱ آبان ۹۹", "دوشنبه ۲۲ آبان ۹۹", "سه شنبه ۲۳ آبان ۹۹", "چهارشنبه ۲۴ آبان ۹۹", "پنجشنبه ۲۵ آبان ۹۹", "جمعه ۲۶ آبان ۹۹"],
                datasets: [
                    newuserdeailsdata
                ]
            },
            options: {
                legend: {
                    display: false,
                    labels: {
                        fontColor: "#96A6B1"
                    }
                },

                title: {
                    display: false,

                },
                scales:
                    {
                        responsive: true,
                        maintainAspectRatio: false,
                        xAxes: [{
                            gridLines : {
                                drawBorder: false,
                                display : false
                            },
                            ticks: {
                                beginAtZero: false,
                                fontSize: 0,
                                fontColor: '#fff',
                                padding: 0,
                            },
                        }],
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display : false
                            },
                            ticks: {
                                beginAtZero: false,
                                fontSize: 0,
                                fontColor: '#fff',
                                maxTicksLimit: 5,
                                padding: 0,
                            }
                        }],
                    },
                onClick: graphClickEvent,
                tooltips: {
                    mode: "nearest",
                    intersect: false,
                    enabled: false,
                    position: "average",

                    custom: customTooltips,
                    callbacks: {
                        label: function (tooltipItem, data) {


                        }
                    }
                }
            }
        });
        window.myLine = new Chart(salechart, {
            type: "line",
            data: {
                labels: ["شنبه ۲۰ آبان ۹۹", "یکشنبه ۲۱ آبان ۹۹", "دوشنبه ۲۲ آبان ۹۹", "سه شنبه ۲۳ آبان ۹۹", "چهارشنبه ۲۴ آبان ۹۹", "پنجشنبه ۲۵ آبان ۹۹", "جمعه ۲۶ آبان ۹۹"],
                datasets: [
                    saledetailsdata
                ]
            },
            options: {
                legend: {
                    display: false,
                    labels: {
                        fontColor: "#96A6B1"
                    }
                },

                title: {
                    display: false,

                },
                scales:
                    {
                        responsive: true,
                        maintainAspectRatio: false,
                        xAxes: [{
                            gridLines : {
                                drawBorder: false,
                                display : false
                            },
                            ticks: {
                                beginAtZero: false,
                                fontSize: 0,
                                fontColor: '#fff',
                                padding: 0,
                            },
                        }],
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display : false
                            },
                            ticks: {
                                beginAtZero: false,
                                fontSize: 0,
                                fontColor: '#fff',
                                maxTicksLimit: 5,
                                padding: 0,
                            }
                        }],
                    },
                onClick: graphClickEvent,
                tooltips: {
                    mode: "nearest",
                    intersect: false,
                    enabled: false,
                    position: "average",
                    custom: customTooltips2,
                    callbacks: {
                        label: function (tooltipItem, data) {


                        }
                    }
                }
            }
        });
        window.myLine = new Chart(salenumberchart, {
            type: "line",
            data: {
                labels: ["شنبه ۲۰ آبان ۹۹", "یکشنبه ۲۱ آبان ۹۹", "دوشنبه ۲۲ آبان ۹۹", "سه شنبه ۲۳ آبان ۹۹", "چهارشنبه ۲۴ آبان ۹۹", "پنجشنبه ۲۵ آبان ۹۹", "جمعه ۲۶ آبان ۹۹"],
                datasets: [
                    salenumberdetailsdata
                ]
            },
            options: {
                legend: {
                    display: false,
                    labels: {
                        fontColor: "#96A6B1"
                    }
                },

                title: {
                    display: false,

                },
                scales:
                    {
                        responsive: true,
                        maintainAspectRatio: false,
                        xAxes: [{
                            gridLines : {
                                drawBorder: false,
                                display : false
                            },
                            ticks: {
                                beginAtZero: false,
                                fontSize: 0,
                                fontColor: '#fff',
                                padding: 0,
                            },
                        }],
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display : false
                            },
                            ticks: {
                                beginAtZero: false,
                                fontSize: 0,
                                fontColor: '#fff',
                                maxTicksLimit: 5,
                                padding: 0,
                            }
                        }],
                    },
                onClick: graphClickEvent,
                tooltips: {
                    mode: "nearest",
                    intersect: false,
                    enabled: false,
                    position: "average",
                    custom: customTooltips3,
                    callbacks: {
                        label: function (tooltipItem, data) {


                        }
                    }
                }
            }
        });



        function graphClickEvent(event, array) {
            if (array[0]) {
                var chartData = array[0]["_chart"].config.data;
                var idx = array[0]["_index"];

                var label = chartData.labels[idx];
                var value = chartData.datasets[0].data[idx];

                // var url = "Label: " + label + " Value: " + value;

                console.log(label);
                alert(label);
            }
        }

        function randomNumbers(min, max) {
            return Math.floor(Math.random() * max) + min;
        }

        function randomScalingFactor() {
            return randomNumbers(1, 100);
        }

    </script>
    <script>
        $( ".send-massage" ).focus(function() {
            $( this ).addClass("active")
        });
        $( ".send-massage" ).focusout(function() {
            $( this ).removeClass("active")
        })


        $( ".send-massage-btn" ).click(function() {
            $( this ).addClass("active")
        });
        $( "form .outer" ).click(function() {
            $( "form .outer" ).removeClass("active")
            $( this ).addClass("active")
        });
        $( ".massage-filter .outer" ).click(function() {
            $( ".massage-filter .outer" ).removeClass("active")
            $( this ).addClass("active")
        });

        $(document).ready(function(){
            $('.massage-box input[type="checkbox"]').click(function(){
                var items =  $( this )
                if($(this).is(":checked")){
                    setTimeout(function() {
                        items.parent().addClass("slide-right")
                    }, 100);
                    setTimeout(function() {
                        items.parent().hide(200)
                    }, 100);
                }
                else if($(this).is(":not(:checked)")){
                    items.stop();
                }
                else{
                    items.stop();

                }
            });
        });
    </script>
    <script>
        $(".send-massage-btn ").on("click", function () {
            var filename = $('.send-massage').val();
            console.log(filename)

            $( ".massage-row" ).append(" <div class=\"padding-item col-lg-12 col-md-12 col-sm-12\">" +
                "<div class=\"box massage-box\">" +
                "<p> "
                + filename  +
                "</p>" +
                "<input type=\"checkbox\" id=\"new-massage\">" +
                "<label for=\"new-massage\">" +
                "<img src=\"assets/icon/check.svg\">" +
                "</label><div class=\"extra green-2\">" +
                "</div>" +
                "</div>" +
                "</div>");

            $('.massage-box input[type="checkbox"]').click(function(){
                var items =  $( this )
                if($(this).is(":checked")){
                    setTimeout(function() {
                        items.parent().addClass("slide-right")
                    }, 100);
                    setTimeout(function() {
                        items.parent().hide(200)
                    }, 100);
                }
                else if($(this).is(":not(:checked)")){
                    items.stop();
                }
                else{
                    items.stop();

                }
            });
        })
    </script>

@endsection
