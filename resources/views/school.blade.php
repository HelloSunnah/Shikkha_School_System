@extends('layouts.school.master')
@section('content')
<style>
    .btn1:hover{
        background-color: blueviolet;
        color: white !important;
    }
</style>
    <!--start content-->
    <main class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{__('app.dashboard')}}</div>
            {{-- <div class="ms-auto">
                <div class="btn-group">
                   <form class="row g-3" method="post" action="{{route('send.fees.due.sms')}}" enctype="multipart/form-data">
                       @csrf
                       <button type="submit" class="btn btn-primary">{{__('app.dashboard1btn')}}</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">{{__('app.dashboard1btn')}}</button>
                   </form>
                </div>
            </div> --}}
        </div>
        <!--end breadcrumb-->

        <div>
            <div class="row mb-5">
                <div class="col-md-4 mb-2 ">
                    <a href="{{route('student.teacher.create.show')}}">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h4 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.Student')}}</h4>
                            <div class="card-body text-center p-4">
                                <h3 style="color:rgb(2, 2, 2);">{{CountUser()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4">
                                    <h6 style="color:#30d915"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36)">{{__('app.sincelastweek')}}</p>
                                 </div>
                            </div>
                        </div>
                   </a>
                </div>
                <div class="col-md-4 mb-2">
                    <a href="{{route('teacher.Show')}}">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h4 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.teacher')}}</h4>
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >{{CountTeacher()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4" >
                                    <h6 style="color:#30d915;"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h4 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.t3')}}</h4>
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >{{totalDuefeature()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4">
                                    <h6 style="color:#30d915;"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-4 mb-2">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h4 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.t4')}}</h4>
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >{{MonthlyIncome()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4" >
                                    <h6 style="color:#30d915;"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                    
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h4 class="mb-0 text-center" style="color: blueviolet;margin-top:20px">{{__('app.t5')}}</h4>
                            <br>
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >0</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4" >
                                    <h6 style="color:#30d915;"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                    
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-2">
                        <div class="card  bg-white mb-0" style="border-radius:18px;">
                            <h4 class="mb-0 p-2 text-center" style="color: blueviolet;margin-top:15px;padding-bottom:0px !important">{{__('app.t6')}}</h4>
                            
                            <div class="card-body text-center p-4">
                                <h3 style="color: rgb(0, 0, 0)" >{{DailyAttendence()}}</h3>
                                <div class="d-flex justify-content-center gap-3 pt-4" >
                                    <h6 style="color:#30d915;padding-left:14px"><i class="bi bi-graph-up-arrow"></i> 17% </h6>
                                    <p style="color:rgb(36, 36, 36);">{{__('app.sincelastweek')}}</p>
                                    
                                 </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card radius-10 w-100">
                        {{-- <div class="card-header bg-transparent p-3">
                            
                        </div> --}}
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center">
                                <div class="col">
                                    <h5 class="mb-0" style="color:blueviolet">{{__('app.Status2')}}</h5>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                                        <div class="font-13" style="color: blueviolet"><i class="bi bi-circle-fill text-info" style="color:blueviolet !important"></i><span class="ms-2">{{__('app.Status3')}}</span></div>
                                        <div class="font-13"><i class="bi bi-circle-fill" style="color:rgb(250, 154, 65)"></i><span class="ms-2">{{__('app.Status4')}}</span></div>
                                    </div>
                                </div>
                            </div>
                            <div id="chart5"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <h5 class="mb-0" style="color:blueviolet">{{__('app.Status1')}}</h5>
                            <div id="chart1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="project-date">
                                <strong class="mb-0 font-13">{{$defaultDate}}</strong>
                            </div>

                        </div>
                        <div class="text-center my-3">
                            <h6 style="color:blueviolet" class="mb-0">{{__('app.Status5')}} </h6>
                        </div>
                        <?php
                        $messageAccount =  getMessageAccount();
                        ?>
                        <div class="my-2">
                            <p class="mb-1 font-13">{{__('app.Usages')}}<strong style="color: red">({{$messageAccount['dataProcessBar']}} / {{$messageAccount['total']}})</strong> </p>
                            <div class="progress radius-10" style="height:25px;">
                                <div class="progress-bar radius-10" role="progressbar" style="width:{{$messageAccount['cssProcessBar']}}%;background-color:blueviolet !important;"></div>
                            </div>
                            {{-- <div class="progress radius-10" style="height:5px;">
                                <div class="progress-bar" role="progressbar" style="width: {{$messageAccount['cssProcessBar']}}%"></div>
                            </div> --}}
                            <p class="mb-0 mt-1 font-13 text-end"></p>
                        </div>
                        <div class="d-flex align-items-center mt-5">
                            <div class="project-user-groups">
                                <a href="{{route('school.message.post.checkout.show')}}" class="btn btn-outline-primary btn1" style="border-color:blueviolet !important;color:blueviolet">{{__('app.Status7')}} </a>
                            </div>
                            <a href="{{route('school.message')}}" class="btn btn-primary radius-30 btn2 ms-auto" style="background-color:blueviolet !important;color:white;border-color:blueviolet;">{{__('app.Status8')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <h5 class="mb-0" style="color: blueviolet;">{{__('app.Statistics')}}</h5>
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        


    </main>
    <!--end page main-->

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('app.SendSms')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{route('send.fees.due.sms')}}">
                    @csrf
                    <div class="modal-body">
                    {{__('app.sure')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('app.no')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('app.yes')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        $(function() {
            "use strict";
            var datas  = <?php echo json_encode($datas);?>
          //




// chart 1
            var options = {
                series: [{
                    name: "Users",
                    data: datas
                }],
                chart: {
                    foreColor: '#9a9797',
                    type: "bar",
                    //width: 130,
                    height: 270,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !1
                    },
                    dropShadow: {
                        enabled: 0,
                        top: 3,
                        left: 14,
                        blur: 4,
                        opacity: .12,
                        color: "#3461ff"
                    },
                    sparkline: {
                        enabled: !1
                    }
                },
                markers: {
                    size: 0,
                    colors: ["#7a00a7", "#7a00a7"],
                    strokeColors: "#fff",
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "40%",
                        endingShape: "rounded"
                    }
                },
                legend: {
                    show: false,
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetX: -20
                },
                dataLabels: {
                    enabled: !1
                },
                grid: {
                    show: false,
                    // borderColor: '#eee',
                    // strokeDashArray: 4,
                },
                stroke: {
                    show: !0,
                    // width: 3,
                    curve: "smooth"
                },
                colors: ["#7a00a7"],
                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function (val) {
                            return "" + val + ""
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart1"), options);
            chart.render();


// chart 2
            var options = {
                series: [{
                    name: "Users",
                    data: [450, 420, 660, 160]
                }],
                chart: {
                    foreColor: '#9a9797',
                    type: "bar",
                    //width: 130,
                    height: 170,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !1
                    },
                    dropShadow: {
                        enabled: 0,
                        top: 3,
                        left: 14,
                        blur: 4,
                        opacity: .12,
                        color: "#8a2be2"
                    },
                    sparkline: {
                        enabled: !1
                    }
                },
                markers: {
                    size: 0,
                    colors: ["#8a2be2"],
                    strokeColors: "#8a2be2",
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: 1,
                        columnWidth: "20%",
                        columnHeight: "20%",
                        endingShape: "rounded"
                    }
                },
                legend: {
                    show: false,
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetX: -20
                },
                dataLabels: {
                    enabled: !1
                },
                grid: {
                    show: false,
                    // borderColor: '#eee',
                    // strokeDashArray: 4,
                },
                stroke: {
                    show: !0,
                    // width: 3,
                    curve: "smooth"
                },
                colors: ["#8a2be2"],
                xaxis: {
                    categories: ["Student", "Teacher", "Finance", "Author"]
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function (val) {
                            return "" + val + ""
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart2"), options);
            chart.render();






// chart 3

            var options = {
                series: [89, 45, 35, 62],
                chart: {
                    width: 340,
                    type: 'donut',
                },
                labels: ["Visitors", "Subscribers", "Contributor", "Author"],
                colors: ["#3361ff", "#e72e2e", "#12bf24", "#ff6632"],
                legend: {
                    show: false,
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetX: -20
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 260
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#chart3"), options);
            chart.render();




            // chart 4

            var options = {
                series: [68],
                chart: {
                    foreColor: '#9ba7b2',
                    height: 280,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        //startAngle: -130,
                        //endAngle: 130,
                        hollow: {
                            margin: 0,
                            size: '82%',
                            //background: '#fff',
                            image: undefined,
                            imageOffsetX: 0,
                            imageOffsetY: 0,
                            position: 'front',
                            dropShadow: {
                                enabled: false,
                                top: 3,
                                left: 0,
                                blur: 4,
                                color: 'rgba(0, 169, 255, 0.15)',
                                opacity: 0.65
                            }
                        },
                        track: {
                            background: '#dfecff',
                            //strokeWidth: '67%',
                            margin: 0, // margin is in pixels
                            dropShadow: {
                                enabled: false,
                                top: -3,
                                left: 0,
                                blur: 4,
                                color: 'rgba(0, 169, 255, 0.85)',
                                opacity: 0.65
                            }
                        },
                        dataLabels: {
                            showOn: 'always',
                            name: {
                                offsetY: -25,
                                show: true,
                                color: '#6c757d',
                                fontSize: '16px'
                            },
                            value: {
                                formatter: function (val) {
                                    return val + "%";
                                },
                                color: '#000',
                                fontSize: '45px',
                                show: true,
                                offsetY: 10,
                            }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        shadeIntensity: 0.5,
                        gradientToColors: ['#3361ff'],
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                },
                colors: ["#3361ff"],
                labels: ['mc'],
            };

            var chart = new ApexCharts(document.querySelector("#chart4"), options);
            chart.render();



// chart 5
           var incomeDatas  = <?php echo json_encode($incomeDatas, JSON_NUMERIC_CHECK);?>;
           var exDatas  = <?php echo json_encode($exDatas, JSON_NUMERIC_CHECK);?>

            var optionsLine = {
                chart: {
                    foreColor: '#9ba7b2',
                    height: 275,
                    type: 'line',
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: false
                    },
                    dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 2,
                        blur: 4,
                        opacity: 0.1,
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                colors: ["#8a2be2", '#ff6632'],
                series: [{
                    name: "Income",
                    data: incomeDatas
                }, {
                    name: "Expense",
                    data: exDatas
                }],
                markers: {
                    size: 4,
                    strokeWidth: 0,
                    hover: {
                        size: 7
                    }
                },
                grid: {
                    show: true,
                    padding: {
                        bottom: 0
                    }
                },
                //labels: ['01/15/2002', '01/16/2002', '01/17/2002', '01/18/2002', '01/19/2002', '01/20/2002'],
                xaxis: {
                    //type: 'datetime',
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov','Dec'],
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -20
                }
            }
            var chartLine = new ApexCharts(document.querySelector('#chart5'), optionsLine);
            chartLine.render();






        });
    </script>
@endpush

