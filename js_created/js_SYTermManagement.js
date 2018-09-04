

function object_SYTerm()
{
	var syTermID = "";  
	var schoolYear = ""; 
	var termNumber = "";  
	var isActive = "";  


    this.setVariables = function(var_SYTermID, var_SchoolYear, var_termNumber, var_IsActive)
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
        $('#response').empty(); 

        var promise = ajax_RetrieveSYTermList(); 
        promise.success(function(data)
        {
            var dropDown = document.getElementById('dropdown_ChangeActiveSYTerm');
            dropDown.innerHTML = ""; 

            for (var i = 0; i < data.length; i++)
            {
                var option = document.createElement('option');
                option.innerHTML = "SY " + data[i]['schoolYear'] + " Term " + data[i]['termNumber']; 
                option.value = data[i]['syTermID'];
                dropDown.appendChild(option);
            } 
        });
    });


    $('#button_SetActiveSYTermEntry').click(function(e) 
    {   
        var dropDown = document.getElementById('dropdown_ChangeActiveSYTerm');
        var promise = ajax_SetActiveSYTerm(dropDown.value);
        promise.success(function(data)
        {
        });
    });

//---------------------------------------------------------------------------
// A D D   M O D A L
//---------------------------------------------------------------------------



	$('#addSYTermEntry').click(function(e) 
	{	
		obj_SYTermObject.purgeVariables();
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
	});


	$('#submitNewSYTermEntry').click(function(e) 
	{
		e.preventDefault();

		 var valid = '';
		 var required = ' is required.';
		 var schoolYear = $('#addSchoolYear').val();

		if (schoolYear == '' || schoolYear <= 1) 
		{
			valid += '</br>The School Year' + required;				
		}

		if (valid != '') 
		{
		 	$('form #response').removeClass().addClass('error')
		 		.html('<strong>Please correct the errors below.</strong>' +valid).fadeIn('fast');	
		}

		else
	 	{
            var promise = ajax_CheckSYTermEntryForExistence(schoolYear);
            promise.success(function(data)
            {
                if (data==false)
                {
                    ajax_AddNewSYTerm(schoolYear);   
                }
                else
                {
                    alert('Duplicate school year!');
                }
            });		
	 	}
	});



//---------------------------------------------------------------------------
// E D I T   M O D A L
//---------------------------------------------------------------------------


	$('.editSYTermEntry').click(function(e) 
	{	
		//get TABLE COORDINATES!
		var row_num = parseInt( $(this).parent().parent().parent().index() )+1;  
		var col_num = parseInt( $(this).parent().parent().index() )+1;  

		//GET SECTION ID OF SELECTED ENTRY
	 	var syTermID = this.value; 
	 	obj_SYTermObject.setVariables(syTermID, "","","");
 

	 	var promise = ajax_RetrieveSYTermEntry(syTermID);
        promise.success(function(data)
        {
            obj_SYTermObject.setVariables
            (
                data['syTermID'], data['schoolYear'], 
                data['termNumber'], data['isActive']
            );

            //set DropDown2 to correct Value
            var dropDown2 = document.getElementById("dropDown_editIsActive");

            for (var i = 0; i < dropDown2.length; i++)
            {
                if (dropDown2.options[i].value==data['isActive']) 
                {
                    dropDown2.options[i].selected = "Selected";
                }
            }

        });
	});


	$('#button_UpdateEditedSYTermEntry').click(function(e) 
	{
		var isActiveData   = 1;
		var syTermIDData     = obj_SYTermObject.getVariables()["syTermID"];

		ajax_UpdateSYTermEntry(isActiveData, syTermIDData);
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
		ajax_RemoveSYTermEntry(schoolYear);
	});

});





//---------------------------------------------------------------------------
// A J A X   C A L L S
//---------------------------------------------------------------------------


// A D D   N E W  E N T R Y
function ajax_AddNewSYTerm(schoolYearData, numberOfTermsData) 
{ 
	$.ajax({	
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
    }) 
	.done(function(data) 
	{ 
		alert('Grading Period Added!'); 
	})

    .fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in Grading Period Addition!'); 			
	})

	.always(function(XMLHttpRequest, status) 
	{ 			
	 	location.reload();
	});
};

// R E T R I E V E   E N T R Y   U S I N G   
// A C C O U N T   N U M B E R
function ajax_RetrieveSYTermEntry(syTermID)
{

	return $.ajax({	
		type: 'POST',
		url: 'Backend/a_SYTermManagement.php',
		data: 
		{
			action: "3",
			sendSYTermID: syTermID
		},
		dataType: 'json',
		cache: false
    })

    .done(function(data) 
	{ 
	})

	.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in Retrieving SYTerm Info!'); 		
	});	
};


// U P D A T E   E N T R Y
function ajax_UpdateSYTermEntry(isActiveData, syTermIDData)
{

	$.ajax({		
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
    })

	.done(function(data) 
	{ 
		alert('Updated Grading Period Info!'); 
	})

	.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in Updating Grading Period Info!'); 		
	})
	
	.always(function(XMLHttpRequest, status) 
	{ 	
	 	location.reload();
	});

};


// R E M O V E   E N T R Y
function ajax_RemoveSYTermEntry(schoolYear)
{
	$.ajax({		
		type: 'POST',	
		url: 'Backend/a_SYTermManagement.php',
		data: 
		{
			action: "5",
			sendSchoolYear: schoolYear
		},

		dataType: 'text',
		cache: false
    })

	.done(function(data) 
	{ 
		alert('Successfully deleted the entry!'); 
	})

	.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in Deleting account Entry!'); 		
    })

	.always(function(XMLHttpRequest, status) 
	{ 	
	 	location.reload();
	});
			
};

function ajax_CheckSYTermEntryForExistence(schoolYear)
{

    return $.ajax({ 
        type: 'POST',
        url: 'Backend/a_SYTermManagement.php',
        data: 
        {
            action: "7",
            sendSchoolYear: schoolYear
        },
        dataType: 'json',
        cache: false
    })

    .done(function(data) 
    { 
    })

    .fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
    {
        alert('Error in Checking for Existence!');      
    });
};


function ajax_RetrieveSYTermList()
{
    return $.ajax({ 
    type: 'POST',
    url: 'Backend/a_SYTermManagement.php',
    data: 
    {
        action: "11"
    },
    dataType: 'json',
    cache: false
    })

    .done(function(data) 
    { 
    })

    .fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
    {
        alert('Error in Checking for the SY Term List!');      
    });
};


function ajax_SetActiveSYTerm(syTermID)
{
    return $.ajax({ 
        type: 'POST',
        url: 'Backend/a_SYTermManagement.php',
        data: 
        {
            action: "12",
            sendSYTermID: syTermID
        },
        dataType: 'json',
        cache: false
    })

    .done(function(data) 
    { 
        alert('Changed Active Term!'); 
        location.reload();
    })

    .fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
    {
        alert('Error in Setting the Active SY Term!');      
    }); 
}