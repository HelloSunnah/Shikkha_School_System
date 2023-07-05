@extends('layouts.school.master')
@section('content')


@push('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endpush
<style>
  .box1{
    width: 15px;
    height: 15px;
    background: #7b00a7;
    position: absolute;
    margin-left: -20px;
    margin-top: 5px;
  }
  .box2{
    width: 15px;
    height: 15px;
    background: #1d2ba3;
    position: absolute;
    margin-left: -10px;
    margin-top: 5px;
  }
  .holidaylist ul{
display: flex;
list-style: none;
flex-wrap: wrap;
line-height: 250%;
text-align: center;
padding-left: 0px !important;
}
.holidaylist li{
  width: 50px;
  height: 50px;
  border-radius: 5px;
  margin:5px;
  background: #ffffff;
  font-weight: 700;
  border: 3px solid #7b00a7;
}
    #chart {
  max-width: 650px;
  margin: 35px auto;

}
.apexcharts-toolbar{
    display: none;
}
.wrapper header{
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 25px 30px 10px;
}
header .current-date{
  font-size: 1.45rem;
  font-weight: 600;
}
header .icons span{
  height: 38px;
  width: 38px;
  margin: 0 1px;
  cursor:pointer;
  text-align: center;
  line-height: 38px;
  border-radius: 5px;
  background: #d8d5d5;
  font-size: 1.9rem;
  color:#242424;

}
header .icons span:last-child{
 margin-right: -10px;
}
header .icons span:hover{
  background:#7b00a7;
  color:#fff;
}
.calender{
  padding:20px;
}
.calender ul{
display: flex;
list-style: none;
flex-wrap: wrap;
text-align: center;
padding-left: 0px !important;
}
.calender ul li{
  position:relative;
width: calc(100% / 7);
}
.calender .weeks li{
  font-weight: 600;
  margin-bottom: -15px;
}
.calender .days li{
  cursor: pointer;
  z-index: 20;
  margin-top: 40px;
  font-weight: 600;

}

.calender .days li::before{
  position: absolute;
  content: '';
  z-index: -1;
  width: 40px;
  height: 40px;
  top: 50%;
  left: 50%;
  border-radius: 5px;
  transform:translate(-50% , -50%);
  background: #efefef;
}
.days li:hover::before{
  background: #7b00a7;
  color: #fff;
}
.days li:hover{
  color: #fff;
}
.days li.inactive{
  color: #c9c7c7;
}
.days li.active::before{
  background: #7b00a7;
  color:white;
}
.days li.active{
  color:white;
}

</style>
    <main class="page-content">
        <div class="row">
            <div class="col-lg-7 col-md-8 col-sm-12 mx-auto">
                <div class="card" style="border-radius:10px;box-shadow:-3px 6px  20px #ddd">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 mx-auto m-0 pe-0">
                                <div class="d-flex justify-content-center gap-3 ">
                                    <img src="{{ asset('d/no-img.jpg') }}" class="rounded-circle" width="66"
                                        height="70" alt="">
                                    <h4 style="color:#7b00a7;margin-top:15px;">Jobeda khatun</h4>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 mx-auto m-0 pt-2">

                                <div class="d-flex justify-content-center gap-3 text-center ">
                                    <h6>Class <p style="font-size: 15px;color:#5b5b5b">Nine</p>
                                    </h6>
                                    <h6>Section <p style="font-size: 15px;color:#5b5b5b">A</p>
                                    </h6>
                                    <h6>Shift <p style="font-size: 15px;color:#5b5b5b">Morning</p>
                                    </h6>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class=" col-lg-4 col-md-6 col-sm-12 ">
                                <div class="d-flex justify-content-center gap-3">
                                    <div style="background: #7b00a7;border-radius:5px; padding:8px;margin-top:7px;margin-bottom:27px;"><img src="{{ asset('schools\assets\images\icons\clock.png') }}" class="rounded-circle" width="30"
                                        height="30" alt="">
                                    </div>
                                    <h6 class="pt-1">Class Time <p style="font-size: 14px;color:#5b5b5b">10 am to 12 pm</p></h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 ">
                                <div class="d-flex justify-content-center gap-3">
                                    <div style="background: #4622ac;border-radius:5px; padding:8px;margin-top:7px;margin-bottom:28px;"><img src="{{ asset('schools\assets\images\icons\people.png') }}" class="rounded-circle" width="30"
                                        height="30" alt="">
                                    </div>
                                    <h6 class="pt-1">Clock In Time<p style="font-size: 14px;color:#5b5b5b">10 am </p></h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 ">
                                <div class="d-flex justify-content-center gap-3">
                                    <div style="background: #ea8e22;border-radius:5px; padding:8px;margin-top:7px;margin-bottom:26px;"><img src="{{ asset('schools\assets\images\icons\button.png') }}" class="rounded-circle" width="30"
                                        height="30" alt="">
                                    </div>
                                    <h6 class="pt-1" style="font-size:15px">Clock Out Time<p style="font-size: 14px;color:#5b5b5b">On time</p></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chartstart pt-5" style="border:1px solid #fff ;border-radius: 10px;box-shadow:-1px 12px 20px #ddd">
                    <div id="chart">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-8 mx-auto">
             <div class="wrapper text-center" style="width:440px;height:750px;border-radius:10px;box-shadow:-3px 6px  20px #ddd">
              <header>
                <p class="current-date ms-2"></p>
                <div class="icons">
                  <span id="prev" class="material-symbols-rounded">chevron_left</span>
                  <span id="next" class="material-symbols-rounded">chevron_right</span>
                </div>
              </header>
              <div class="calender">
                <ul class="weeks">
                  <li>Sun</li>
                  <li>Mon</li>
                  <li>Tue</li>
                  <li>Wed</li>
                  <li>Thu</li>
                  <li style="color:red">Fri</li>
                  <li style="color:#7b00a7">Sat</li>
                </ul>
                <ul class="days">
                </ul>
              </div>

              <div class="row">
                <div class="col-lg-6"><h6 style="font-weight: 800">Leave/Holidays</h6></div>
                <div class="col-lg-6">
                  <div class="d-flex justify-content-center gap-3">
                    <div>
                      <h4 class="box1"></h4>
                      <p style="padding-left: 10px;font-weight:500">leave</p>
                    </div>
                    <div>
                      <h4 class="box2"></h4>
                      <p style="padding-left: 10px;font-weight:500">Holidays</p>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="holidaylist ps-2 pe-2 pt-0 pb-3">
                <ul>
                  <li>5</li>
                  <li>5</li>
                  <li>5</li>
                  <li>5</li>
                  <li>5</li>
                  <li>5</li>
                  <li>5</li>
                  <li>5</li>
                </ul>
              </div>
             </div>
        </div>
        <div class="col-lg-1 "></div>
    </main>


  <script>
    const daysTag = document.querySelector(".days"),
currentDate = document.querySelector(".current-date"),
prevNextIcon = document.querySelectorAll(".icons span");


let date = new Date(),
currYear = date.getFullYear(),
currMonth = date.getMonth();
const months = ["January", "February", "March", "April", "May", "June", "July",
              "August", "September", "October", "November", "December"];

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(),
    lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), 
    lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(),
    lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); 
    let liTag = "";

    for (let i = firstDayofMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }

    for (let i = 1; i <= lastDateofMonth; i++) { 
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() 
                     && currYear === new Date().getFullYear() ? "active" : "";
        liTag += `<li class="${isToday}">${i}</li>`;
    }

    for (let i = lastDayofMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
}
renderCalendar();

prevNextIcon.forEach(icon => { 
    icon.addEventListener("click", () => { 
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if(currMonth < 0 || currMonth > 11) { 
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear(); 
            currMonth = date.getMonth(); 
        } else {
            date = new Date();
        }
        renderCalendar();
    });
});
  </script>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var options = {
          series: [{
          name: 'Presents',
          data: [44, 55, 41, 67, 22, 43, 21, 33, 45, 31, 87, 65]
        }],
          annotations: {
          points: [{
            x: 'Presents',
            seriesIndex: 0,
            label: {
              borderColor: '#775DD0',
              offsetY: 0,
              style: {
                color: '#000000',
                background: '#7d00a7',
              },
              text: 'Presents are good',
            }
          }]
        },
        chart: {
          height: 350,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            columnWidth: '50%',
          }        },
        dataLabels: {
          enabled: false,
          style: {
    colors: ['#000000', '#000000', '#000000']
  }
          
        },
        // stroke: {
        //   width: 2,
        //   colors: ["#7a00a7"],
        // },
        grid: {
          row: {
            colors: ['#fff', '#fff']
          }
        },
        xaxis: {
          // labels: {
          // },
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June',
            'July', 'Aug', 'Sep', 'Oct', 'Nobr', 'Dec'
          ],
          tickPlacement: 'on'
        },
        yaxis: {
          title: {
            text: 'Attendance',
          },
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.25,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 0.85,
            opacityTo: 0.85,
            stops: [50, 0, 100],
            colorStops: [{
          offset: 0,
          color: "#db00b3",
          opacity: 1
        },
        {
          offset: 50,
          color: "#d254e8",
          opacity: 1
        },
        {
          offset: 100,
          color: "#7b00a7",
          opacity: 1
        }]
          },
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>


@endpush
