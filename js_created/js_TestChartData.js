$(document).ready(function() 
{
	loadCharts();
});


function loadCharts()
{
								//erase
								var aaa = document.getElementById('canvas-wrapper1');
								aaa.innerHTML = ('<canvas id="line-charta"></canvas>');

								//fill with new data
								var ctx = document.getElementById('line-charta').getContext("2d");
								var myChart = new Chart(ctx, {
								  type: 'line',
								  
								    data: 
								    {
									    labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
									    datasets: 
									    [{
									      label: 'apples',
									      data: [12, 19, 3, 17, 6, 3, 7],
									      backgroundColor: "rgba(153,255,51,0.4)"
									    }, 
									    {
									      label: 'oranges',
									      data: [2, 29, 5, 5, 2, 3, 10],
									      backgroundColor: "rgba(255,153,0,0.4)"
									    }]

								    }
								});
}


