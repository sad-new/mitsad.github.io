
function testClicker()
{
}


function object_Section()
{
	var sectionID = "";
	var sectionName = "";
	var sectionGradeLevel = "";

    this.setVariables = function(var_SectionID, var_SectionName, var_SectionGradeLevel)
    {
		sectionID = var_SectionID;
		sectionName = var_SectionName;
		sectionGradeLevel = var_SectionGradeLevel;
    };

    this.getVariables = function()
    {
        var sectionDetails = new Object();

        sectionDetails["sectionID"] = sectionID;
        sectionDetails["sectionName"] = sectionName;
        sectionDetails["sectionGradeLevel"] = sectionGradeLevel;  

        return sectionDetails;
    };

    this.purgeVariables = function()
    {
		sectionID = "";
		sectionName = "";
		sectionGradeLevel = "";     
    };	
}

$(document).ready(function() 
{

    var obj_SectionObject = new object_Section();


	if(document.getElementById('dropDown_Main_GradeLevel'))
	{
		loadMainPageControls();
   	}

	$('#dropDown_Main_GradeLevel').change(function(e) 
	{	
      loadMainTable();
	});

//---------------------------------------------------------------------------
// A D D   M O D A L
//---------------------------------------------------------------------------

	$('#button_Main_AddSection').click(function(e) 
	{	

		obj_SectionObject.purgeVariables();
		$('#response').empty(); 
    	document.getElementById('textBox_AddModal_SectionName').value = "";

    	loadModalDropDowns('add'); 
	});

	$('#button_AddModal_AddSection').click(function(e) 
	{
		e.preventDefault();

		var valid = '';
		var required = ' is required.';
		var SectionName = document.getElementById('textBox_AddModal_SectionName').value;

			//error check
			if (SectionName == '' || SectionName <= 1) 
			{
				valid += '</br>The Section Name' + required;				
			}

			if (valid != '') 
			{
			 	$('form #response').removeClass().addClass('error')
			 		.html('<strong>Please correct the errors below.</strong>' +valid).fadeIn('fast');	
			}

			else
		 	{
		 		var nameData = $('#textBox_AddModal_SectionName').val();
		 		var gradeLevelData = $('#dropDown_AddModal_GradeLevel').val();
		 		ajax_AddSection(nameData, gradeLevelData);				
		 	}
	});



//---------------------------------------------------------------------------
// E D I T   M O D A L
//---------------------------------------------------------------------------


    $(document).on( "click", ".button_Main_EditSection", function() 
    {
    	$('#response').empty();
        var sectionID = this.value; 
        obj_SectionObject.setVariables(sectionID,"","");

        fillEditModal(sectionID);    
    });


	//clicking the (./) UPDATE will update the data.
	$('#button_EditModal_UpdateSection').click(function(e) 
	{

		var sectionIDData  = obj_SectionObject.getVariables()["sectionID"];
		var nameData       = $('#textBox_EditModal_SectionName').val();
		var gradeLevelData = $('#dropDown_EditModal_GradeLevel').val();

		//alert(sectionIDData + "   " + nameData); 

		ajax_UpdateSection(sectionIDData, nameData, gradeLevelData);
	});



//---------------------------------------------------------------------------
// D E L E T E   M O D A L
//---------------------------------------------------------------------------


  	$(document).on( "click", ".button_Main_DeleteSection", function() 
 	{
	 	var sectionID = this.value; 
	 	obj_SectionObject.setVariables(sectionID,"","");
	});


	$('#button_DeleteModal_DeleteSection').click(function(e) 
	{
		var sectionID = obj_SectionObject.getVariables()["sectionID"];
		ajax_RemoveSection(sectionID);
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


   document.getElementById("sectionChartName").innerHTML = 
   "List of Registered Sections for " + gradeLevelText; 


   ajax_GetSectionTableEntries(gradeLevel.value) 
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

            var tableHeaderEntries = ['Section ID', 'Section Name', '', ''];

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
                (document.createTextNode(entry['sectionID']));
                tableRow.appendChild(document.createElement('td')).appendChild
                (document.createTextNode(entry['sectionName']));



		        var paragraph1 = document.createElement('p');
		        paragraph1.setAttribute("data-placement","top");
		        paragraph1.setAttribute("data-toggle","tooltip"); 
		        paragraph1.setAttribute("title","Edit");

		        var button_EditSection = document.createElement('button');
		        button_EditSection.setAttribute("class","btn btn-primary btn-xs button_Main_EditSection"); 
		        button_EditSection.setAttribute("data-title","Edit"); 
		        button_EditSection.setAttribute("data-toggle","modal"); 
		        button_EditSection.setAttribute("data-target","#edit");  
		        button_EditSection.setAttribute("name","editSectionButton");
		        button_EditSection.setAttribute("value",entry['sectionID']);

		        var span1 = document.createElement('span');
		        span1.setAttribute("class","glyphicon glyphicon-pencil");



		        var paragraph2= document.createElement('p');
		        paragraph2.setAttribute("data-placement","top");
		        paragraph2.setAttribute("data-toggle","tooltip"); 
		        paragraph2.setAttribute("title","Delete");

		        var button_DeleteSection = document.createElement('button');
		        button_DeleteSection.setAttribute("class","btn btn-danger btn-xs button_Main_DeleteSection"); 
		        button_DeleteSection.setAttribute("data-title","Delete"); 
		        button_DeleteSection.setAttribute("data-toggle","modal"); 
		        button_DeleteSection.setAttribute("data-target","#delete");  
		        button_DeleteSection.setAttribute("name","deleteSectionButton");
		        button_DeleteSection.setAttribute("value",entry['sectionID']);

		        var span2 = document.createElement('span');
		        span2.setAttribute("class","glyphicon glyphicon-trash");



		        tableRow.appendChild(document.createElement('td'))
		            .appendChild(paragraph1)
		            .appendChild(button_EditSection)
		            .appendChild(span1);
		        
		        tableRow.appendChild(document.createElement('td'))
		            .appendChild(paragraph2)
		            .appendChild(button_DeleteSection)
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







async function fillEditModal(sectionID)
{
   await loadModalDropDowns('edit');
   await ajax_RetrieveSection(sectionID)
   .then(function(result)
   {

      $(".form-group #textBox_EditModal_SectionName").val(result['sectionName']);
      
      var dropDown = document.getElementById("dropDown_EditModal_GradeLevel");

      for (var i = 0; i < dropDown.length; i++)
      {
         if (dropDown.options[i].value==result['gradeLevelID_Sections']) 
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
            url: 'Backend/a_SectionManagement.php',   
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





function ajax_GetSectionTableEntries(gradeLevel)
{
    return promise = new Promise((resolve, reject) =>
    { 
	    var request = $.ajax({    
	        type: 'POST',
	        url: 'Backend/a_SectionManagement.php',   
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
	       alert('Error in Section retrieval!');
	       reject('Error in Section retrieval!');        
		});
	});

}






function ajax_AddSection(sectionNameData, sectionGradeLevelData) 
{ 
	$.ajax({	
		type: 'POST',
		url: 'Backend/a_SectionManagement.php',
		//url:#formAddTeacher.attr("action"),		
		url:$(this).attr("action"),		
		data: 
		{
			action: "2",
			sendSectionNameData: sectionNameData,
			sendSectionGradeLevelData: sectionGradeLevelData

		},
		dataType: 'text',
		cache: false,
   })

	.done(function(data) 
	{ 
		alert('Section Created!'); 
	})

	.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in Section Creation!'); 			
	})

	.always(function(XMLHttpRequest, status) 
	{ 			
	 	location.reload();
	});
};



function ajax_RetrieveSection(sectionID)
{

    return promise = new Promise(function(resolve, reject)
    {
	   	var request = $.ajax({	
	   		type: 'POST',
	   		url: 'Backend/a_SectionManagement.php',
	   		data: 
	   		{
	   			action: "3",
	   			sendSectionID: sectionID
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
	   		alert('Error in Retrieving Section Info!'); 	
	        reject();	
	   	});

	});

};



function ajax_UpdateSection(sectionID, sectionNameData, sectionGradeLevelData)
{
	$.ajax({		
		type: 'POST',
		//url:$(this).attr("action"),	
		url: 'Backend/a_SectionManagement.php',
		data: 
		{
			action: "4",
			sendSectionID: sectionID,
			sendSectionNameData: sectionNameData,
			sendSectionGradeLevelData: sectionGradeLevelData
		},

		dataType: 'text',
		cache: false

	})

	.done(function(data) 
	{ 
		alert('Updated Section Info!'); 
	})

	.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in Updating Section Info!'); 		
	})
	
	.always(function(XMLHttpRequest, status) 
	{ 	
	 	location.reload();
	});
};



function ajax_RemoveSection(sectionID)
{

	alert(sectionID);

	$.ajax({		
		type: 'POST',
		url: 'Backend/a_SectionManagement.php',
		data: 
		{
			action: "5",
			sendSectionID: sectionID
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
		alert('Error in Deleting Section!'); 
	})

	.always(function(XMLHttpRequest, status) 
	{ 	
	 	location.reload();
	});		

};




