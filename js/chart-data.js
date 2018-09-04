var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
	


	// var grades = [];

	// var request = 
	// $.ajax({	
	// 	type: 'POST',
	// 	url: 'a_ChartManagement.php',	
	// 	data: 
	// 	{
	// 		action: "1"
	// 	},
	// 	dataType: 'json',
	// 	cache: false
	// });

	// request.done(function(data) 
	// { 
	// 	//iterate through json array
	// 	for (var i = 0; i < data.length; i++)
	// 	{
	// 		var obj = data[i];
	// 		grades.push(obj);

	// 	}
	// 	alert('Grade Retrieval Success!');
	// 	//callback(true);
	// });

	// request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	// {
	// 	//alert('Error in Grade retrieval!');
	// 	//callback(false); 			
	// });




	var lineChartData = {
			labels : [
			"ww_1","ww_2",
			"ww_3","ww_4",
			"ww_5","ww_6",
			"ww_7","ww_8",
			"ww_9","ww_10",
			"ww_total","ww_ps","ww_ws"],
			datasets : [
				{
					label: "test dataset",
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [

					// grades[0],grades[1],
					// grades[2],grades[3],
					// grades[4],grades[5],
					// grades[6],grades[7],
					// grades[8],grades[9],
					// grades[10],grades[11],grades[12]
					24.3721, 31.8953,
					14.5698, 28.4767,
					46.3256, 29.3953,
					63.3837, 33.9767,
					25.3140, 33.7209,
					289.8488, 260.999535, 56.756512
					]
				}
			]

		}
	

	var barChartData = {
			labels : [
			"ww_1","ww_2",
			"ww_3","ww_4",
			"ww_5","ww_6",
			"ww_7","ww_8",
			"ww_9","ww_10",
			"ww_total","ww_ps","ww_ws"],
			datasets : [
				{
					label: "IT1A",
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [

					// grades[0],grades[1],
					// grades[2],grades[3],
					// grades[4],grades[5],
					// grades[6],grades[7],
					// grades[8],grades[9],
					// grades[10],grades[11],grades[12]

					26.7212, 26.5332,
					20.6811, 31.4712,
					40.1256, 39.4353,
					63.3837, 29.0767,
					30.3012, 26.2092,
					334.1241, 266.535, 52.7512

					]
				},
				{
					label: "IT1B",
					fillColor : "rgba(20,220,220,0.2)",
					strokeColor : "rgba(20,220,220,1)",
					pointColor : "rgba(20,220,220,1)",
					pointStrokeColor : "#9ff",
					pointHighlightFill : "#9ff",
					pointHighlightStroke : "rgba(20,220,220,1)",
					data : [

					// grades[0],grades[1],
					// grades[2],grades[3],
					// grades[4],grades[5],
					// grades[6],grades[7],
					// grades[8],grades[9],
					// grades[10],grades[11],grades[12]

					26.3721, 26.8953,
					20.5698, 31.4767,
					40.3261, 39.3900,
					63.3012, 29.9771,
					30.3140, 26.7209,
					334.8488, 266.999535, 52.756512
					]
				}
			]

		}

	// var months = ["January","February","March","April","May","June","July"];	

	// var lineChartData = {
	// 		labels : months,
	// 		datasets : [
	// 			{
	// 				fillColor : "rgba(220,220,220,0.5)",
	// 				strokeColor : "rgba(220,220,220,0.8)",
	// 				highlightFill: "rgba(220,220,220,0.75)",
	// 				highlightStroke: "rgba(220,220,220,1)",
	// 				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
	// 			},
	// 			{
	// 				fillColor : "rgba(48, 164, 255, 0.2)",
	// 				strokeColor : "rgba(48, 164, 255, 0.8)",
	// 				highlightFill : "rgba(48, 164, 255, 0.75)",
	// 				highlightStroke : "rgba(48, 164, 255, 1)",
	// 				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
	// 			}
	// 		]
	
	// 	}


	// var barChartData = {
	// 		labels : ["January","February","March","April","May","June","July"],
	// 		datasets : [
	// 			{
	// 				fillColor : "rgba(220,220,220,0.5)",
	// 				strokeColor : "rgba(220,220,220,0.8)",
	// 				highlightFill: "rgba(220,220,220,0.75)",
	// 				highlightStroke: "rgba(220,220,220,1)",
	// 				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
	// 			},
	// 			{
	// 				fillColor : "rgba(48, 164, 255, 0.2)",
	// 				strokeColor : "rgba(48, 164, 255, 0.8)",
	// 				highlightFill : "rgba(48, 164, 255, 0.75)",
	// 				highlightStroke : "rgba(48, 164, 255, 1)",
	// 				data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
	// 			}
	// 		]
	
	// 	}

	var pieData = [
				{
					value: 300,
					color:"#30a5ff",
					highlight: "#62b9fb",
					label: "Blue"
				},
				{
					value: 50,
					color: "#ffb53e",
					highlight: "#fac878",
					label: "Orange"
				},
				{
					value: 100,
					color: "#1ebfae",
					highlight: "#3cdfce",
					label: "Teal"
				},
				{
					value: 120,
					color: "#f9243f",
					highlight: "#f6495f",
					label: "Red"
				}

			];
			
	var doughnutData = [
					{
						value: 300,
						color:"#30a5ff",
						highlight: "#62b9fb",
						label: "Blue"
					},
					{
						value: 50,
						color: "#ffb53e",
						highlight: "#fac878",
						label: "Orange"
					},
					{
						value: 100,
						color: "#1ebfae",
						highlight: "#3cdfce",
						label: "Teal"
					},
					{
						value: 120,
						color: "#f9243f",
						highlight: "#f6495f",
						label: "Red"
					}
	
				];

window.onload = function(){
	var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
		responsive: true
	});
	var chart2 = document.getElementById("bar-chart").getContext("2d");
	window.myBar = new Chart(chart2).Bar(barChartData, {
		responsive : true
	});
	var chart3 = document.getElementById("doughnut-chart").getContext("2d");
	window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {responsive : true
	});
	var chart4 = document.getElementById("pie-chart").getContext("2d");
	window.myPie = new Chart(chart4).Pie(pieData, {responsive : true
	});
	
};