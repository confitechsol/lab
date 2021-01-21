$(document).ready(function(){


    // const element = document.getElementById('overall-status');
    // console.log( element, element.getContext('2d') );


    const $charts = $('canvas[data-init-chart]');

    $charts.each((index, element) => {
        const $chart = $(element);
        const options = $chart.data('init-chart');
        const ctx = element.getContext('2d');
        const chart = new Chart(ctx, options);
        $chart.data('chart', chart);
    });

});