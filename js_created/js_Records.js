
$(document).ready(function() 
{

	//WHEN USER CLICKS THE SHOWTABLE BUTTON.
	$('#showTable').click(function(e)
	{

		var selectedClass = document.getElementById("dropDown_ClassDropDown");


		var test = retrieveChartData(selectedClass.value);

		//Head
		var thead = "<thead>";
	  	for (var i = 0 ; i < test[0].length ; i++)
		{
			thead = thead + "<th>" + test[0][i]  + "</th>";
		}
		thead = thead + "</thead>\n" ;

		//Body
		var tbody = "<tbody>\n";
	  	for (var i = 1 ; i < test.length ; i++)
		{
			tbody = tbody + "<tr>";
			for  (var j = 0 ; j < test[i].length ; j++)
			{
				tbody = tbody + "<td>" + test[i][j] + "</td>";
			}
			tbody = tbody + "</tr>\n";
		}		
		tbody = tbody + "</tbody>" ;


		var recordsTable =  document.getElementById('recordsTable'); 
		recordsTable.innerHTML = thead + tbody; 
	});

	//Download CSV based on the selected item in the dropdown box.
	//YOU CTRL+C'd this. REFINE THIS.
	$('#downloadCSV').click(function(e)
	{

		var selectedClass = document.getElementById("dropDown_ClassDropDown");
		var data = retrieveChartData(selectedClass.value);

		var csvContent = "data:text/csv;charset=utf-8,";
		data.forEach(function(infoArray, index){

		   dataString = infoArray.join(",");
		   csvContent += index < data.length ? dataString+ "\n" : dataString;

		}); 

		var encodedUri = encodeURI(csvContent);
		var link = document.createElement("a");
		link.setAttribute("href", encodedUri);
		link.setAttribute("download", "my_data.csv");
		document.body.appendChild(link); 

		link.click();
	});

});

function retrieveChartData(selectedClass)
{
	var returnValue;

	var request = $.ajax({	
		type: 'POST',
		url: 'Backend/a_Records.php',	
		data: 
		{
			action: "1",
			selectedClass: selectedClass
		},
		dataType: 'JSON', 
		async: false,
		cache: false 
	});

	request.done(function(data) 
	{ 
		console.log('success');
		returnValue = data;
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		console.log('ERR: Cannot Retrieve Chart Data: 94');
		console.error(XMLHttpRequest + " - " + textStatus + " - " + errorThrown);
		//callback(false);		
	}); 

	return returnValue;
}

function getChartColumns()
{

}

function getChartEntries()
{

}
