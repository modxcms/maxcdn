google.load('visualization', '1', {'packages':['corechart']});
google.load('visualization', '1', {'packages':['geochart']});
google.load('visualization', '1', {'packages':['table']});

var dailyChart = function() {
    Ext.Ajax.request({
        url: MaxCDN.config.connectorUrl
        ,params: {
            'action' : 'mgr/reporting/daily'
        }
        ,success: function(r) {
            var tp = Ext.getCmp('mcdn-tabs');
            if (tp) {
                var t = tp.getActiveTab();
                var idx = tp.items.indexOf(t);
                if (idx == 0) {
                    var data = new google.visualization.DataTable(r.responseText);
                    var chart = new google.visualization.AreaChart(document.getElementById('mcdn-chart-line-daily'));
                    chart.draw(data, {
                        chartArea: {
                            width: '85%'
                        }
                        ,vAxes: {
                            0: {title: _('mcdn.reporting_hits')}
                        }
                        ,series: {
                            0: {
                                color: '#FF8000'
                            }
                            ,1: {
                                color: '#848484'
                            }
                        }
                        ,lineWidth: 3
                        ,pointSize: 1.3
                        ,pointWidth: 3
                        ,legend: {
                            position: 'bottom'
                        }
                        ,hAxis: {
                            showTextEvery: 7,
                            maxTextLines: 1,
                            maxAlternation: 1
                        }
                    });
                }
            }
        }
    });
}

var transferChart = function() {
    Ext.Ajax.request({
        url: MaxCDN.config.connectorUrl
        ,params: {
            'action' : 'mgr/reporting/transfer'
        }
        ,success: function(r) {
            var tp = Ext.getCmp('mcdn-tabs');
            if (tp) {
                var t = tp.getActiveTab();
                var idx = tp.items.indexOf(t);
                if (idx == 0) {
                    var data = new google.visualization.DataTable(r.responseText);
                    var chart = new google.visualization.ColumnChart(document.getElementById('mcdn-chart-bar-transfer'));
                    chart.draw(data, {
                        chartArea: {
                            width: '85%'
                        }
                        ,vAxes: {
                            0: {title: _('mcdn.reporting_mb_transferred')}
                        }
                        ,series: {
                            0: {
                                color: '#FF8000'
                            }
                        }
                        ,lineWidth: 3
                        ,pointSize: 1.3
                        ,pointWidth: 3
                        ,legend: {
                            position: 'bottom'
                        }
                        ,hAxis: {
                            showTextEvery: 7
                            ,maxTextLines: 1
                            ,maxAlternation: 1
                        }
                    });
                }
            }
        }
    });
}

var ratioChart = function() {
    Ext.Ajax.request({
        url: MaxCDN.config.connectorUrl
        ,params: {
            'action' : 'mgr/reporting/ratio'
        }
        ,success: function(r) {
            var tp = Ext.getCmp('mcdn-tabs');
            if (tp) {
                var t = tp.getActiveTab();
                var idx = tp.items.indexOf(t);
                if (idx == 0) {
                    var data = new google.visualization.DataTable(r.responseText);
                    var chart = new google.visualization.PieChart(document.getElementById('mcdn-chart-pie-ratio'));
                    chart.draw(data, {
                        chartArea: {
                            width: '100%'
                        }
                        ,is3D: 'false'
                        ,pieHole: 0.33
                        ,slices: {
                            0: {
                                color: '#FF8000'
                            }
                            ,1: {
                                offset: 0
                                ,color: '#848484'
                            }
                        }
                        ,legend: {
                            position: 'top'
                            ,alignment: 'center'
                        }
                    });
                }
            }
        }
    });
}

var topStats = function() {
    Ext.Ajax.request({
        url: MaxCDN.config.connectorUrl
        ,params: {
            'action' : 'mgr/reporting/topstats'
        }
        ,success: function(r) {
            var tp = Ext.getCmp('mcdn-tabs');
            if (tp) {
                var t = tp.getActiveTab();
                var idx = tp.items.indexOf(t);
                if (idx == 0) {
                    json = JSON.parse(r.responseText);
                    Ext.get('mcdn-mb-transferred').dom.innerHTML = json.size;
                    Ext.get('mcdn-non-cache-hits').dom.innerHTML = json.non_cache_hits;
                    Ext.get('mcdn-cache-hits').dom.innerHTML = json.cache_hits;
                }
            }
        }
    });
}

var popularFiles = function() {
    Ext.Ajax.request({
        url: MaxCDN.config.connectorUrl
        ,params: {
            'action' : 'mgr/reporting/popularfiles'
        }
        ,success: function(r) {
            var tp = Ext.getCmp('mcdn-tabs');
            if (tp) {
                var t = tp.getActiveTab();
                var idx = tp.items.indexOf(t);
                if (idx == 0) {
                    var json = JSON.parse(r.responseText);
                    var data = new google.visualization.DataTable();

                    data.addColumn(json.cols[0].type, json.cols[0].name);
                    data.addColumn(json.cols[1].type, json.cols[1].name);
                    data.addRows(json.rows);

                    var table = new google.visualization.Table(document.getElementById('mcdn-table-popularfiles'));
                    table.draw(data, {
                        showRowNumber: true
                        ,cssClassNames: {
                            tableCell: 'mcdn-popularfiles-cell'
                        }
                    });
                }
            }
        }
    });
}

var nodes = function() {
    Ext.Ajax.request({
        url: MaxCDN.config.connectorUrl
        ,params: {
            'action' : 'mgr/reporting/nodes'
        }
        ,success: function(r) {
            var tp = Ext.getCmp('mcdn-tabs');
            if (tp) {
                var t = tp.getActiveTab();
                var idx = tp.items.indexOf(t);
                if (idx == 0) {
                    var data = google.visualization.arrayToDataTable(JSON.parse(r.responseText));
                    var chart = new google.visualization.GeoChart(document.getElementById('mcdn-chart-geo-nodes'));
                    chart.draw(data,{
                        displayMode: 'markers'
                        ,sizeAxis: {
                            maxSize: 15
                        }
                        ,colorAxis: {
                            colors: ['#aaa','#FF8000']
                        }
                        ,datalessRegionColor: '#eee'
                        ,keepAspectRatio: true
                    });
                }
            }
        }
    });
}

var refreshReporting = function() {
    topStats();
    dailyChart();
    transferChart();
    ratioChart();
    popularFiles();
    nodes();
}

Ext.onReady(function() {
    /* only load reporting if Reporting tab is selected */
    var tp = Ext.getCmp('mcdn-tabs');
    if (tp) {
        var t = tp.getActiveTab();
        var idx = tp.items.indexOf(t);
        if (idx == 0) {
            refreshReporting();
        }
    }
});


Ext.EventManager.onWindowResize(function() {
    dailyChart();
    transferChart();
    ratioChart();
    popularFiles();
    nodes();
});