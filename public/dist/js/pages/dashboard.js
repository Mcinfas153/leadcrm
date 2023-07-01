$(function () {
  //
  // Carousel
  //
  $(".counter-carousel").owlCarousel({
    loop: true,
    margin: 30,
    mouseDrag: true,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplaySpeed: 2000,
    nav: false,
    rtl: true,
    responsive: {
      0: {
        items: 2,
      },
      576: {
        items: 2,
      },
      768: {
        items: 3,
      },
      1200: {
        items: 5,
      },
      1400: {
        items: 6,
      },
    },
  });

  // =====================================
  // Daily Leads Active
  // =====================================

  var dailyLeadsConfig = {
    series: [
      {
        name: "Daily Leads",
        data: dailyLeads,
      },
    ],

    chart: {
      toolbar: {
        show: false,
      },
      height: 260,
      type: "bar",
      fontFamily: "Plus Jakarta Sans', sans-serif",
      foreColor: "#F1A208",
    },
    colors: ["#F1A208"],
    plotOptions: {
      bar: {
        borderRadius: 4,
        columnWidth: "45%",
        distributed: true,
        endingShape: "rounded",
      },
    },

    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    grid: {
      yaxis: {
        lines: {
          show: true,
        },
      },
      xaxis: {
        lines: {
          show: false,
        },
      },
    },
    xaxis: {
      categories: monthDates,
      style: {
        colors: "#F1A208",
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      labels: {
        show: true,
        style: {
          colors: "#005377",
        },
      },
    },
    tooltip: {
      theme: "dark",
    },
  };

  var chart = new ApexCharts(document.querySelector("#daily-leads"), dailyLeadsConfig);
  chart.render();

  // =====================================
  // Monthly Leads Active
  // =====================================

  var options = {
    series: [{
      name: "Monthly Leads",
      data: [28, 29, 33, 36, 32, 32, 33],
    }
    ],
    chart: {
      fontFamily: '"Nunito Sans",sans-serif',
      height: 350,
      type: "line",
      dropShadow: {
        enabled: true,
        color: "#000",
        top: 18,
        left: 7,
        blur: 10,
        opacity: 0.2,
      },
      toolbar: {
        show: false,
      },
    },
    colors: ["#052F5F"],
    dataLabels: {
      enabled: true,
    },
    stroke: {
      curve: "smooth",
    },
    grid: {
      borderColor: "transparent",
      row: {
        colors: ["#06A77D", "transparent"], // takes an array which will be repeated on columns
        opacity: 0.1,
      },
    },
    markers: {
      size: 1,
    },
    xaxis: {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      labels: {
        style: {
          colors: "#F1A208",
        },
      },
    },
    yaxis: {
      min: 5,
      max: 40,
      labels: {
        style: {
          colors: "#005377"
        },
      },
    },
    tooltip: {
      theme: "dark",
    },
    legend: {
      position: "top",
      horizontalAlign: "right",
      floating: true,
      offsetY: -25,
      offsetX: -5,
    },
  };

  var chart_line_data = new ApexCharts(
    document.querySelector("#monthly-leads"),
    options
  );
  chart_line_data.render();

});
