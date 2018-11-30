

// E T O   Y U N G   M A Y   P R O M I S E   A T   M A Y   A S Y N C   F X N

function object_Class()
{
    var classID = "";
    var schoolYear = "";
    var section = "";




    this.setClassID = function(var_ClassID)
    {
      classID = var_ClassID;
    }

    this.setSchoolYear = function(var_SchoolYear)
    {
      schoolYear = var_SchoolYear;
    }

    this.setSection = function(var_Section)
    {
      section = var_Section;
    }



    this.getClassID = function()
    {
      return classID;
    };

    this.getSchoolYear = function()
    {
      return schoolYear;
    };

    this.getSection = function()
    {
      return section;
    };


    this.purgeVariables = function()
    {
 	    classID = "";
  		schoolYear = "";
    	section = "";
    };
}

$(document).ready(function() 
{
    var obj_ClassObject = new object_Class();         

    loadMainPageControls();

    $(".clickable").click(function(e) 
    {
        var parentTR = $(this).closest('tr');
        parentTR.next().toggle(); 
    });

    $("#mainTableContainer").on( "click", "td.clickable", function() {
        var parentTR = $(this).closest('tr');
        parentTR.next().toggle(); 
    });


//---------------------------------------------------------------------------
// M A I N   D R O P D O W N S
//---------------------------------------------------------------------------	

	$('#dropDown_Main_SYTerm').change(function(e) 
	{	
      load_MainGradeLevelsandMainTable();
	});

	$('#dropDown_Main_GradeLevel').change(function(e) 
	{	
        loadMainTable();
	});

//---------------------------------------------------------------------------
// A D D   C L A S S   M O D A L
//---------------------------------------------------------------------------	

   $(document).on( "click", "#button_Main_AddClass", function()   
   {
      $('#response').empty(); 
      obj_ClassObject.purgeVariables();
      loadDropDowns('add', function(result){});
   });

	$('#button_AddModal_AddClass').click(function(e) 
	{
    $('#response').empty(); 
		addClass();
	});



	$('#dropDown_AddModal_SchoolYear').change(function(e) 
	{	
	});

   $('#dropDown_AddModal_GradeLevel').change(function(e) 
   {  
      ajax_GetSection('add');
   });

	$('#dropDown_AddModal_Section').change(function(e) 
	{	
	});


//---------------------------------------------------------------------------
// E D I T   C L A S S   M O D A L
//---------------------------------------------------------------------------	

  $(document).on( "click", ".button_Main_EditClass", function() 
	{	
      $('#response').empty(); 
   
      var classID = this.value;
      obj_ClassObject.purgeVariables();
      obj_ClassObject.setClassID(classID); 

      retrieveClass(obj_ClassObject);
	});


	$(document).on( "click", "#button_EditModal_UpdateClass", function() 
	{
    $('#response').empty(); 
    updateClass(obj_ClassObject);
	});



	$('#dropDown_EditModal_SchoolYear').change(function(e) 
	{	
	});

   $('#dropDown_EditModal_GradeLevel').change(function(e) 
   {  
      ajax_GetSection('edit');
   });

	$('#dropDown_EditModal_Section').change(function(e) 
	{	
	});


//---------------------------------------------------------------------------
// D E L E T E   C L A S S   M O D A L
//---------------------------------------------------------------------------	


  $(document).on( "click", ".button_Main_DeleteClass", function() 
  {
    var classID = this.value;
    obj_ClassObject.purgeVariables();
    obj_ClassObject.setClassID(classID); 

  	alert(obj_ClassObject.getClassID());

	});

	$('#button_DeleteModal_DeleteClass').click(function(e) 
	{
		var var_ClassID = obj_ClassObject.getClassID();
		ajax_DeleteClass(var_ClassID);
	});


//---------------------------------------------------------------------------
// O T H E R   B U T T O N S
//--------------------------------------------------------------------------- 

    $(document).on( "click", ".button_Main_ClassStudent", function() 
  {
    localStorage.setItem('classID', this.value);
    window.location = "ClassListManagement.php";
  });

  $(document).on( "click", ".button_Main_ClassSubject", function() 
  {
    localStorage.setItem('classID', this.value);
    window.location = "ClassSubjectManagement.php";
  });

});


//---------------------------------------------------------------------------
// D R O P D O W N   C O N T R O L S
//---------------------------------------------------------------------------	


async function load_MainGradeLevelsandMainTable()
{
   await ajax_LoadMainGradeLevel();
   await loadMainTable();  
}


async function loadMainPageControls(phase)
{

   //check if certain controls exist, to prevent the page from screwing up
   if (!document.getElementById('dropDown_Main_SYTerm'))
   {
   }

   else
   {
     await ajax_LoadMainSYTerm();
     await ajax_LoadMainGradeLevel();
     await loadMainTable();
   }

}


async function loadDropDowns(action)
{
   await ajax_GetSchoolYear(action);
   await ajax_GetGradeLevel(action); 
   await ajax_GetSection(action);
}


function emptyDropDown(dropDown)
{
	for(i = dropDown.options.length - 1 ; i >= 0 ; i--)
    {
        dropDown.remove(i);
    }
}

function initializeSelectedValue(dropDown)
{
	dropDown.options[0].selected = "Selected";    
}



async function loadMainTable()
{
    var tableContainer = document.getElementById("mainTableContainer");

    var syTermID = document.getElementById('dropDown_Main_SYTerm');
    var gradeLevel = document.getElementById('dropDown_Main_GradeLevel');

    var syTermIDText = syTermID.options[syTermID.selectedIndex].text_Alter;

    var gradeLevelText = gradeLevel.options[gradeLevel.selectedIndex].text;


    document.getElementById("classChartName").innerHTML = 
    "List of Registered Classes for <b>SY " + syTermIDText + "</b> in <b>" + gradeLevelText + "</b>"; 
    var classArray = ajax_GetClassTableEntries(syTermID.value, gradeLevel.value) 
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


            tableContainer.appendChild(table);
            
            table.appendChild(tableHead);
            tableHead.appendChild(tableHeadRow);

            tableHeadRow.appendChild(document.createElement('th'))
              .appendChild(document.createTextNode('Class ID'));
            tableHeadRow.appendChild(document.createElement('th'))
              .appendChild(document.createTextNode('Section'));
            tableHeadRow.appendChild(document.createElement('th'))
              .appendChild(document.createTextNode('Student Count'));

            tableHeadRow.appendChild(document.createElement('th'))
              .appendChild(document.createTextNode('Subject List'));


            var tableBody = document.createElement('tbody');
            
            table.appendChild(tableBody);

            for (var i = 0; i < result.length; i++)
            {
                var classSection = result[i];


                // name

                var text_rowTtitle = 
                  "Section " + classSection['sectionName'] ;


                var tableBodyClassID = document.createTextNode(classSection['classID']);
                var tableBodyCellSectionName = document.createTextNode(text_rowTtitle);
                var tableBodyCell2 = document.createTextNode(classSection['studentCount']);


                // Subject List / Class Subjects

                var paragraph = document.createElement('p');
                paragraph.setAttribute("data-placement","top");
                paragraph.setAttribute("data-toggle","tooltip"); 
                paragraph.setAttribute("title","Class Subject");

                var button_ClassSubject = document.createElement('button');
                button_ClassSubject.setAttribute("class","btn btn-primary btn-xs button_Main_ClassSubject"); 
                button_ClassSubject.setAttribute("data-title","Class Subject"); 
                button_ClassSubject.setAttribute("name","ClassSubjectButton");
                button_ClassSubject.setAttribute("value",  classSection['classID']   );

                var buttonTextNode = document.createTextNode("See Subject List");

 



                var tableBodyRow = document.createElement('tr');
                tableBody.appendChild(tableBodyRow);

                tableBodyRow.appendChild(document.createElement('td'))
                  .appendChild(tableBodyClassID);

                tableBodyRow.appendChild(document.createElement('td'))
                  .appendChild(tableBodyCellSectionName);

                tableBodyRow.appendChild(document.createElement('td'))
                  .appendChild(tableBodyCell2);


                  tableBodyRow.appendChild(document.createElement('td'))
                    .appendChild(paragraph)
                    .appendChild(button_ClassSubject)
                    .appendChild(buttonTextNode);

            }
        }
        else 
        {
        }
    });
}



async function addClass()
{

  var invalidCounter = 0;
  var errorMsg = "";
  var required = ' is required.';

  var schoolYear = $('#dropDown_AddModal_SchoolYear').val();
  var gradeLevelID = $('#dropDown_AddModal_GradeLevel').val();
  var section = $('#dropDown_AddModal_Section').val();

  if (schoolYear == null)
  {
        invalidCounter++;
        errorMsg += '</br>A SchoolYear is required.';
  }

  if (gradeLevelID == null)
  {
        invalidCounter++;
        errorMsg += '</br>A Grade Level is required.';
  }

  if (section == null)
  {
        invalidCounter++;
        errorMsg += '</br>A Section is required.';
  }

  await ajax_CheckNewEntryForExistence(schoolYear, section)
  .then(function(result)
  {
      if (result == 1)
      {
        invalidCounter++;
        errorMsg += '</br>Class already exists.';
      }
  });


  if (invalidCounter > 0) 
  {
    $('form #response').removeClass().addClass('error')
      .html('<strong>Please correct the errors below.</strong>' +errorMsg).fadeIn('fast');  
  }
  else
  {
    //ajax_AddClass(schoolYear, gradeLevelID, section);     
  }

}


async function retrieveClass(obj_ClassObject)
{

   await loadDropDowns('edit');


   await ajax_RetrieveClass(obj_ClassObject.getClassID())
   .then(function(result)
   {


      obj_ClassObject.setSchoolYear(result['syTermID_Start_Classes']);
      obj_ClassObject.setSection(result['sectionID_Classes']);


      var dropDown = document.getElementById("dropDown_EditModal_SchoolYear");
      var dropDown2 = document.getElementById("dropDown_EditModal_GradeLevel");
      var dropDown3 = document.getElementById("dropDown_EditModal_Section");


      for (var i = 0; i < dropDown.length; i++)
      {
         if (dropDown.options[i].value==result['syTermID_Start_Classes']) 
         {
            dropDown.options[i].selected = true;
            break;  
            }
      }

      for (var i = 0; i < dropDown2.length; i++)
      {
         if (dropDown2.options[i].value==result['gradeLevelID_Classes']) 
         {
            dropDown2.options[i].selected = true;
            break;  
         }
      }

      ajax_GetSection('edit')
      .then(function()
      {

         for (var i = 0; i < dropDown3.length; i++)
         {
            if (dropDown3.options[i].value==result['sectionID_Classes']) 
            {
               dropDown3.options[i].selected = true;
               break;  
            }
         }     
      });  

   });
}


async function updateClass(obj_ClassObject)
{

    var invalidCounter = 0;
    var errorMsg = "";
    var required = ' is required.';

    var var_ClassID = obj_ClassObject.getClassID();
    var var_SchoolYear = document.getElementById("dropDown_EditModal_SchoolYear").value;
    var var_GradeLevelID = document.getElementById("dropDown_EditModal_GradeLevel").value;
    var var_Section = document.getElementById("dropDown_EditModal_Section").value;


    if (var_SchoolYear == null)
    {
          invalidCounter++;
          errorMsg += '</br>A SchoolYear is required.';
    }

    if (var_GradeLevelID == null)
    {
          invalidCounter++;
          errorMsg += '</br>A Grade Level is required.';
    }

    if (var_Section == null)
    {
          invalidCounter++;
          errorMsg += '</br>A Section is required.';
    }

    await ajax_CheckExistingEntry(var_ClassID, var_SchoolYear, var_Section)
    .then(function(result)
    {
        if (result == 1)
        {
          invalidCounter++;
          errorMsg += '</br>Class already exists.';
        }
    });


    if (invalidCounter == 1) 
    {
      $('form #response').removeClass().addClass('error')
        .html('<strong>Please correct the errors below.</strong>' +errorMsg).fadeIn('fast');  
    }
    else
    {

      ajax_UpdateClass(var_ClassID, var_SchoolYear, var_Section);
    }
}
//---------------------------------------------------------------------------
// D R O P D O W N   A J A X E S   ( A D D , E D I T )
//---------------------------------------------------------------------------	


function ajax_GetSchoolYear(action)
{
	if (action == 'add')
	{
		var dropDown = document.getElementById("dropDown_AddModal_SchoolYear");
	}
	else if (action == 'edit')
	{
		var dropDown = document.getElementById("dropDown_EditModal_SchoolYear");
	}
	emptyDropDown(dropDown);

    return promise = new Promise((resolve, reject) =>
    {

        $.ajax({    
            type: 'POST',
            url: 'Backend/a_ClassRecordsManagement.php',   
            data: 
            {
                action: "1"
            },
            dataType: 'json',
            cache: false
        })

        .done(function(data) 
        { 
            //iterate through json array
            for (var i = 0; i < data.length; i++)
            {
                var obj = data[i];

                var optionEntry = document.createElement("option");
                optionEntry.text = "SY "+ obj['schoolYear'];
                optionEntry.value = obj['syTermID'];
                dropDown.options.add(optionEntry);
            }

            resolve();
        })

        .fail(function(XMLHttpRequest, textStatus, errorThrown) 
        {
            console.log('ERR: Error in School Year retrieval!');
            reject('Error in School Year retrieval!\n' + errorThrown);        
        });

    });
}

function ajax_GetGradeLevel(action)
{
   if (action == 'add')
   {
      var dropDown = document.getElementById("dropDown_AddModal_GradeLevel");
   }
   else if (action == 'edit')
   {
      var dropDown = document.getElementById("dropDown_EditModal_GradeLevel");
   }

   emptyDropDown(dropDown);  


    return promise = new Promise((resolve, reject) =>
    {

        $.ajax({  
         type: 'POST',
         url: 'Backend/a_ClassRecordsManagement.php',  
         data: 
         {
            action: "2"
         },
         dataType: 'json',
         cache: false
      })

      .done(function(result) 
      {
         result.forEach(function(entry)
         { 
            var optionEntry = document.createElement("option");
            optionEntry.text = entry['gradeLevelName'];
            optionEntry.value = entry['gradeLevelID'];
            dropDown.options.add(optionEntry);
         });

         resolve();
      })

      .fail(function(XMLHttpRequest, textStatus, errorThrown) 
      {  
         console.log('ERR: Error in Grade Level retrieval!\n' + errorThrown);
         reject();
      });

   });

}

async function ajax_GetSection(action)
{
	if (action == 'add')
	{
		var dropDown = document.getElementById("dropDown_AddModal_Section");
      var gradeLevel = document.getElementById("dropDown_AddModal_GradeLevel").value;
	}
	else if (action == 'edit')
	{
		var dropDown = document.getElementById("dropDown_EditModal_Section");
      var gradeLevel = document.getElementById("dropDown_EditModal_GradeLevel").value;
	}

	emptyDropDown(dropDown);

    return promise = new Promise((resolve, reject) =>
    {

        $.ajax({	
    		type: 'POST',
    		url: 'Backend/a_ClassRecordsManagement.php',	
    		data: 
    		{
    			action: "3",
            sent_GradeLevel: gradeLevel
    		},
    		dataType: 'json',
    		cache: false
    	})

      .done(function(data) 
    	{ 
         b = data.length; 

    		for (var i = 0; i < data.length; i++)
    		{
    			var obj = data[i];

    			var optionEntry = document.createElement("option");
    			optionEntry.text = obj['gradeLevelName'] + " - " + obj['sectionName'];
    			optionEntry.value = obj['sectionID'];
    			dropDown.options.add(optionEntry);

    		}

            dropDown[0].selectedIndex = 0;

            resolve();  
        })

    	.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    	{	
    		console.log('ERR: Error in Section retrieval!\n' + errorThrown); 	
         reject();
    	});

    });

}


//---------------------------------------------------------------------------
// M O D A L   A J A X E S
//---------------------------------------------------------------------------	

function ajax_AddClass(var_SYTermID, var_GradeLevelID, var_SectionID)
{



    return promise = new Promise(function(resolve, reject)
    {
   	var request = $.ajax({	
   		type: 'POST',
   		url: 'Backend/a_ClassRecordsManagement.php',	
   		data: 
   		{
   			action: "11", 
   			sendSYTermID:      var_SYTermID,
        sendGradeLevelID:  var_GradeLevelID, 
   			sendSectionID:     var_SectionID,

   		},
   		dataType: 'text', 
   		cache: false
   	});

   	request.done(function(data) 
   	{ 
   		alert('Success!');
   		location.reload();
      resolve();	
   	});

   	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
   	{
   		alert('Failure!' + errorThrown);
   		reject();		
   	});
   });

}

function ajax_RetrieveClass(classID)
{

    return promise = new Promise(function(resolve, reject)
    {
     	var request = $.ajax({	
     		type: 'POST',	
     		url: 'Backend/a_ClassRecordsManagement.php',
     		data: 
     		{
     			action: "12",
     			sendClassID: classID
     		},
     		dataType: 'json',
     		cache: false
      });

     	request.done(function(data) 
     	{ 
           resolve(data);
     	});

     	request.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
     	{
     		console.log('ERR: Error in Retrieving Class Info!\n' + errorThrown); 		
           reject();
     	});	


    });
}

function ajax_UpdateClass(var_ClassID, var_SchoolYear, var_Section)
{

    return promise = new Promise(function(resolve, reject)
    {
    	var request = $.ajax({	
    		type: 'POST',
    		url: 'Backend/a_ClassRecordsManagement.php',	
    		data: 
    		{
    			action: "13",

    			sendClassID      : var_ClassID    ,
    			sendSYTermID     : var_SchoolYear ,
    			sendSectionID    : var_Section    ,

    		},

    		dataType: 'text', 
    		cache: false
    	});

    	request.done(function(data) 
    	{ 
        alert('success!');
    		location.reload();
        resolve();
    	});

    	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    	{
    		console.log('ERR: Error in Updating Class Info!\n' + errorThrown);		
        reject();
    	});
    

    });
}

function ajax_DeleteClass(var_ClassID)
{

    return promise = new Promise(function(resolve, reject)
    {
    	var request = $.ajax({	
    		type: 'POST',
    		url: 'Backend/a_ClassRecordsManagement.php',	
    		data: 
    		{
    			action: "14", 
    			sendClassID:  var_ClassID
    		},
    		dataType: 'text', 
    		cache: false
    	});

    	request.done(function(data) 
    	{ 
    		alert('Success!');
    		location.reload();
        resolve();
    	});

    	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    	{
          console.log('ERR: Error in Deleting Class\n' + errorThrown);    
          reject();	
    	});
    });
}




function ajax_LoadMainSYTerm()
{
     var dropDown  = document.getElementById("dropDown_Main_SYTerm");
     emptyDropDown(dropDown);
    return promise = new Promise(function(resolve, reject)
    {
        var request = $.ajax({  
            type: 'POST',
            url: 'Backend/a_ClassRecordsManagement.php',   
            data: 
            {
                action: "21"
            },
            dataType: 'JSON', 
            cache: false
        });    

        request.done(function(data) 
        {

            for (var i = 0; i < data.length; i++)
            {
                var obj = data[i];

                var optionEntry = document.createElement("option");
                optionEntry.text = "SY "+ obj['schoolYear'] + " (" + obj['children'] + " children)";
                optionEntry.text_Alter = obj['schoolYear'];
                optionEntry.value = obj['syTermID'];

                dropDown.options.add(optionEntry);
            }

            resolve();
        });

    	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    	{
    		console.log('ERR: Cannot Retrieve School Year.\n' + errorThrown);		
        reject();
    	});
    });
}


function ajax_LoadMainGradeLevel()
{
    var dropDown  = document.getElementById("dropDown_Main_GradeLevel");
    emptyDropDown(dropDown);

    var syTermIDStart = document.getElementById('dropDown_Main_SYTerm').value;



    return promise = new Promise(function(resolve, reject)
    {
        var request = $.ajax({  
            type: 'POST',
            url: 'Backend/a_ClassRecordsManagement.php',   
            data: 
            {
                action: "22",
                sent_SYTermIDStart: syTermIDStart
            },
            dataType: 'JSON', 
            cache: false
        });    

        request.done(function(data) 
        {
            for (var i = 0; i < data.length; i++)
            {
                var obj = data[i];

                var optionEntry = document.createElement("option");
                optionEntry.text = obj['gradeLevelName'] + " (" + obj['children'] + " children)";
                optionEntry.text_Alter = obj['gradeLevelName']
                optionEntry.value = obj['gradeLevelID'];

                dropDown.options.add(optionEntry);
            }

            resolve();
        });

    	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    	{
    		console.log('ERR: Cannot Retrieve Grade Level.\n' + errorThrown);	
         reject();	
    	});
    });    
}


function ajax_GetClassTableEntries(var_SYTermID, var_GradeLevel)
{

    return promise = new Promise(function(resolve, reject){
        var request = $.ajax({  
            type: 'POST',
            url: 'Backend/a_ClassRecordsManagement.php',   
            data : 
            {
                action : "23",
                sent_SYTermID : var_SYTermID,
                sent_GradeLevel : var_GradeLevel
            },
            dataType: 'JSON', 
            cache: false
        });    

        request.done(function(data) 
        { 
            resolve(data);
        });

        request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
        {
            console.log('ERR: Cannot Retrieve classes.\n' + errorThrown);   
            reject();    
        });    
    });
}




function ajax_CheckNewEntryForExistence(schoolYearID, sectionID)
{
    return promise = new Promise(function(resolve, reject){
        var request = $.ajax({  
            type: 'POST',
            url: 'Backend/a_ClassRecordsManagement.php',   
            data : 
            {
                action : "31",
                sent_SYTermID : schoolYearID,
                sent_SectionID : sectionID
            },
            dataType: 'JSON', 
            cache: false
        });    

        request.done(function(data) 
        {
            resolve(data);
        });

        request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
        {
            console.log('ERR: Cannot Check Entry for Existence.\n' + errorThrown);   
            reject();    
        });    
    });  
}

function ajax_CheckExistingEntry(classID, schoolYearID, sectionID)
{
    return promise = new Promise(function(resolve, reject){
        var request = $.ajax({  
            type: 'POST',
            url: 'Backend/a_ClassRecordsManagement.php',   
            data : 
            {
                action : "32",
                sent_ClassID : classID,
                sent_SYTermID : schoolYearID,
                sent_SectionID : sectionID
            },
            dataType: 'JSON', 
            cache: false
        });    

        request.done(function(data) 
        {
            resolve(data);
        });

        request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
        {
            console.log('ERR: Cannot Check Entry for Existence.\n' + errorThrown);   
            reject();    
        });    
    });  

}