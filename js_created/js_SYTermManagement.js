

function object_SYTerm()
{
	var syTermID = "";  
	var schoolYear = ""; 
	var termNumber = "";  
	var isActive = "";  


    this.setVariables = function(
      var_SYTermID, var_SchoolYear, 
      var_termNumber, var_IsActive)
    {
		syTermID = var_SYTermID;  
		schoolYear = var_SchoolYear; 
		termNumber = var_termNumber;  
		isActive = var_IsActive; 
    };

    this.getVariables = function()
    {
        var syTermDetails = new Object();

		syTermDetails["syTermID"] = syTermID;  
		syTermDetails["schoolYear"] = schoolYear; 
		syTermDetails["termNumber"] = termNumber;  
		syTermDetails["isActive"] = isActive; 

        return syTermDetails;
    };

    this.purgeVariables = function()
    {
		var syTermID = "";  
		var schoolYear = ""; 
		var termNumber = "";  
		var isActive = "";  
    };
}

$(document).ready(function() 
{

	var obj_SYTermObject = new object_SYTerm();  

	$(".clickable").click(function(e) 
	{
        var parentTR = $(this).closest('tr');
        parentTR.next().toggle(); 
	});



//---------------------------------------------------------------------------
// S E T   S Y T E R M   M O D A L
//---------------------------------------------------------------------------

    $('#button_ChangeActiveSYTermEntry').click(function(e) 
    {
      clicksetActiveSYTermEntryButton();
    });


    $('#button_SetActiveSYTermEntry').click(function(e) 
    {   

      setActiveTerm();
    });


//---------------------------------------------------------------------------
// A D D   M O D A L
//---------------------------------------------------------------------------

	$('#addSYTermEntry').click(function(e) 
	{	
		obj_SYTermObject.purgeVariables();
    clickAddButton();
	});


	$('#submitNewSYTermEntry').click(function(e) 
	{
    addNewEntry();
	});



//---------------------------------------------------------------------------
// E D I T   M O D A L
//---------------------------------------------------------------------------


	$('.editSYTermEntry').click(function(e) 
	{	
    obj_SYTermObject.setVariables(this.value, "","","");
    clickEditButton(obj_SYTermObject, this.value);
	});


	$('#button_UpdateEditedSYTermEntry').click(function(e) 
	{
    updateNewEntry(obj_SYTermObject);
	});



//---------------------------------------------------------------------------
// D E L E T E   M O D A L
//---------------------------------------------------------------------------

	$('.deleteSYTermEntry').click(function(e) 
	{
	 	var schoolYear = this.value; 
	 	obj_SYTermObject.setVariables("",schoolYear,"","");
	});


	$('#removeSelectedSYTermEntry').click(function(e) 
	{
    var schoolYear = obj_SYTermObject.getVariables()["schoolYear"];
    removeEntry(schoolYear);
	});

});


//---------------------------------------------------------------------------
// N O N    A J A X   C A L L S
//---------------------------------------------------------------------------


async function clicksetActiveSYTermEntryButton()
{
  $('#response').empty(); 

  await ajax_RetrieveSYTermList() 
  .then(function(data)
  {

    //empty dropdown
    var dropDown = document.getElementById
      ('dropdown_ChangeActiveSYTerm');
    dropDown.innerHTML = ""; 


    //fill dropdown
    var syTermArray = data[0];
    for (var i = 0; i < syTermArray.length; i++)
    {
        var option = document.createElement('option');
        option.innerHTML = "SY " 
          + syTermArray[i]['schoolYear'] 
          + " Term " + syTermArray[i]['termNumber']; 
        option.value = syTermArray[i]['syTermID'];
        dropDown.appendChild(option);
    } 


    //set dropdown index to active term
    var activeSYTermID = data[1]['syTermID'];
    dropDown.value = activeSYTermID;

  });
}


async function setActiveTerm()
{
  var dropDown = document.getElementById
  ('dropdown_ChangeActiveSYTerm');
  await ajax_SetActiveSYTerm(dropDown.value)
  .then(function(result)
  {location.reload()});
}



function clickAddButton()
{
  $('#response').empty(); 

    var min = new Date().getFullYear(),
    max = new Date().getFullYear() + 9,
    select = document.getElementById('addSchoolYear');
    select.innerHTML = "";


    for (var i = min; i<=max; i++)
    {
      var opt = document.createElement('option');
      opt.value = i;
      opt.innerHTML = i;
      select.appendChild(opt);
    }
}

async function addNewEntry()
{
  var invalidCounter = 0;
  var errorMessage = '';

  var required = ' is required.';
  var schoolYear = $('#addSchoolYear').val();

  if (schoolYear == '' || schoolYear <= 1) 
  {
    invalidCounter++;
    errorMessage += '</br>The School Year' + required;       
  }

  await ajax_CheckSYTermEntryForExistence(schoolYear)
  .then(function(result)
  {
    if (result == 1)
    {
      invalidCounter++;
      errorMessage += '</br>Duplicate School Year.';
    }
  });

  if (invalidCounter != 0) 
  {
    $('form #response').removeClass().addClass('error')
      .html('<strong>Please correct the errors below.</strong>' 
        + errorMessage).fadeIn('fast');  
  }
  else
  { 
    await ajax_AddNewSYTerm(schoolYear)
    .then(function(result)
    {location.reload()});
  }
}



async function clickEditButton(obj_SYTermObject, syTermID)
{
  //get TABLE COORDINATES!
  var row_num = parseInt( $(this).parent().parent().parent().index() )+1;  
  var col_num = parseInt( $(this).parent().parent().index() )+1;  

 
  alert('this is syterm ID => ' + syTermID);

  await ajax_RetrieveSYTermEntry(syTermID)
  .then(function(data)
  {
    obj_SYTermObject.setVariables
    (
        data['syTermID'], data['schoolYear'], 
        data['termNumber'], data['isActive']
    );
  });
}

async function updateNewEntry(obj_SYTermObject)
{
  var isActiveData = 1;
  var syTermIDData = obj_SYTermObject.getVariables()["syTermID"];

  await ajax_UpdateSYTermEntry(isActiveData, syTermIDData)
  .then(function(result)
  {location.reload()});
}



async function removeEntry(schoolYear)
{
  await ajax_RemoveSYTermEntry(schoolYear)
  .then(function(result)
  {location.reload()});
}



//---------------------------------------------------------------------------
// A J A X   C A L L S
//---------------------------------------------------------------------------


// A D D   N E W  E N T R Y
function ajax_AddNewSYTerm(schoolYearData, numberOfTermsData) 
{ 
  return promise = new Promise((resolve, reject) =>
  {  

  	var request = $.ajax({	
  		type: 'POST',
  		url: 'Backend/a_SYTermManagement.php',	
  		url:$(this).attr("action"),		
  		data: 
  		{
  			action: "2",
  			sendSchoolYearData: schoolYearData,
  			sendNumberOfTermsData: numberOfTermsData
  		},
  		dataType: 'text',
  		cache: false
    });

  	request.done(function(data) 
  	{ 
  		alert('Grading Period Added!'); 
      resolve();
  	});

    request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  	{
  		alert('Error in Grading Period Addition!'); 	
      reject(errorThrown);
  	});

  });
};

// R E T R I E V E   E N T R Y   U S I N G   
// A C C O U N T   N U M B E R
function ajax_RetrieveSYTermEntry(syTermID)
{
  return promise = new Promise((resolve, reject) =>
  {  
    var request = $.ajax({	
		type: 'POST',
		url: 'Backend/a_SYTermManagement.php',
		data: 
		{
			action: "3",
			sendSYTermID: syTermID
		},
		dataType: 'json',
		cache: false
    });

    request.done(function(data) 
  	{ 
      resolve(data);
  	});

  	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  	{
  		alert('Error in Retrieving SYTerm Info!'); 	
      reject(errorThrown);	
  	});

  });	
};


// U P D A T E   E N T R Y
function ajax_UpdateSYTermEntry(isActiveData, syTermIDData)
{
  return promise = new Promise((resolve, reject) =>
  {  

    var request = $.ajax({		
		type: 'POST',
		url: 'Backend/a_SYTermManagement.php',
		data: 
		{
			action: "4",
			sendIsActiveData:   isActiveData,
			sendSYTermIDData:   syTermIDData
		},
		dataType: 'text',
		cache: false
    });

  	request.done(function(data) 
  	{ 
  		alert('Updated Grading Period Info!'); 
      resolve();
  	});

  	request.fail(function(data, XMLHttpRequest, 
      textStatus, errorThrown) 
  	{
  		alert('Error in Updating Grading Period Info!'); 		
      reject(errorThrown);
  	});

  });
};


// R E M O V E   E N T R Y
function ajax_RemoveSYTermEntry(schoolYear)
{

  alert(schoolYear);
	return promise = new Promise((resolve, reject) =>
  {  

    var request = $.ajax({		
		type: 'POST',	
		url: 'Backend/a_SYTermManagement.php',
		data: 
		{
			action: "5",
			sendSchoolYear: schoolYear
		},

		dataType: 'text',
		cache: false
    });

  	request.done(function(data) 
  	{ 
  		alert('Successfully deleted the entry!'); 
      resolve();
  	});

  	request.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
  	{
  		alert('Error in Deleting account Entry!'); 		
      reject(errorThrown);
    });

  });
}



function ajax_CheckSYTermEntryForExistence(schoolYear)
{
  return promise = new Promise((resolve, reject) =>
  {   
    var request = $.ajax({ 
        type: 'POST',
        url: 'Backend/a_SYTermManagement.php',
        data: 
        {
            action: "7",
            sendSchoolYear: schoolYear
        },
        dataType: 'json',
        cache: false
    });

    request.done(function(data) 
    { 
      resolve(data);
    });

    request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    {
      alert('Error in Checking for Existence!');  
      reject(errorThrown);    
    });

  });
};





function ajax_RetrieveSYTermList()
{
  return promise = new Promise((resolve, reject) =>
  {   
    var request = $.ajax({ 
    type: 'POST',
    url: 'Backend/a_SYTermManagement.php',
    data: 
    {
        action: "11"
    },
    dataType: 'json',
    cache: false
    });

    request.done(function(data) 
    { 
      resolve(data);
    })

    request.fail(function(data, XMLHttpRequest, 
      textStatus, errorThrown) 
    {
        alert('Error in Checking for the SY Term List!');  
        reject(errorThrown);    
    });
  });
};



function ajax_SetActiveSYTerm(syTermID)
{
  return promise = new Promise((resolve, reject) =>
  {   
    var request = $.ajax({ 
    type: 'POST',
    url: 'Backend/a_SYTermManagement.php',
    data: 
    {
        action: "12",
        sendSYTermID: syTermID

    },
    dataType: 'json',
    cache: false
    });

    request.done(function(data) 
    { 
      alert('Successfully set the Active Term!');  
      resolve(data);
    })

    request.fail(function(data, XMLHttpRequest, 
      textStatus, errorThrown) 
    {
        alert('Error in setting the Active Term!');  
        reject(errorThrown);    
    });
  });  
}

