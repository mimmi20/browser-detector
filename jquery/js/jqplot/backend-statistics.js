/*
 * Build Statistics
 */
jQuery(function(){
    //console.log(jsonEvents);
    addStatistic(jsonResultCalc, 'Berechnungen (Page Impressions)');
    addStatistic(jsonResultOut,  'Anträge (Clickout)');
    addStatistic(jsonResultSale, 'Anträge (Sale)');
});

/*
 * Date Display functions
 */
var dateParser = {
    month: function()
    {
        return '%m.%Y';
    },
    
    week: function()
    {
        return '%d.%m.%Y';
    },
    
    day: function()
    {
        return '%d.%m';
    },
    
    hour: function()
    {
        return '%H';
    }
};

function parseDate()
{
    switch (jQuery('#groupValue').val()) {
        case '10': return dateParser.month(); break;
        case '20': return dateParser.week(); break;
        case '30': return dateParser.day(); break;
        case '40': return dateParser.hour(); break;
    }
}

function parseInterval()
{
    switch (jQuery('#groupValue').val()) {
        case '10': '1 month'; break;
        case '20': '1 week'; break;
        case '30': '1 day'; break;
        case '40': '1 hour'; break;
    }
}

function showTooltip(x, y, contents)
{
    jQuery('<div id="plotTip">' + contents + '</div>').css( {
        position: 'absolute',
        display: 'none',
        top: y + 5,
        left: x + 5,
        opacity: 0.80
    }).appendTo("body").fadeIn(200);
}

function addStatistic(data, name)
{
    // Clone Template DOM
    var template = jQuery('#jqTemplate').clone();
    template.attr('id', 'cloned_'+(new Date()).getTime());
    
    // Get PlotArea from the new Template
    var plotArea = template.children('.content').children('#excStat_');
    
    // Anchor to wich we append our newly generated Statistic Table
    var tableAnchor = template.children('.content').children('.table');
    
    // Set Title of Statistic
    //template.children('.head').children('span').html(name);
    
    // UniqueID for Plot Area
    var plotAreaId = 'excStat_'+(new Date).getTime();
    plotArea.attr('id', plotAreaId);
    
    // Append new Statistic to DOM
    template.appendTo('#jqAnchor');
    template.css('display', 'block');
    
    //try{
        //console.log(data[0].data[0][0]);
        //console.log(data[0].data.length);
        //console.log(data[0].data[data[0].data.length - 1][0]);
        
        var plotData   = [];
        var seriesData = [];
        var tickData   = [];
        
        for (var i=0; i<data.length; i++){ 
            plotData.push(data[i].data);
            seriesData.push({color: data[i].color, label: data[i].label});
        }
        for (var i=0; i<data[0].data.length; i++){ 
            tickData.push(data[0].data[i][0]);
        }
        //console.log(plotData);
        //console.log(seriesData);
        
        // Plot Data
        jQuery.jqplot(plotAreaId, plotData, {
            title: name,
            legend: {
                show: true,
                location: 'ne'
            },
            grid: {
                background:    '#111',
                gridLineColor: '#333'
            },
            axesDefaults: {
                autoscale: true,
                useSeriesColor: false,
                labelRenderer: jQuery.jqplot.CanvasAxisLabelRenderer,
                labelOptions: {
                    enableFontSupport: true,
                    fontFamily: 'Georgia',
                    fontSize: '9px'
                },
                rendererOptions: {
                    tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer
                },
                tickOptions: {
                    fontFamily: 'Georgia',
                    fontSize: '9px'
                }/**/
            },
            axes: {
                yaxis: {
                    min: 0,
                    label: 'Anzahl',
                    tickOptions: {
                        formatString: '%d'
                    }
                },
                xaxis: {
                    renderer: jQuery.jqplot.DateAxisRenderer,
                    tickOptions: {
                        formatString: parseDate()
                    },
                    min: data[0].data[0][0],
                    max: data[0].data[data[0].data.length - 1][0],
                    ticks: tickData,
                    label: 'Datum'
                }
            },
            seriesDefaults: {
                showMarker: true
            },
            series: seriesData,
            highlighter: {
                sizeAdjust: 4,
                formatString: '<table class="jqplot-highlighter" summary=""><tr><td>Portal:</td><td>#serieLabel#</td></tr><tr><td>Datum:</td><td>%s</td></tr><tr><td>Anzahl:</td><td>%s</td></tr></table>',
                tooltipFade: false
            },
            cursor: {show: false},
            markings: function(axis){
                marks = [];
                //console.log(axis);
                jQuery.each(jsonEvents, function(){
                    /*
                     * this[0] - time
                     * this[1] - color
                     * this[2] - icon
                     * this[3] - message
                     */
                
                    if (this[0] > axis.xaxis.min && this[0] < axis.xaxis.max) {
                        marks.push({
                            color: ('#'+this[1]),
                            xaxis: {from: this[0], to: this[0]}
                        });
                    }
                });
                /**/
                return marks;
            }
            /**/
        });
        /*
        jQuery.jqplot.postDrawSeriesHooks[0] = function(sctx, options) {
        };
        /**/
        /*
        jQuery.jqplot.postDrawHooks[0] = function() {
            console.log(this);
            //console.log(sctx);
            //console.log(options);

            var xaxis = this.axes.xaxis;
            var yaxis = this.axes.yaxis;
            var sctx  = this.baseCanvas._ctx;
            
            jQuery.each(jsonEvents, function(){
                console.log('event:'+this[0]);
                console.log('color:'+this[1]);
                console.log('min:'+xaxis.min);
                console.log('max:'+xaxis.max);
                /*
                 * this[0] - time
                 * this[1] - color
                 * this[2] - icon
                 * this[3] - message
                 */
                /*
                if (this[0] > xaxis.min && this[0] < xaxis.max) {
                    //console.log(xaxis);
                    console.log(sctx);
                    
                    sctx.strokeStyle = '#'+this[1];
                    sctx.lineWidth   = 1;
                    //ctx.moveTo(Math.floor(xrange.from), yrange.from);
                    //ctx.lineTo(Math.floor(xrange.to), yrange.to);
                    sctx.moveTo(this[0], yaxis.min);
                    sctx.lineTo(xaxis.c2p(xaxis.p2c(this[0])+2), yaxis.max);
                    sctx.stroke();
                    /*
                            marks.push({
                                color: ('#'+this[1]),
                                xaxis: {from: this[0], to: axis.xaxis.c2p(axis.xaxis.p2c(this[0])+2)}
                            });
                    /**
                }
                /**
            });
            /**
        };
        /**/
    //} catch(e) {
        //do nothing
    //}
    /*
     * Create Table Head
     */
    var table        = jQuery('<table class="zcCalcData plot" />');
    var tableHead    = jQuery('<thead />');
    var tableHeadRow = jQuery('<tr />');
    tableHeadRow.append('<th class="first">Kampagne</th>');
    jQuery.each(data[0].data, function(){
        tableHeadRow.append('<th>' + Date.create(this[0]).strftime(parseDate()) + '</th>');
    });
    tableHead.append(tableHeadRow);
    table.append(tableHead);
    
    /*
     * Create Table Content
     */
    var tableBody = jQuery('<tbody />');
    var summary   = new Array();
    var rowCycle  = 0;
    jQuery.each(data, function(rowIndex){
        var row     = jQuery('<tr />');
        if (rowCycle % 2 == 0) {
            row.attr('class', 'cycle');
        }
        rowCycle++;
        
        row.append('<td class="first"><div class="labelColor" style="background-color: '+this.color+'"></div>'+ this.label +'</td>');
        jQuery.each(this.data, function(tdIndex){
            var dataTd = jQuery('<td/>');
            dataTd.attr('class', 'data');
            if (this[1] > 0) {
                dataTd.html(this[1]);
            }
            
            if (!summary[tdIndex]) {
                summary[tdIndex] = 0;
            }
            
            summary[tdIndex] = parseFloat(summary[tdIndex]) + parseFloat(this[1]);
            row.append(dataTd);
            //row.append('<td class="data">'+ this[1] +'</td>');
        });
        tableBody.append(row);
    });
    
    /*
     * Create Summary
     */
    var tableFoot = jQuery('<tfoot />');
    var row       = jQuery('<tr/>');
    row.append('<td class="first">Gesamt</td>');
    jQuery.each(summary, function(){
        var dataTd = jQuery('<td/>');
        dataTd.attr('class', 'data summary');
        dataTd.html(String(this));
        row.append(dataTd);
    });
    tableFoot.append(row);
    table.append(tableFoot);
    table.append(tableBody);
    
    table.appendTo(tableAnchor);
}
