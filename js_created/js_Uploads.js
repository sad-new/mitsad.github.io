function object_SYTerm()
{
  var syTermID = ""; 
  var schoolYear = "";
  var termNumber = "";



  this.getSYTermID = function()
  {
    return syTermID;
  };

  this.getSchoolYear = function()
  {
    return schoolYear;
  }

  this.getTermNumber = function()
  {
    return termNumber;
  }



  this.setSYTermID = function(var_SYTermID)
  {
    syTermID = var_SYTermID;
  };

  this.setSchoolYear = function(var_SchoolYear)
  {
    schoolYear = var_SchoolYear;
  };

    this.setTermNumber = function(var_TermNumber)
  {
    termNumber = var_TermNumber;
  };
}




$(document).ready(function() 
{

  var object_ActiveSYTerm = new object_SYTerm();

  loadControls(object_ActiveSYTerm);


	var studentEntries = [];
	//var gradeUploads = [];

	//capture CSV
	document.getElementById('fileCSV').onchange = function()
	{

  		//get filetype
  		var file = this.files[0];
  		alert(getFileType(this.files[0]));

  		//start reading
  		var reader = new FileReader();
  		//reader file WORKS!

  		testArray = [];
  		reader.onload = function(e)
  		{

		    var workbook = XLSX.read(this.result, 
		    {
		    	type: 'binary'
		    });


		    //READ AND PARSE THE FIRST SHEET
		    var sheet1 = workbook.Sheets[workbook.SheetNames[0]];


		    var XL_Worksheet = XLSX.utils.sheet_to_row_object_array(sheet1);

		    //GET KEY NAMES, PLACE ON FIRST ROW
		    rowNames = [];
		    for (var key in (XL_Worksheet[0]))
		    {
		      	rowNames.push(key);
		    }
		    testArray.push(rowNames);
		    //alert(testArray);


		    //GET ALL THE MALE STUDENTS
		    workbook.Sheets[workbook.SheetNames[0]]['!ref'] =  "B12:B61";
		    var excelEntries = (XLSX.utils.sheet_to_row_object_array(sheet1, {header:1}));


		    //iterate through all name entries, extract the non-null ones
		    var gradeColumns = 
		    [
		    	"student_name",

		    	"ww_1", "ww_2", "ww_3", "ww_4", "ww_5", 
		    	"ww_6", "ww_7", "ww_8", "ww_9", "ww_10", 
		    	"ww_total", "ww_ps", "ww_ws", 

		    	"pt_1", "pt_2", "pt_3", "pt_4", "pt_5", 
		    	"pt_6", "pt_7", "pt_8", "pt_9", "pt_10", 
		    	"pt_total", "pt_ps", "pt_ws", 

		    	"qa_1", "qa_ps", "qa_ws", 

		    	"initial_grade", "quarterly_grade" 
		    ];

		    studentEntries.push(gradeColumns);

	     	for (var i = 0 ; i < excelEntries.length ; i++)
		    {
		      	if (excelEntries[i] != "")
		       	{
		       		var studentEntriesRow = []; 

		       		studentEntriesRow.push(excelEntries[i][0]);  

		       		workbook.Sheets[workbook.SheetNames[0]]['!ref'] =  "F"+ (12+i) + ":AJ" +  (12+i);
		       		var gradeEntries = (XLSX.utils.sheet_to_row_object_array(sheet1, {header:1}));


		       		for (var j = 0 ; j < gradeEntries[0].length ; j++)
		       		{
		       			studentEntriesRow.push(gradeEntries[0][j]);
		       		}

		       	   	studentEntries.push(studentEntriesRow);
		       	}
		    }
	   		//alert(JSON.stringify(studentEntries));


	  		// programmatically create table. this is some terrible code.
	  		var thead = "<thead>";
	  		for (var i = 0 ; i < studentEntries[0].length ; i++)
			{
				thead = thead + "<th>" + studentEntries[0][i]  + "</th>";
			}
			thead = thead + "</thead>\n" ;

			var tbody = "<tbody>\n";
	  		for (var i = 1 ; i < studentEntries.length ; i++)
			{
				tbody = tbody + "<tr>";
				for  (var j = 0 ; j < studentEntries[i].length ; j++)
				{
					tbody = tbody + "<td>" + studentEntries[i][j] + "</td>";
				}
				tbody = tbody + "</tr>\n";
			}			
			tbody = tbody + "</tbody>" ;


			//place data
  			var uploadsTable =  document.getElementById('uploadsTable'); 
  			uploadsTable.innerHTML = thead + tbody;
  		};

  		//display
  		reader.readAsBinaryString(file);
	};

	//Place CSV to DB
	$(document).on("click", '#submitCSV', function()
	{

		var dropDown = document.getElementById("classDropDown");
		var selectedValue = dropDown.options[dropDown.selectedIndex].value;

    ajax_UploadCSVTable(studentEntries, selectedValue, accountID);
	});

});



async function loadControls(var_ActiveSYTerm)
{

  //load active syterm
  await ajax_GetActiveTerm()
  .then(function(result)
  {

    var_ActiveSYTerm.setSYTermID(result["syTermID"]);
    var_ActiveSYTerm.setSchoolYear(result["schoolYear"]);
    var_ActiveSYTerm.setTermNumber(result["termNumber"]);


    var currentSYTermText = 
    "The Current Grading Period is SY " + 
    result["schoolYear"] +" term " + result["termNumber"];


    var syTermContainer = document.getElementById("currentSYTermContainer"); 
    syTermContainer.innerHTML = "";
    syTermContainer.appendChild(document.createTextNode(currentSYTermText));    
  });


  //load dropdown
  await ajax_LoadDropDowns(var_ActiveSYTerm.getSYTermID())
  .then(function(result)
  {  
  });

}


async function ajax_GetActiveTerm()
{
  
  return promise = new Promise((resolve, reject) =>
  {
    var request =$.ajax({
      type: 'POST',
      url: 'Backend/a_Uploads.php',
      data: 
      {
        action: "1",
      },

      dataType: 'json',
      cache: false
    });

    request.done(function(result) 
    { 
      resolve(result); 
    });
    
    request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    {
      alert('Error!');   
      console.log("ERROR: " + errorThrown);    
      reject();
    });

  });

}


function ajax_LoadDropDowns(var_ActiveSYTerm)
{

  return promise = new Promise((resolve, reject) =>
  {
    var request =$.ajax({
      type: 'POST',
      url: 'Backend/a_Uploads.php',
      data: 
      {
        action: "2",
        sendSYTerm : var_ActiveSYTerm,
        sendUserType : userType, 
        sendAccountID : accountID
      },

      dataType: 'json',
      cache: false
    });

    request.done(function(result) 
    { 
      var dropDown = document.getElementById("classDropDown");
      for (var i = 0; i < result.length; i++)
      {
        var obj = result[i];      
        var optionEntry = document.createElement("option");
        optionEntry.text = obj['gradeLevelName'] + " - " + obj['sectionName'] + " (" +obj['employeeName'] +")";
        optionEntry.value = obj['classID'];
        dropDown.options.add(optionEntry);
      }
      resolve(); 

    });
    
    request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    {
      console.log("ERROR: " + errorThrown);    
      reject();
    });

  });
}


function getFileType(file)
{
	//file2 = file.files[0];
 	return file.name.split('.').pop();
}


function readFile(file)
{
	switch(type)
	{
		case 'xls':
		alert('xls');
		break;

		case 'xlsx':
		alert('xlsx');
		break;

		case 'csv':
		alert('csv');	
		break;

	}

	return builtArray;
}


async function ajax_UploadCSVTable(var_StudentEntries, var_SelectedValue, var_AccountID)
{
  return promise = new Promise((resolve, reject) =>
  {
    var request = $.ajax({
			type: 'POST',
			url: 'Backend/a_Uploads.php',
			data: 
			{
				action: "3",
        sendCSVArray      : var_StudentEntries,  
        sendSelectedClass : var_SelectedValue,
        sendAccountID     : var_AccountID
			},

			dataType: 'json',
			cache: false
    });

		request.done(function(result)
		{
			//alert(result);	
      resolve();
      location.reload();
		});

		request.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
		{
			console.log('ERROR: ' + errorThrown); 		
      reject();
		});
  });

}





//check if CSV is legitemate
function checkCSV()
{
	alert('TEST3');
}