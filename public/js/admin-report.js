var Report = {
    Color: {
        solid: {
            red: '#BE1D23',
            pink: '#e91e63',
            purple: '#9c27b0',
            deep_purple: '#673ab7',
            indigo: '#3f51b5',
            blue: '#2196f3',
            navy_blue: '#00447B',
            light_blue: '#03a9f4',
            cyan: '#00bcd4',
            teal: '#009688',
            green: '#4caf50',
            light_green: '#8bc34a',
            lime: '#cddc39',
            yellow: '#ffeb3b',
            amber: '#ffc107',
            orange: '#ff9800',
            deep_orange: '#ff5722',
            gold: '#f4d142',
            index: [
                'red',
                'pink',
                'purple',
                'deep_purple',
                'indigo',
                'blue',
                'navy_blue',
                'light_blue',
                'cyan',
                'teal',
                'green',
                'light_green',
                'lime',
                'yellow',
                'amber',
                'orange',
                'deep_orange',
                'gold',
            ]
        },

        // Return a static array of colors for reports that 
        // want to keep consistent color between visits
        staticArray: function(count) {
            var colors = [], i = 1;
            while (colors.length < count) {
                colors.push(Report.Color.solid[Report.Color.solid.index[(i*4) % (Object.keys(Report.Color.solid).length-1)]]);
                i++;
            }
            return colors;
        }
    }
};
(function () {
    // Load Customer Purchase Count Bar Graph report
    Report.loadCustomerPurchaseCountBarGraph = function (element) {
        var params = {};
        if ($('#date-range-start').length > 0 && $('#date-range-end').length > 0) {
            params.date_range_start = $('#date-range-start').val();
            params.date_range_end = $('#date-range-end').val();
        }

        // Setup loading gif
        $(element).addClass('loading');

        $.ajax({
            type: "GET",
            url: "/admin/report/ajax-product-type-purchase-report",
            data: params
        })
        .done(function(response) {
            try {
                if (!response) {
                    throw new Exception("Failed to get purchase data.");
                }
                if (Report.customer_purchase_count_bar_graph) {
                    Report.customer_purchase_count_bar_graph.destroy();
                }
                Report.customer_purchase_count_bar_graph = new Chart(
                    $(element),
                    {
                        type: 'bar',
                        data: {
                            labels: response.graph.labels,
                            datasets: (function(response) {
                                var datasets = [], type_object, colors = Report.Color.staticArray(Object.keys(response.graph.data).length);
                                for (var property in response.graph.data) {
                                    if (response.graph.data.hasOwnProperty(property) && property != '') {
                                        type_object = {
                                            label: property,
                                            data: response.graph.data[property],
                                            backgroundColor: colors[datasets.length]
                                        }
                                        datasets.push(type_object);
                                    }
                                };
                                return datasets;
                            })(response)
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            },
                            legend: {
                                display: true
                            },
                        }
                    }
                );
            } catch (e) {
                console.error(e);
            }
            // Takedown loading gif
            $(element).removeClass('loading');
        });
    }

    Report.loadReports = function() {
        // Customer Purchase Count Bar Graph
        var customer_purchase_count_bar_graph = $('[sbs-report="customer-purchase-count-bar-graph"]');
        if ($(customer_purchase_count_bar_graph).length > 0) {
            Report.loadCustomerPurchaseCountBarGraph(customer_purchase_count_bar_graph);
        };
    };
})();
$(window).load(function(){
    // Load charts
    Report.loadReports();
});
