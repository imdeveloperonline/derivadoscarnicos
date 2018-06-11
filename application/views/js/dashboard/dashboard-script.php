				/*
				 * VECTOR MAP
				 */

				$('#vector-map').vectorMap({
					map : 'co_mill',
					backgroundColor : '#fff',
					regionStyle : {
						initial : {
							fill : '#c4c4c4'
						},
						hover : {
							"fill-opacity" : 1
						}
					},
					series : {
						regions : [{
							values : data_array,
							scale : ['#85a8b6', '#4d7686'],
							normalizeFunction : 'polynomial'
						}]
					},
					onRegionLabelShow : function(e, el, code) {
						if ( typeof data_array[code] == 'undefined') {
							e.preventDefault();
						} else {
							var countrylbl = data_array[code];
							el.html(el.html() + ': ' + countrylbl + ' COP');
						}
					}
				});
								

				$('table.highchart').highchartTable();


				/* pie chart */

				if ($('#pie-chart').length) {

					/*var data_pie = [];
					var series = Math.floor(Math.random() * 10) + 1;
					
					for (var i = 0; i < series; i++) {
						data_pie[i] = {
							label : "Series" + (i + 1),
							data : Math.floor(Math.random() * 100) + 1
						}
					}*/

					$.plot($("#pie-chart"), data_pie, {
						series : {
							pie : {
								show : true,
								innerRadius : 0.5,
								radius : 1,
								label : {
									show : false,
									radius : 2 / 3,
									formatter : function(label, series) {
										return '<div style="font-size:11px;text-align:center;padding:4px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
									},
									threshold : 0.1
								}
							}
						},
						legend : {
							show : true,
							noColumns : 1, // number of colums in legend table
							labelFormatter : null, // fn: string -> string
							labelBoxBorderColor : "#000", // border color for the little label boxes
							container : null, // container (as jQuery object) to put legend in, null means default on top of graph
							position : "ne", // position of default legend container within plot
							margin : [5, 10], // distance from grid edge to default legend container within plot
							backgroundColor : "#efefef", // null means auto-detect
							backgroundOpacity : 1 // set to 0 to avoid background
						},
						grid : {
							hoverable : true,
							clickable : true
						},
					});

				}

				/* end pie chart */
