
function object_ClassDetails()
{
  var classID = ""; 
  var GradeLevelName = "";
  var sectionName = "";
  var schoolYear = "";


  this.getClassID = function()
  {
    return classID;
  };

  this.getGradeLevelName = function()
  {
    return gradeLevelName;
  }

  this.getSectionName = function()
  {
    return sectionName;
  }

  this.getschoolYear = function()
  {
    return schoolYear;
  }



  this.setClassID = function(var_ClassID)
  {
    classID = var_ClassID;
  };

  this.setGradeLevelName = function(var_GradeLevelName)
  {
    gradeLevelName = var_GradeLevelName;
  };

  this.setSectionName = function(var_SectionName)
  {
    sectionName = var_SectionName;
  };

  this.setSchoolYear = function(var_SchoolYear)
  {
    schoolYear = var_SchoolYear;
  }


}




$(document).ready(function() 
{
  var object_ClassDetailsObject = new object_ClassDetails();

  //classID from storage
  var selected = localStorage.getItem('classID');
  if (selected == null)
  {
    window.location = "ClassManagement.php";
  }

  else
  {
    object_ClassDetailsObject.setClassID(selected);
    loadMainPageDetails(object_ClassDetailsObject);
  }


  //you store classLists here.
	var studentEntries = [];

	//capture CSV
	document.getElementById('fileCSV').onchange = function()
	{
  		//get filetype
  		var file = this.files[0];
      uploadFile(file, studentEntries);
	};

	//Place CSV to DB
	$(document).on("click", '#submitCSV', function()
	{
		var dropDown = document.getElementById("classDropDown");
    ajax_UploadCSVTable(studentEntries, object_ClassDetailsObject.getClassID());
	});

});



//---------------------------------------------------------------------------
// A J A X
//--------------------------------------------------------------------------- 




async function loadMainPageDetails(details)
{
  await ajax_LoadClassDetails(details)
  .then(function(result)
  {

    details.setSectionName(result['sectionName']);
    details.setGradeLevelName(result['gradeLevelName']);
    details.setSchoolYear(result['schoolYear']);


    currentClass = document.getElementById('currentClassLabel');
    currentClass.innerHTML = 
    "Current Class List for <b>" + details.getGradeLevelName() + 
    "</b> - <b>" + details.getSectionName() + 
    "</b> in <b>SY " + details.getschoolYear() + "</b> (" + result['studentCount'] + " children)";
  })


  await ajax_LoadCurrentClassList(details)
  .then(function(result)
  {
    if (result.length > 0)
    {
      buildTable(result, '1');
    }
    else
    {
    }
  })
}


//lazy class. bad practice, but it works.
async function uploadFile(file, studentEntries)
{
  await extractExcelEntries(file, studentEntries);
  if (studentEntries.length > 0)
  {
    await buildTable(studentEntries, '2');
    document.getElementById('submitCSV').style.visibility = "visible";
    document.getElementById('submitCSV').disabled = false;

    document.getElementById('classToBeUploadedLabel').innerHTML = "Entries to be Uploaded (" + studentEntries.length + " children)";
  }
  else
  {
    document.getElementById("classFromExcelContainer").innerHTML = "";
    document.getElementById('submitCSV').disabled = true;
    document.getElementById('submitCSV').style.visibility = "hidden";
    
    document.getElementById('classToBeUploadedLabel').innerHTML = "";
  }
}




async function extractExcelEntries(file, studentEntries)
{
    return readerPromise = new Promise((resolve, reject) =>
    {
      var reader = new FileReader();
      reader.onload = function(e)
      {
        //erase array entries
        while(studentEntries.length > 0) 
        {
          studentEntries.pop();
        }

        var workbook = XLSX.read(this.result, 
        {
          type: 'binary'
        });

        //READ AND PARSE THE FIRST SHEET
        var sheet1 = workbook.Sheets[workbook.SheetNames[0]];
        var XL_Worksheet = XLSX.utils.sheet_to_row_object_array(sheet1);


        //GET KEY NAMES, PLACE ON FIRST ROW
        keyNames = [];
        rowNames = [];
        for (var key in (XL_Worksheet[0]))
        {
            rowNames.push(key);
        }


        //CHECK ROW B FOR EXISTENCE OF ENTRY (B10-B58)
        workbook.Sheets[workbook.SheetNames[0]]['!ref'] =  "B10:B58";
        var excelEntries = (XLSX.utils.sheet_to_row_object_array(sheet1, {header:1}));
        for (var i = 0 ; i < excelEntries.length ; i++)
        {
            //iterate through all name entries, ignore all NULL COL B Entries
            if (excelEntries[i] != "")
            {
              var studentEntriesRow = []; 

              studentEntriesRow.push(excelEntries[i][0]);  // COL B

              workbook.Sheets[workbook.SheetNames[0]]['!ref'] =  "C"+ (10+i) + ":G" +  (10+i);
              var gradeEntries = (XLSX.utils.sheet_to_row_object_array(sheet1, {header:1}));

              studentEntriesRow.push(gradeEntries[0][0]); // COL C
              studentEntriesRow.push(gradeEntries[0][4]); // COL G

              studentEntries.push(studentEntriesRow);
            }
        }

        resolve(studentEntries);
      };
      reader.readAsBinaryString(file);
    });
}



async function buildTable(studentEntries, tableChoice)
{
    // programmatically create table. this is some terrible code.


    var table  = document.createElement('table');
    table.id = "table";
    table.className = "table"; 
    table.className += " table-bordred";
    table.className += " table-striped";


    // HEAD
    var tableHead = document.createElement('thead');
    var tableHeadRow = document.createElement('tr');
    table.appendChild(tableHead);
    tableHead.appendChild(tableHeadRow);

    var tableHeaders = ["Student Number", "Student Name", "Gender"];
    tableHeaders.forEach(function(entry)
    {
        tableHeadRow.appendChild(document.createElement('th'))
        .appendChild(document.createTextNode(entry));
    });

    // BODY
    var tableBody = document.createElement('tbody');
    table.appendChild(tableBody);

    for (var i = 0 ; i < studentEntries.length ; i++)
    {
      var tableBodyRow = document.createElement('tr');
      for  (var j = 0 ; j < studentEntries[i].length ; j++)
      {
        tableBodyRow.appendChild(document.createElement('td')).appendChild
        (document.createTextNode(studentEntries[i][j]));
      }
      tableBody.appendChild(tableBodyRow);
    }

    tableContainer = "";  

    switch(tableChoice)
    {
      case '1' : tableContainer = 'currentClassContainer'; break;  
      case '2' : tableContainer = "classFromExcelContainer"; break;
    }

    document.getElementById(tableContainer).innerHTML = "";
    document.getElementById(tableContainer).appendChild(table);
}









function ajax_LoadClassDetails(classDetails)
{

  return promise = new Promise((resolve, reject) =>
  {
    var request =$.ajax({
      type: 'POST',
      url: 'Backend/a_ClassListManagement.php',
      data: 
      {
        action: "1",  
        sent_ClassID : classDetails.getClassID()

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
      console.log("Error in Retrieving Class Details. " + errorThrown);    
      reject();
    });
  });
}


function ajax_LoadCurrentClassList(classDetails)
{


  return promise = new Promise((resolve, reject) =>
  {
    var request =$.ajax({
      type: 'POST',
      url: 'Backend/a_ClassListManagement.php',
      data: 
      {
        action: "3",  
         sent_ClassID : classDetails.getClassID()

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
      console.log("Error in Retrieving Current Class list. " + errorThrown);    
      reject();
    });
  });
}



async function ajax_UploadCSVTable(var_StudentEntries, var_ClassID)
{

  return promise = new Promise((resolve, reject) =>
  {
    var request = $.ajax({
			type: 'POST',
			url: 'Backend/a_ClassListManagement.php',
			data: 
			{
				action: "4",
        send_CSVArray    : var_StudentEntries,  
        send_ClassID     : var_ClassID
			},

			dataType: 'text',
			cache: false
    });

		request.done(function(result)
		{
      alert("Successfully Uploaded!");
      location.reload();
      resolve();
		});

		request.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
		{
			console.log('Error in uploading Class List. ' + errorThrown); 		
      reject();
		});
  });

}



