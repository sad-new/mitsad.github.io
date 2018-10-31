
//SEND ANY BUTTON HERE TO TEST IF THEY WORK.
function testClicker()
{ 
}

function object_Subject()
{
	var subjectID = "";
	var subjectName = "";
	var subjectGradeLevel = "";

    this.setVariables = function(var_SubjectID, var_SubjectName, var_SubjectGradeLevel)
    {
		subjectID = var_SubjectID;
		subjectName = var_SubjectName;
		subjectGradeLevel = var_SubjectGradeLevel;
    };

    this.getVariables = function()
    {
        var subjectDetails = new Object();

        subjectDetails["subjectID"] = subjectID;
        subjectDetails["subjectName"] = subjectName;
        subjectDetails["subjectGradeLevel"] = subjectGradeLevel;  

        return subjectDetails;
    };

    this.purgeVariables = function()
    {
		subjectID = "";
		subjectName = "";
		subjectGradeLevel = "";     
    };	
}


$(document).ready(function() 
{

	var obj_SubjectObject = new object_Subject();

	if(document.getElementById('dropDown_Main_GradeLevel'))
	{
		loadMainPageControls();
   	}

	$('#dropDown_Main_GradeLevel').change(function(e) 
	{	
      loadMainTable();
	});


//---------------------------------------------------------------------------
// A D D
//---------------------------------------------------------------------------

	$('#button_Main_AddSubject').click(function(e) 
	{	
		obj_SubjectObject.purgeVariables();
    	$('#response').empty(); 
    	document.getElementById('textBox_AddModal_SubjectName').value = "";

    	loadModalDropDowns('add'); 
	});


	$('#button_AddModal_AddSubject').click(function(e) 
	{
		e.preventDefault();

		var valid = '';
		var required = ' is required.';
		var SubjectName = document.getElementById('textBox_AddModal_SubjectName').value;


		if (SubjectName == '' || SubjectName <= 1) 
		{
			valid += '</br>The Subject Name' + required;				
		}

		if (valid != '') 
		{
		 	$('form #response').removeClass().addClass('error')
		 		.html('<strong>Please correct the errors below.</strong>' +valid).fadeIn('fast');	
		}


		else
	 	{
	 		var nameData = $('#textBox_AddModal_SubjectName').val();
	 		var gradeLevelData = $('#dropDown_AddModal_GradeLevel').val();
	 		ajax_AddSubject(nameData, gradeLevelData);			
	 	}
	});




//---------------------------------------------------------------------------
// E D I T
//---------------------------------------------------------------------------

    $(document).on( "click", ".button_Main_EditSubject", function() 
    {
    	$('#response').empty();
        var subjectID = this.value; 
        obj_SubjectObject.setVariables(subjectID,"","");

        fillEditModal(subjectID);    
    });

	$('#button_EditModal_UpdateSubject').click(function(e) 
	{

		var subjectIDData  = obj_SubjectObject.getVariables()["subjectID"];
		var nameData       = $('#textBox_EditModal_SubjectName').val();
		var gradeLevelData = $('#dropDown_EditModal_GradeLevel').val();


		ajax_UpdateSubject(subjectIDData, nameData, gradeLevelData);
	});



//---------------------------------------------------------------------------
// D E L
//---------------------------------------------------------------------------


  	$(document).on( "click", ".button_Main_DeleteSubject", function() 
 	{
	 	var subjectID = this.value; 
	 	obj_SubjectObject.setVariables(subjectID,"","");
	});


	$('#button_DeleteModal_DeleteSubject').click(function(e) 
	{
		var subjectID = obj_SubjectObject.getVariables()["subjectID"];
		ajax_RemoveSubject(subjectID);
	});

});




function emptyDropDown(dropDown)
{

    for(i = dropDown.options.length - 1 ; i >= 0 ; i--)
    {
        dropDown.remove(i);
    }
}

async function loadMainPageControls()
{
   await loadModalDropDowns('main');
   await loadMainTable();
}


async function loadMainTable()
{

   var tableContainer = document.getElementById("mainTableContainer");

   var gradeLevel = document.getElementById('dropDown_Main_GradeLevel');
	var gradeLevelText = gradeLevel.options[gradeLevel.selectedIndex].text;


   document.getElementById("subjectChartName").innerHTML = 
   "List of Registered Subjects for " + gradeLevelText; 


   ajax_GetSubjectTableEntries(gradeLevel.value) 
   .then(function(result)
   {

        tableContainer.innerHTML = "";

        if (result != false)
        {
            var table = document.createElement('table');
            table.id = "mainTable";
            table.className = "table"; 
            table.className += " table-bordred";
            table.className += " table-striped";

            var tableHead = document.createElement('thead');
            var tableHeadRow = document.createElement('tr');

            var tableBody = document.createElement('tbody');

            tableContainer.appendChild(table);

            var tableHeaderEntries = ['Subject ID', 'Subject Name', '', ''];

            tableHeaderEntries.forEach(function(entry)
            {
                tableHeadRow.appendChild(document.createElement('th'))
                .appendChild(document.createTextNode(entry));
            });

            table.appendChild(tableHead);
            tableHead.appendChild(tableHeadRow);
            table.appendChild(tableBody);

            //for (var i = 0; i < result.length; i++)
            result.forEach(function(entry)
            {
            	var tableRow = document.createElement('tr'); 

                tableRow.appendChild(document.createElement('td')).appendChild
                (document.createTextNode(entry['subjectID']));
                tableRow.appendChild(document.createElement('td')).appendChild
                (document.createTextNode(entry['subjectName']));



		        var paragraph1 = document.createElement('p');
		        paragraph1.setAttribute("data-placement","top");
		        paragraph1.setAttribute("data-toggle","tooltip"); 
		        paragraph1.setAttribute("title","Edit");

		        var button_EditSubject = document.createElement('button');
		        button_EditSubject.setAttribute("class","btn btn-primary btn-xs button_Main_EditSubject"); 
		        button_EditSubject.setAttribute("data-title","Edit"); 
		        button_EditSubject.setAttribute("data-toggle","modal"); 
		        button_EditSubject.setAttribute("data-target","#edit");  
		        button_EditSubject.setAttribute("name","editSubjectButton");
		        button_EditSubject.setAttribute("value",entry['subjectID']);

		        var span1 = document.createElement('span');
		        span1.setAttribute("class","glyphicon glyphicon-pencil");



		        var paragraph2= document.createElement('p');
		        paragraph2.setAttribute("data-placement","top");
		        paragraph2.setAttribute("data-toggle","tooltip"); 
		        paragraph2.setAttribute("title","Delete");

		        var button_DeleteSubject = document.createElement('button');
		        button_DeleteSubject.setAttribute("class","btn btn-danger btn-xs button_Main_DeleteSubject"); 
		        button_DeleteSubject.setAttribute("data-title","Delete"); 
		        button_DeleteSubject.setAttribute("data-toggle","modal"); 
		        button_DeleteSubject.setAttribute("data-target","#delete");  
		        button_DeleteSubject.setAttribute("name","deleteSubjectButton");
		        button_DeleteSubject.setAttribute("value",entry['subjectID']);

		        var span2 = document.createElement('span');
		        span2.setAttribute("class","glyphicon glyphicon-trash");



		        tableRow.appendChild(document.createElement('td'))
		            .appendChild(paragraph1)
		            .appendChild(button_EditSubject)
		            .appendChild(span1);
		        
		        tableRow.appendChild(document.createElement('td'))
		            .appendChild(paragraph2)
		            .appendChild(button_DeleteSubject)
		            .appendChild(span2);


                tableBody.appendChild(tableRow);
            });

        }
        else
        {

        	//tableContainer.appendChild(table);
        }
    });

}


async function loadModalDropDowns(action)
{
    if (action == 'add')
    {
        var dropDown = document.getElementById("dropDown_AddModal_GradeLevel");
    }
    else if (action == 'edit')
    {
        var dropDown = document.getElementById("dropDown_EditModal_GradeLevel");
    }
    else if (action == 'main')
    {
        var dropDown = document.getElementById("dropDown_Main_GradeLevel");
    }

    emptyDropDown(dropDown);

    await ajax_GetGradeLevels(action)
    .then(function(result)
    {

        result.forEach(function(entry)
        {
            var optionEntry = document.createElement("option");
            optionEntry.text = entry['gradeLevelName'];
            optionEntry.value = entry['gradeLevelID'];


            if (action == 'main')
            {
            	optionEntry.text +=  " (" +  entry['children'] + " children)";
            };


            dropDown.options.add(optionEntry);
        });


    });
}



async function fillEditModal(subjectID)
{
   await loadModalDropDowns('edit');
   await ajax_RetrieveSubject(subjectID)
   .then(function(result)
   {

      $(".form-group #textBox_EditModal_SubjectName").val(result['subjectName']);
      
      var dropDown = document.getElementById("dropDown_EditModal_GradeLevel");

      for (var i = 0; i < dropDown.length; i++)
      {
         if (dropDown.options[i].value==result['gradeLevelID_Subjects']) 
         {
            dropDown.options[i].selected = "Selected";
         }
      }

   });
}




//---------------------------------------------------------------------------
// A J A X   C A L L S
//---------------------------------------------------------------------------



function ajax_GetGradeLevels(action)
{
    return promise = new Promise((resolve, reject) =>
    {

        $.ajax({    
            type: 'POST',
            url: 'Backend/a_SubjectManagement.php',   
            data: 
            {
                action: "11"
            },
            dataType: 'json',
            cache: false
        })

        .done(function(data) 
        { 
            resolve(data);
        })

        .fail(function(XMLHttpRequest, textStatus, errorThrown) 
        {
            alert('Error in School Year retrieval!');
            reject('Error in School Year retrieval!');        
        });

    });
}


function ajax_GetSubjectTableEntries(gradeLevel)
{
    return promise = new Promise((resolve, reject) =>
    { 
	    var request = $.ajax({    
	        type: 'POST',
	        url: 'Backend/a_SubjectManagement.php',   
	        data: 
	        {
	            action: "12",
	            sendGradeLevel: gradeLevel
	        },
	        dataType: 'json',
	        cache: false
	    })

	    request.done(function(data) 
	    { 
	        resolve(data);
	    })

	    request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	    {
	       alert('Error in Subject List retrieval!');
	       reject('Error in Subject List retrieval!');        
		});
	});

}

function ajax_AddSubject(subjectNameData, subjectGradeLevelData) 
{ 
	$.ajax({	
		type: 'POST',
		url: 'Backend/a_SubjectManagement.php',
		//url:#formAddTeacher.attr("action"),		
		url:$(this).attr("action"),		
		data: 
		{
			action: "2",
			sendSubjectNameData: subjectNameData,
			sendSubjectGradeLevelData: subjectGradeLevelData

		},
		dataType: 'text',
		cache: false,
   })

	.done(function(data) 
	{ 
		alert('Subject Created!'); 
	})

	.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in Subject Creation!'); 			
	})

	.always(function(XMLHttpRequest, status) 
	{ 			
	 	location.reload();
	});
};



function ajax_RetrieveSubject(subjectID)
{

    return promise = new Promise(function(resolve, reject)
    {
	   	var request = $.ajax({	
	   		type: 'POST',
	   		url: 'Backend/a_SubjectManagement.php',
	   		data: 
	   		{
	   			action: "3",
	   			sendSubjectID: subjectID
	   		},
	   		dataType: 'json',
	   		cache: false
	      })

	   	request.done(function(data) 
	   	{ 
	         resolve(data);
	   	})

	   	request.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
	   	{
	   		alert('Error in Retrieving Subject Info!'); 	
	        reject();	
	   	});

	});

};


function ajax_UpdateSubject(subjectID, subjectNameData, subjectGradeLevelData)
{
	$.ajax({		
		type: 'POST',
		//url:$(this).attr("action"),	
		url: 'Backend/a_SubjectManagement.php',
		data: 
		{
			action: "4",
			sendSubjectID: subjectID,
			sendSubjectNameData: subjectNameData,
			sendSubjectGradeLevelData: subjectGradeLevelData
		},

		dataType: 'text',
		cache: false

	})

	.done(function(data) 
	{ 
		alert('Updated Subject Info!'); 
	})

	.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in Updating Subject Info!'); 		
	})
	
	.always(function(XMLHttpRequest, status) 
	{ 	
	 	location.reload();
	});
};


function ajax_RemoveSubject(subjectID)
{
	$.ajax({		
		type: 'POST',
		url: 'Backend/a_SubjectManagement.php',
		data: 
		{
			action: "5",
			sendSubjectID: subjectID
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
		alert('Error in Deleting Subject!'); 
	})

	.always(function(XMLHttpRequest, status) 
	{ 	
	 	location.reload();
	});		

};

