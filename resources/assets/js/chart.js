var chartData = $('.hide_chart').data('chart');
var chartNameData = $('.hide_chart').data('nameChart');
var chartPieData = $('.hide_chart').data('pieChart');
var fontSizeChart = $('.hide_chart').data('fontSize');
var isHasImage = $('.hide_chart').data('hasImage');

// $(function () {
//     /**
//      * BAR CHART
//      */
//     var myChart = Highcharts.chart('chart', {
//         chart: {
//             type: 'bar',
//             width: 750,
//             marginLeft: 250,
//             marginTop: 100
//         },

//         credits: {
//             enabled: false
//         },

//         legend: {
//             enabled: false
//         },

//         title: {
//             text: '',
//         },

//         tooltip: {
//             useHTML: true,
//             positioner: function () {
//                 return { x: 300, y: 10 };
//             },
//             pointFormat: '<b style="color: red; font-size: 20px">{point.y}</b><br/>',
//         },
//         xAxis: {
//             categories: chartNameData,
//             labels: {
//                 useHTML: true,
//                 style: {
//                     fontSize: fontSizeChart + 'px'
//                 }
//             }
//         },
//         yAxis: {
//             tickInterval: 1,
//             title: {
//                 text: ""
//             }
//         },
//         series: [{
//             name:'',
//             data: chartData,
//             color: 'darkcyan'
//         }],
//     });

//     /**
//      * PIE CHART
//      */
//     var myPieChart = Highcharts.chart('chart_div', {
//         chart: {
//             type: 'pie',
//             width: 800,
//             marginLeft: 100,
//             options3d: {
//                 enabled: true,
//                 alpha: 45,
//                 beta: 0
//             }
//         },

//         title: {
//             text: '',
//         },

//         credits: {
//             enabled: false
//         },

//         plotOptions: {
//             pie: {
//                 allowPointSelect: true,
//                 cursor: 'pointer',
//                 depth: 50,
//                 dataLabels: {
//                     enabled: true,
//                     formatter: function() {
//                         return this.percentage.toFixed(2) + ' %';
//                     }
//                 },
//                 showInLegend: true
//             }
//         },

//         legend: {
//             useHTML: true,
//             align: 'left',
//             maxHeight: 100,
//             labelFormatter: function () {
//                 if (isHasImage) {
//                     return (this.name.length > 154) ? this.name.substring(0, 200) + "..." : this.name;
//                 }

//                 return  (this.name.length > 100) ? this.name.substring(0, 100) + "..." : this.name;
//             }
//         },
//         tooltip: {
//             useHTML: true,
//             pointFormat: '<b style="color: red; font-size: 20px">{point.y}</b><br/>',
//         },
//         series: [{
//             data: chartPieData
//         }]
//     });
// });
var data = {
    datasets: [
        {
            label: 'TEST1',
            data: [12],
            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(255,99,132,1)'],
            borderWidth: 1
        },
        {
            label: 'TEST2',
            data: [5],
            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(255,99,132,1)'],
            borderWidth: 1
        },
        {
            label: 'TEST3',
            data: [7],
            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(255,99,132,1)'],
            borderWidth: 1
        }
    ],
};

$(document).ready(function () {
    var ctx = document.getElementById("chart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['TITLE POLL'],
            datasets: data.datasets
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            tooltips: {
                enabled: false,
                custom: function (tooltip) {
                    var tooltipEl = $('#chartjs-tooltip');

                    if (tooltip.opacity === 0) {
                        tooltipEl.css('opacity', 0);

                        return;
                    }

                    $('#chartjs-tooltip').removeClass('above below no-transform');

                    if (tooltip.yAlign) {
                        tooltipEl.addClass(tooltip.yAlign);
                    } else {
                        tooltipEl.addClass('no-transform');
                    }

                    function getBody(bodyItem) {
                        return bodyItem.lines;
                    }

                    if (tooltip.body) {
                        var titleLines = tooltip.title[0] || []
                        var bodyLines = tooltip.body[0].lines[0];

                        var inerHtml = '<img src="http://placeimg.com/640/480/any">' + bodyLines + '<span>';

                        tooltipEl.html(inerHtml);
                    }

                    var position = this._chart.canvas.getBoundingClientRect();

                    tooltipEl.css({
                        opacity: 1,
                        left: position.left + tooltip.caretX + 'px',
                        top: position.top + tooltip.caretY + 'px',
                        fontFamily: tooltip._fontFamily,
                        fontSize: tooltip.fontSize,
                        fontStyle: tooltip._fontStyle,
                        padding: tooltip.yPadding + 'px ' + tooltip.xPadding + 'px',
                    });
                    console.log(tooltip);
                }
                // callbacks: {
                //     title: function (item, data) {
                //         console.log(item, data);
                //     }
                // }
            }
        }
    });
});
