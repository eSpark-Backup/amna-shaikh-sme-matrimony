@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('sub-title', 'Overview & Statistics')

<!--//Page content//-->

@section('content')

<!--//Page Toolbar//-->

<div class="toolbar p-4 pb-0">

  <div class="position-relative container-fluid px-0">

    <div class="row align-items-center position-relative">

      <div class="col-md-5 mb-3 mb-lg-0">

        <h3 class="mb-2"><span class="fs-4 text-muted">Welcome back,</span>{{ Auth::user()->name }}!</h3>

        <nav aria-label="breadcrumb">

          <ol class="breadcrumb mb-0">

            <li class="breadcrumb-item"><a href="#!" class="">Home</a></li>

            <li class="breadcrumb-item active">@yield('title')</li>

            <li class="breadcrumb-item active">@yield('sub-title')</li>

          </ol>

        </nav>

      </div>

    </div>

  </div>

</div>

  <!--//Page Toolbar End//-->

<div class="content p-4 pb-0 d-flex flex-column-fluid position-relative">

  <div class="container-fluid px-0">

    <div class="row">

      <div class="col-12 col-xl-3 col-sm-6 mb-4">

        <!-- Card-->

        <div class="card overflow-hidden">

          <div class="card-body d-flex align-items-center justify-content-between">

            <div class="flex-shrink-0 size-60 bg-warning text-white rounded-3 me-3 d-flex align-items-center justify-content-center">

              <i data-feather="users" class="fe-3x d-block"></i>

            </div>

            <div class="flex-grow-1 text-start">

              <h5 class="fs-4 d-block mb-1" data-aos data-aos-id="countup:in" data-to="475"

              data-countup='{"startVal":"0","prefix":"+"}'>

              0

              </h5>

              <p class="mb-0 text-muted">New customers</p>

            </div>

          </div>

        </div>

      </div>

      <div class="col-12 col-xl-3 col-sm-6 mb-4">

        <!-- Card-->

        <div class="card overflow-hidden">

          <div class="card-body d-flex align-items-center justify-content-between">

            <div class="flex-shrink-0 size-60 bg-primary text-white rounded-3 me-3 d-flex align-items-center justify-content-center">

              <i data-feather="dollar-sign" class="fe-3x d-block"></i>

            </div>

            <div class="flex-grow-1 text-start">

              <h5 class="fs-4 d-block mb-1" data-aos data-aos-id="countup:in" data-to="37475"

              data-countup='{"startVal":"0","prefix":"$"}'>

              0

              </h5>

              <p class="mb-0 text-muted">Revenue</p>

            </div>

          </div>

        </div>

      </div>

      <div class="col-12 col-xl-3 col-sm-6 mb-4">

        <!-- Card-->

        <div class="card overflow-hidden">

          <div class="card-body d-flex align-items-center justify-content-between">

            <div class="flex-shrink-0 size-60 bg-success text-white rounded-3 me-3 d-flex align-items-center justify-content-center">

              <i data-feather="mouse-pointer" class="fe-3x d-block"></i>

            </div>

            <div class="flex-grow-1 text-start">

              <h5 class="fs-4 d-block mb-1" data-aos data-aos-id="countup:in" data-to="547"

              data-countup='{"startVal":"0","suffix":"k"}'>

              0

              </h5>

              <p class="mb-0 text-muted">Total Vistors</p>

            </div>

          </div>

        </div>

      </div>

      <div class="col-12 col-xl-3 col-sm-6 mb-4">

        <!-- Card-->

        <div class="card overflow-hidden">

          <div class="card-body d-flex align-items-center justify-content-between">

            <div class="flex-shrink-0 size-60 bg-danger text-white rounded-3 me-3 d-flex align-items-center justify-content-center">

              <i data-feather="shopping-cart" class="fe-3x d-block"></i>

            </div>

            <div class="flex-grow-1 text-start">

              <h5 class="fs-4 d-block mb-1" data-aos data-aos-id="countup:in" data-to="4468"

              data-countup='{"startVal":"0","prefix":"+"}'>

              0

              </h5>

              <p class="mb-0 text-muted">Total Sales</p>

            </div>

          </div>

        </div>

      </div>

    </div>

    

  </div>

</div>

@endsection



<!-- js -->

@section('js')

  <script>

    $(function () {

      var start = moment().subtract(6, 'days');

      var end = moment();

      function cb(start, end) {

        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

      }

      $('#reportrange').daterangepicker({

        startDate: start,

        endDate: end,

        ranges: {

          'Today': [moment(), moment()],

          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],

          'Last 7 Days': [moment().subtract(6, 'days'), moment()],

          'Last 30 Days': [moment().subtract(29, 'days'), moment()],

          'This Month': [moment().startOf('month'), moment().endOf('month')],

          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]

        }

      }, cb);

      cb(start, end);

    });

    //Init Chart

    var cPrimary = "#2794F9";

    var cWarning = "#ffb016";

    var cSecondary = "#ff4d62";

    var cSuccess = "#43b18e";

    var cMuted = "#879099";

    var cBodycolor = "#243A50";

    var cLight = "#f5f8fb";

    var cGray = "#CFDBE7";

    var cFont = "inherit";

    //-----------------------Bar Chart------------------

    new ApexCharts(document.querySelector('#chart-earnings'), {

      chart: {

        fontFamily: cFont,

        type: 'bar',

        height: 350,

        toolbar: {

          show: false,

        }

      },

      colors: [cPrimary, cWarning],

      grid: {

        borderColor: cGray,

        strokeDashArray: 6,

        padding: {

          top: 0,

          right: 20,

          bottom: 0,

          left: 20

        },

        xaxis: {

          lines: {

            show: true

          }

        },

        yaxis: {

          lines: {

            show: false

          }

        },

      },

      series: [{

        name: 'Earnings',

        data: [5717, 6432, 4214, 5214, 5021, 4212, 6247]

      },

      {

        name: 'Orders',

        data: [700, 365, 604, 394, 538, 789, 861]

      },

      ],

      xaxis: {

        labels: {

          style: {

            colors: cMuted,

            fontFamily: cFont

          }

        },

        axisTicks: {

          show: false,

        },

        axisBorder: {

          show: false,

        },

        tooltip: {

          enabled: false

        },

        categories: ['Mon', 'Tue', 'Wed', 'Thr', 'Fri', 'Sat', 'Sun'],

        crosshairs: {

          show: false,

          fill: {

            type: 'solid',

            color: cPrimary

          },

          stroke: {

            color: cLight,

            width: 1,

            dashArray: 6,

          },

        }

      },

      yaxis: {

        labels: {

          style: {

            colors: cMuted,

            fontFamily: cFont

          }

        },

        crosshairs: {

          show: false,

        }

      },

      plotOptions: {

        bar: {

          columnWidth: '40%',

          borderRadius: 4,

        },

      },

      dataLabels: {

        enabled: false

      },

      stroke: {

        show: false,

      },

      tooltip: {

        shared: true,

        intersect: false,

        y: [

        {

          formatter: function (y) {

            if (typeof y !== "undefined") {

              return " $" + y.toFixed(0);

            }

            return y;

          }

        },

        {

          formatter: function (y) {

            if (typeof y !== "undefined") {

              return y.toFixed(0) + " Items";

            }

            return y;

          }

        }

        ]

      },

      legend: {

        position: 'top',

        fontFamily: cFont,

        labels: {

          colors: cMuted

        },

        markers: {

          width: 12,

          height: 12,

          radius: 16

        }

      },

    }).render()

    //-----------------------Radial Bar Chart------------------

    new ApexCharts(document.querySelector('#chart-traffic'), {

      series: [

      {

        name: ["Organic"],

        data: [27, 26, 22, 20, 18, 15, 12]

      },

      {

        name: ["Direct"],

        data: [23, 22, 18, 16, 14, 9, 8]

      },

      {

        name: ["Referral"],

        data: [12, 10, 8, 7, 5, 3, 2]

      },

      ],

      chart: {

        fontFamily: cFont,

        height: 300,

        type: 'line',

        toolbar: {

          show: false

        },

        zoom: {

          enabled: false

        }

      },

      stroke: {

        width: 2,

        curve: 'straight'

      },

      colors: [cWarning, cPrimary, cSuccess],

      grid: {

        borderColor: cGray,

        strokeDashArray: 6,

        padding: {

          top: 0,

          right: 30,

          bottom: 0,

          left: 20

        },

        xaxis: {

          lines: {

            show: false

          }

        },

        yaxis: {

          lines: {

            show: true

          }

        },

      },

      xaxis: {

        categories: ['Mon', 'Tue', 'Wed', 'Thr', 'Fri', 'Sat', 'Sun'],

        crosshairs: {

          show: false

        },

        labels:{

          style: {

            colors: cMuted,

            offsetX: -65,

          },

        },

        axisTicks: {

          show: false,

        },

        axisBorder: {

          show: false,

        },

        tooltip: {

          enabled: true

        },

      },

      yaxis: {

        labels: {

          formatter: function (y) {

            return y + "k"

          },

          style: {

            offsetX: 15,

            colors: cMuted,

          },

        },

      },

      legend: {

        show: false

      }

    }).render()

    //Sparkline charts

  </script>

@endsection