
$(document).ready(function() 
{

	$('#dropDown_Main_SchoolYear').change(function(e) 
	{	
		dropDownChange(2);
	});

	$('#dropDown_Main_GradeLevel').change(function(e) 
	{	
		dropDownChange(3);
	});

	$('#dropDown_Main_Section').change(function(e) 
	{	
		dropDownChange(4);
	});

	$('#dropDown_Main_Subject').change(function(e) 
	{	
		dropDownChange(5);
	});	

});  



//---------------------------------------------------------------------------
// O N   L O A D / C L I C K / C H A N G E   C A L L B A C K   N E S T
//---------------------------------------------------------------------------



window.onload = function()
{
	dropDownChange(1);
}


async function dropDownChange(phase)
{

	switch (phase) 
	{
        //start from syterm



		case 1:
		{

      await ajax_LoadSYTerms();
      await ajax_LoadGradeLevels();
      await ajax_LoadSections();
      await ajax_LoadSubjects();
      await ajax_GetClass()
      .then(function(result)
      {
        if (result != '')
        {
          charts_LoadCharts(result);
        }
      });

			break;
		}

        //start from gradeLevel
		case 2:
		{
      await ajax_LoadGradeLevels();
      await ajax_LoadSections();
      await ajax_LoadSubjects();
      await ajax_GetClass()
      .then(function(result)
      {
        if (result != '')
        {
          charts_LoadCharts(result);
        }
      });
			break;
		}

        //start from section
		case 3:
		{
      await ajax_LoadSections();
      await ajax_LoadSubjects();
      await ajax_GetClass()
      .then(function(result)
      {
        if (result != '')
        {
          charts_LoadCharts(result);
        }
      });
			break;
		}

        //start from subject
		case 4:
		{
      await ajax_LoadSubjects();
      await ajax_GetClass()
      .then(function(result)
      {
        if (result != '')
        {
          charts_LoadCharts(result);
        }
      });
			break;
		}

        //immediately load charts
		case 5:
		{
      await ajax_GetClass()
      .then(function(result)
      {
        if (result != '')
        {
          charts_LoadCharts(result);
        }
      });
		}

	}

}



//---------------------------------------------------------------------------
// D R O P D O W N   O P E R A T I O N S
//---------------------------------------------------------------------------



async function ajax_LoadSYTerms()
{

  var dropDown  = document.getElementById("dropDown_Main_SchoolYear");
	emptyDropdown(dropDown);

  return promise = new Promise((resolve, reject) =>
  { 
    
    $.ajax({	
		type: 'POST',
		url: 'Backend/a_Charts.php',	
		data: 
		{
			action: "1"
		},
		dataType: 'JSON',
		cache: false
    })

  	.done(function(data) 
  	{ 
  		//iterate through json array
  		for (var i = 0; i < data.length; i++)
  		{
  			var obj = data[i];

  			var optionEntry = document.createElement("option");
  			optionEntry.text = "SY "+ obj['schoolYear'] + ' Term ' + obj['termNumber'];
  			optionEntry.value = obj['syTermID'];

  			dropDown.options.add(optionEntry);
  		}

  		resolve();
  	})

  	.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  	{
  		console.log('ERR: Cannot Retrieve schoolYear. ' + errorThrown);
  		reject(); 			
  	});
  });
}


async function ajax_LoadGradeLevels(callback)
{

  var dropDown = document.getElementById("dropDown_Main_GradeLevel");
	emptyDropdown(dropDown);

	var schoolYear = document.getElementById('dropDown_Main_SchoolYear');

  return promise = new Promise((resolve, reject) =>
  {

    $.ajax({	
    	type: 'POST',
    	url: 'Backend/a_Charts.php',	
    	data: 
    	{
    		action: "2",
    		sent_SchoolYear: schoolYear.value
    	},
    	dataType: 'JSON',
    	cache: false
  	})

  	.done(function(data) 
  	{ 
  		//iterate through json array
  		for (var i = 0; i < data.length; i++)
  		{

  			var obj = data[i];


  			var optionEntry = document.createElement("option");
  			optionEntry.text = "Grade "+ obj['gradeLevelID'];
  			optionEntry.value = obj['gradeLevelID'];

  			dropDown.options.add(optionEntry);
  		}
  		resolve();
  	})

  	.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  	{
  		console.log('ERR: Cannot retrieve gradeLevel. ' + errorThrown);
  		reject(); 			
  	})
  });
}


async function ajax_LoadSections()
{
  var dropDown = document.getElementById("dropDown_Main_Section");
	emptyDropdown(dropDown);

	var schoolYear = document.getElementById('dropDown_Main_SchoolYear');
	var gradeLevel = document.getElementById('dropDown_Main_GradeLevel');

  return promise = new Promise((resolve, reject) =>
  {
    $.ajax({	
		type: 'POST',
		url: 'Backend/a_Charts.php',	
		data: 
		{
			action: "3",
			sent_SchoolYear : schoolYear.value,
			sent_GradeLevel : gradeLevel.value
		},
		dataType: 'JSON',
		cache: false
	  })

  	.done(function(data) 
  	{ 

  		for (var i = 0; i < data.length; i++)
  		{

  			var obj = data[i];

  			var optionEntry = document.createElement("option");
  			optionEntry.text = "Section "+ obj['sectionName'];
  			optionEntry.value = obj['sectionID'];

  			dropDown.options.add(optionEntry);
  		}
  		resolve();
  	})

  	.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  	{
  		console.log('ERR:: Cannot Retrieve Section. ' + errorThrown);
  		reject(); 			
  	});
  });
}


async function ajax_LoadSubjects()
{

  var control_DropDown = document.getElementById("dropDown_Main_Subject");
	emptyDropdown(control_DropDown);

	var var_SchoolYear = document.getElementById('dropDown_Main_SchoolYear').value;
	var var_Section = document.getElementById('dropDown_Main_Section').value; 

  return promise = new Promise((resolve, reject) =>
  {

  	$.ajax({	
  		type: 'POST',
  		url: 'Backend/a_Charts.php',	
  		data: 
  		{
  			action: "4",
        sent_SchoolYear : var_SchoolYear,
  			sent_SectionID : var_Section
  		},
  		dataType: 'JSON',
  		cache: false
  	})

  	.done(function(data) 
  	{ 
  		//iterate through json array
  		for (var i = 0; i < data.length; i++)
  		{
  			var var_Obj = data[i];

  			var optionEntry = document.createElement("option");
  			optionEntry.text = var_Obj['subjectName'];
  			optionEntry.value = var_Obj['subjectID'];

  			control_DropDown.options.add(optionEntry);
  		}
  		resolve();
  	})

  	.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  	{
  		console.log('ERR: Cannot Retrieve Subject. ' + errorThrown);
  		reject(); 			
  	});

  });
}



//---------------------------------------------------------------------------
// G E T   C L A S S   A J A X
//---------------------------------------------------------------------------


	async function ajax_GetClass()
	{

		var schoolYear = document.getElementById('dropDown_Main_SchoolYear').value; 
		var section    = document.getElementById('dropDown_Main_Section').value; 
		var subject    = document.getElementById("dropDown_Main_Subject").value; 

    return promise = new Promise((resolve, reject) =>
    {

  		$.ajax(
  		{	
  			type: 'POST',
  			url: 'Backend/a_Charts.php',	
  			data: 
  			{
  				action: "5",

  				sent_SchoolYear : schoolYear,  
  				sent_Section    : section, 
  				sent_Subject    : subject 
  			},
  			dataType: 'JSON',
  			cache: false
  		})

  		.done(function(data) 
  		{ 
  			resolve(data);
  		})

  		.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  		{
  			console.log('ERR: Cannot retrieve class. ' + errorThrown);
  			reject(); 			
  		})
    });
	}




//---------------------------------------------------------------------------
// 	C H A R T   O P E R A T I O N S :   A J A X E S
//---------------------------------------------------------------------------



function ajax_GetChartData_SingleSubjectClassWWAverage(classID, callback)
{

	var request = $.ajax(
	{	
		type: 'POST',
		url: 'Backend/a_Charts.php',	
		data: 
		{
			action: "11",
			sent_ClassID : classID
		},
		dataType: 'JSON',
		cache: false
	});

	request.done(function(data) 
	{ 
		callback(data);
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('ERR: Cannot build Chart 1.');
		callback(false); 			
	});
}



function ajax_GetChartData_SingleSubjectClassPTAverage(classID, callback)
{
	var request = $.ajax(
	{	
		type: 'POST',
		url: 'Backend/a_Charts.php',	
		data: 
		{
			action: "12",
			sent_ClassID : classID
		},
		dataType: 'JSON',
		cache: false
	});

	request.done(function(data) 
	{ 
		callback(data);
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('ERR: Cannot build Chart 2.');
		callback(false); 			
	});
}


function ajax_GetChartData_PassFail(classID, callback)
{
	var request = $.ajax(
	{	
		type: 'POST',
		url: 'Backend/a_Charts.php',	
		data: 
		{
			action: "13",
			sent_ClassID : classID
		},
		dataType: 'JSON',
		cache: false
	});

	request.done(function(data) 
	{ 
		callback(data);
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('ERR: Cannot build Chart 3.');
		callback(false); 			
	});
}


function ajax_GetChartData_QuarterlyGrade(classID, callback)
{
	var request = $.ajax(
	{	
		type: 'POST',
		url: 'Backend/a_Charts.php',	
		data: 
		{
			action: "14",
			sent_ClassID : classID
		},
		dataType: 'JSON',
		cache: false
	});

	request.done(function(data) 
	{ 
		callback(data);
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('ERR: Cannot build Chart 4.');
		callback(false); 			
	});
}



//---------------------------------------------------------------------------
// B U I L D   C H A R T   A F T E R   A J A X
//---------------------------------------------------------------------------

async function charts_LoadCharts(data)
{

    var classID = data;

    // Call Every Chart

    ajax_GetChartData_SingleSubjectClassWWAverage(classID, function(result)
    {
        if (result != false)
        {
            charts_BuildChart_Bar_SingleSubjectClassWWAverageGrade(result);
        }
        else
        {
            console.log("ERR: cannot get data for single subject class WW average chart.")
        }
    });


    ajax_GetChartData_SingleSubjectClassPTAverage(classID, function(result)
    {
        if (result != false)
        {
            charts_BuildChart_Bar_SingleSubjectClassPTAverageGrade(result);
        }
        else
        {
            console.log("ERR: cannot get data for single subject class PT average chart.")
        }
    });

    ajax_GetChartData_PassFail(classID, function(result)
    {
        if (result != false)
        {
            charts_BuildChart_Pie_PassFail(result);
        }
        else
        {
            console.log("ERR: cannot get data for pass Fail pie chart.")
        }
    });

    ajax_GetChartData_QuarterlyGrade(classID, function(result)
    {
        if (result != false)
        {
            charts_BuildChart_PBar_QuarterlyGrade(result);
        }
        else
        {
            console.log("ERR: cannot get data for single subject class QA average chart.")
        }
    });
}

function charts_BuildChart_Bar_SingleSubjectClassWWAverageGrade(data)
{
	var tableHeadData = "";
	var tableRowData = "";

	var x = [];
	var y = [];

	for(var i in data[0])
	{

	  x.push(i);  
	  y.push(data[0][i]); 

	  tableHeadData += "<th align = center>" + i + "</th>";
	  tableRowData += " <td>" + data[0][i] + "</td> ";
	}


	var chartdata = 
	{
		labels : x,
		datasets :
		[
			{ 
				backgroundColor: 'rgba(200, 200, 200, 0.75)',
				strokeColor : "rgba(220,220,220,1)",
				borderColor: 'rgba(200, 200, 200, 0.75)',
				hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
				hoverBorderColor: 'rgba(200, 200, 200, 1)',

				
				data: y,
			}
		]
	};	


	$('#chart1').remove();
  	$('.chart1Container').append('<canvas id="chart1"><canvas>');


	chart1 = document.getElementById("chart1").getContext("2d");
	window.chart = new Chart(chart1).Bar(chartdata, 
	{
		responsive: true
	});

	var chart1Title = document.getElementById("chart1Name");
	
	var section = document.getElementById('dropDown_Main_Section');  
	var sectionName = section.options[section.selectedIndex].text;

	var subject = document.getElementById("dropDown_Main_Subject");  
	var subjectName = subject.options[subject.selectedIndex].text;

	chart1Title.innerHTML = 'Average Written Works Grades of Section ' + sectionName + ' in subject ' + subjectName;


	document.getElementById("tableHead1").innerHTML = tableHeadData;	
	document.getElementById("tableRow1").innerHTML = tableRowData;
}



function charts_BuildChart_Bar_SingleSubjectClassPTAverageGrade(data)
{

	var tableHeadData = "";
	var tableRowData = "";

	var x = [];
	var y = [];

	for(var i in data[0])
	{
	  //alert(i + ' = ' + data[0][i]); // alerts key

	  x.push(i);  
	  y.push(data[0][i]);

	  tableHeadData += "<th align = center>" + i + "</th>";
	  tableRowData += " <td>" + data[0][i] + "</td> ";
	}


	var chartdata = 
	{
		labels : x,
		datasets :
		[
			{ 
				backgroundColor: 'rgba(200, 200, 200, 0.75)',
				strokeColor : "rgba(220,220,220,1)",
				borderColor: 'rgba(200, 200, 200, 0.75)',
				hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
				hoverBorderColor: 'rgba(200, 200, 200, 1)',

				
				data: y,
			}
		]
	};	


	$('#chart2').remove();
  	$('.chart2Container').append('<canvas id="chart2"><canvas>');

	var chart2 = document.getElementById("chart2").getContext("2d");
	window.chart = new Chart(chart2).Bar(chartdata, 
	{
		responsive: true
	});

	var chart2Title = document.getElementById("chart2Name");
	
	var section = document.getElementById('dropDown_Main_Section');  
	var sectionName = section.options[section.selectedIndex].text;

	var subject = document.getElementById("dropDown_Main_Subject");  
	var subjectName = subject.options[subject.selectedIndex].text;

	chart2Title.innerHTML = 'Average Performance Tasks Grades of Section ' + sectionName + ' in subject ' + subjectName;

	document.getElementById("tableHead2").innerHTML = tableHeadData;	
	document.getElementById("tableRow2").innerHTML = tableRowData;
}


function charts_BuildChart_Pie_PassFail(data)
{

	var totalValues = parseInt(data[0].PASS) + parseInt(data[0].FAIL);
	var passPercentage = parseFloat(((data[0].PASS / totalValues) * 100).toFixed(4));
	var failPercentage = parseFloat(((data[0].FAIL / totalValues) * 100).toFixed(4));
	
	var chartData = 
	[
	   {
	      value: passPercentage,
	      label: 'PASS : ' + data[0].PASS + ' students',
	      color: '#811BD6'
	   },
	   {
	      value: failPercentage,
	      label: 'FAIL : ' + data[0].FAIL + ' students',
	      color: '#9CBABA'
	   }
    ];


	$('#chart3').remove();
  	$('.chart3Container').append('<canvas id="chart3"><canvas>');


	var chart3 = document.getElementById("chart3").getContext("2d");
	window.chart = new Chart(chart3).Pie(chartData, 
	{
		responsive: true,
		tooltipTemplate: "<%= label %> (<%= value %>%)"
	});

	var chart3Title = document.getElementById("chart3Name");
	
	var section = document.getElementById('dropDown_Main_Section');  
	var sectionName = section.options[section.selectedIndex].text;

	var subject = document.getElementById("dropDown_Main_Subject");  
	var subjectName = subject.options[subject.selectedIndex].text;

	chart3Title.innerHTML = 'Pass / fail percentages of ' + sectionName + ' in subject ' + subjectName;	
	document.getElementById("legendDiv").innerHTML = window.chart.generateLegend();

}


function charts_BuildChart_PBar_QuarterlyGrade(data)
{
	var pBarArray = document.getElementById("progressBarArray");
	pBarArray.innerHTML = "";

	for (var i = 0 ; i < data.length ; i++)
	{	
		
		pBarArray.innerHTML += 
		'</br>											\
		<div class= "progressBarStudentName">'+data[i].student_name+'</div>	\
		<div class="progressBarBG"><div class="progressBar id = "pBar_'+ i+'"\
		style="width: '+data[i].quarterly_grade+'%;">'+data[i].quarterly_grade+'</div></div>';		
	}


    var section = document.getElementById('dropDown_Main_Section');  
    var sectionName = section.options[section.selectedIndex].text;
    
    var subject = document.getElementById("dropDown_Main_Subject");  
    var subjectName = subject.options[subject.selectedIndex].text;

    var chart4Title = document.getElementById("chart4Name");
    chart4Title.innerHTML = 'Individual Quarterly Grades of Students in section ' + sectionName + ' in subject ' + subjectName; 
	
}


function charts_MoveProgressBar()
{
	var pBarArray = document.getElementsByClassName("progressBar");
	var width = 1;
  	var id = setInterval(frame, 1);
	for(var i = 0; i < pBarArray.length; i++)
	{
	 	var id = setInterval(frame, 10);
		function frame() 
		{
    		if (width >= 100) 
    		{
      			clearInterval(id);
    		} else 
    		{
      			width++; 
      			pBarArray[i].style.width = width + '%'; 
			}	
		}
	}

}

//---------------------------------------------------------------------------
// C L E A R   D R O P D O W N S 
//---------------------------------------------------------------------------


function emptyDropdown(dropDown)
{
    var i;
    for(i = dropDown.options.length - 1 ; i >= 0 ; i--)
    {
        dropDown.remove(i);
    }
}


