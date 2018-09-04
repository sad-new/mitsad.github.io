

// E T O   Y U N G   M A Y   P R O M I S E   A T   M A Y   A S Y N C   F X N

function object_Class()
{
	var classID = "";
    var schoolYear = "";
    var gradeLevel = "";
    var section = "";
    var subject = "";


    this.setVariables = function(var_ClassID, var_SchoolYear, 
                var_GradeLevel, var_Section)
    {
    	  classID = var_ClassID;
        schoolYear = var_SchoolYear;
        gradeLevel = var_GradeLevel;
        section = var_Section;
    };


    this.setVariable_ClassID = function(var_ClassID)
    {
      classID = var_ClassID;
    }

    this.setVariable_SchoolYear = function(var_SchoolYear)
    {
      schoolYear = var_SchoolYear;
    }

    this.setVariable_GradeLevel = function(var_GradeLevel)
    {
      gradeLevel = var_GradeLevel;
    }

    this.getVariables = function()
    {
        var classDetails = new Object();

        classDetails["classID"] = classID;
        classDetails["schoolYear"] = schoolYear;
        classDetails["gradeLevel"] = gradeLevel;
        classDetails["section"] = section;
        classDetails["subject"] = subject;  

        return classDetails;
    };

    this.purgeVariables = function()
    {
 	    classID = "";
  		schoolYear = "";
  		gradeLevel = "";
    	section = "";
    	subject = "";  
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
      loadDropDowns('add', function(result){});
   });

	$('#button_AddModal_AddClass').click(function(e) 
	{
		ajax_AddClass();
	});


	$('#dropDown_AddModal_SchoolYear').change(function(e) 
	{	
	});

   $('#dropDown_AddModal_GradeLevel').change(function(e) 
   {  
      ajax_GetSection('add');
      ajax_GetSubject('add');
   });

	$('#dropDown_AddModal_Section').change(function(e) 
	{	
	});


//---------------------------------------------------------------------------
// E D I T   C L A S S   M O D A L
//---------------------------------------------------------------------------	

    $(document).on( "click", ".button_Main_EditClass", function() 
	{	
      var classID = this.value;
      obj_ClassObject.setVariables(classID,"","","",""); 
      fillEditModal(classID);
	});


	$(document).on( "click", "#button_EditModal_UpdateClass", function() 
	{
		var var_ClassID = obj_ClassObject.getVariables()["classID"];

		var var_SchoolYear = document.getElementById("dropDown_EditModal_SchoolYear").value;
    var var_GradeLevel = document.getElementById("dropDown_EditModal_GradeLevel").value;
		var var_Section = document.getElementById("dropDown_EditModal_Section").value;
    var var_Subject = document.getElementById("dropDown_EditModal_Subject").value;
    var var_Teacher = document.getElementById("dropDown_EditModal_Teacher").value;

		ajax_UpdateClass(
      var_ClassID, var_SchoolYear, 
      var_GradeLevel, var_Section, 
      var_Subject, var_Teacher);
	});

	$('#dropDown_EditModal_SchoolYear').change(function(e) 
	{	
	});

   $('#dropDown_EditModal_GradeLevel').change(function(e) 
   {  
      ajax_GetSection('edit');
      ajax_GetSubject('edit');
   });

	$('#dropDown_EditModal_Section').change(function(e) 
	{	
	});


//---------------------------------------------------------------------------
// D E L E T E   C L A S S   M O D A L
//---------------------------------------------------------------------------	


  $(document).on( "click", ".button_Main_DeleteClass", function() 
  {
  	obj_ClassObject.setVariables
    (
  		this.value,
  		"","","",""
    );
  	alert(obj_ClassObject.getVariables()["classID"]);

	});

	$('#button_DeleteModal_DeleteClass').click(function(e) 
	{

		var var_ClassID = obj_ClassObject.getVariables()["classID"];
		var var_SchoolYear = document.getElementById("dropDown_EditModal_SchoolYear");
		var var_Section = document.getElementById("dropDown_EditModal_Section");
		var var_Subject = document.getElementById("dropDown_EditModal_Subject");

		ajax_DeleteClass(var_ClassID, var_SchoolYear, var_Section, var_Subject);
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
   await ajax_GetSubject(action);
   await ajax_GetTeacher(action);
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

    var syTermIDText = syTermID.options[syTermID.selectedIndex].text;
    var gradeLevelText = gradeLevel.options[gradeLevel.selectedIndex].text_Alter;


    document.getElementById("classChartName").innerHTML = 
    "List of Registered Classes in <b>" + gradeLevelText + "</b> for  <b>" + syTermIDText + "</b>"; 

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

            var tableBody = document.createElement('tbody');

            tableContainer.appendChild(table);
            
            table.appendChild(tableHead);
            tableHead.appendChild(tableHeadRow);
            tableHeadRow.appendChild(document.createElement('th')).appendChild(document.createTextNode('Section List'));
            tableHeadRow.appendChild(document.createElement('th'));


            table.appendChild(tableBody);

            for (var i = 0; i < result.length; i++)
            {
                var classSection = result[i];
                var classSubjectList = result[i]['classTable'];

                var text_rowTtitle = "+ Section " + classSection['sectionName'] + " (" + classSubjectList.length + " children)" ;
                var tableBodyCellText = document.createTextNode(text_rowTtitle);

                var tableBodyRow = document.createElement('tr'); 
                var tableBodyCell = document.createElement('td');
                tableBodyCell.className = 'clickable';

                var tableBodyRow2 = document.createElement('tr'); 
                var tableBodyCell2 = document.createElement('td');

                tableBody.appendChild(tableBodyRow);
                tableBodyRow.appendChild(tableBodyCell).appendChild(tableBodyCellText);

                tableBody.appendChild(tableBodyRow2);
                tableBodyRow2.appendChild(tableBodyCell2);

                loadSubTable(tableBodyCell2, classSubjectList);
            }
        }

        else 
        {
          //alert('error');
        }
    });
}


async function loadSubTable(parentCell, array_classTable)
{
    var tableHeaderColumns = ['Class ID', 'Subject', 'Teacher', '', ''];
    var subTableHeaderTitledColumns = ['classID', 'subjectName', 'employeeName'];

    var syTermID = document.getElementById('dropDown_Main_SYTerm');

    var table = document.createElement('table');
    table.id = "subTable";
    table.className = "table"; 
    table.className += " table-bordred";
    table.className += " table-striped";

    var tableHead = document.createElement('thead');
    var tableHeader = document.createElement('tr');

    var tableBody = document.createElement('tbody');

    parentCell.appendChild(table);
    table.appendChild(tableHead).appendChild(tableHeader);

    for (var i = 0; i <  tableHeaderColumns.length; i++)
    {
        tableHeader.appendChild(document.createElement('th')).appendChild
        (document.createTextNode(tableHeaderColumns[i]));
    }
    table.appendChild(tableBody);

    for (var i = 0; i < array_classTable.length; i++)
    {
        var tableRow = document.createElement('tr');
        tableBody.appendChild(document.createElement('tr'));
        tableBody.appendChild(tableRow);

        for (var j = 0; j < subTableHeaderTitledColumns.length; j++)
        {
            var tableCell = document.createElement('td');
            tableRow.appendChild(tableCell);
            tableCell.appendChild(document.createTextNode(array_classTable[i][subTableHeaderTitledColumns[j]]));
        }


        var paragraph1 = document.createElement('p');
        paragraph1.setAttribute("data-placement","top");
        paragraph1.setAttribute("data-toggle","tooltip"); 
        paragraph1.setAttribute("title","Edit");

        var button_EditClass = document.createElement('button');
        button_EditClass.setAttribute("class","btn btn-primary btn-xs button_Main_EditClass"); 
        button_EditClass.setAttribute("data-title","Edit"); 
        button_EditClass.setAttribute("data-toggle","modal"); 
        button_EditClass.setAttribute("data-target","#edit");  
        button_EditClass.setAttribute("name","editClassButton");
        button_EditClass.setAttribute("value",array_classTable[i]['classID']);

        var span1 = document.createElement('span');
        span1.setAttribute("class","glyphicon glyphicon-pencil");



        var paragraph2= document.createElement('p');
        paragraph2.setAttribute("data-placement","top");
        paragraph2.setAttribute("data-toggle","tooltip"); 
        paragraph2.setAttribute("title","Delete");

        var button_DeleteClass = document.createElement('button');
        button_DeleteClass.setAttribute("class","btn btn-danger btn-xs button_Main_DeleteClass"); 
        button_DeleteClass.setAttribute("data-title","Delete"); 
        button_DeleteClass.setAttribute("data-toggle","modal"); 
        button_DeleteClass.setAttribute("data-target","#delete");  
        button_DeleteClass.setAttribute("name","deleteClassButton");
        button_DeleteClass.setAttribute("value",array_classTable[i]['classID']);

        var span2 = document.createElement('span');
        span2.setAttribute("class","glyphicon glyphicon-trash");

        tableRow.appendChild(document.createElement('td'))
            .appendChild(paragraph1)
            .appendChild(button_EditClass)
            .appendChild(span1);
        
        tableRow.appendChild(document.createElement('td'))
            .appendChild(paragraph2)
            .appendChild(button_DeleteClass)
            .appendChild(span2);
    }
}

async function fillEditModal(classID)
{
   
   await loadDropDowns('edit');
   await ajax_RetrieveClass(classID)
   .then(function(result)
   {
      var dropDown = document.getElementById("dropDown_EditModal_SchoolYear");
      var dropDown2 = document.getElementById("dropDown_EditModal_GradeLevel");
      var dropDown3 = document.getElementById("dropDown_EditModal_Section");
      var dropDown4 = document.getElementById("dropDown_EditModal_Subject");
      var dropDown5 = document.getElementById("dropDown_EditModal_Teacher");


      for (var i = 0; i < dropDown.length; i++)
      {
         if (dropDown.options[i].value==result['syTermID_Classes']) 
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

      ajax_GetSubject('edit')
      .then(function()
      {

         for (var i = 0; i < dropDown4.length; i++)
         {
            if (dropDown4.options[i].value==result['subjectID_Classes']) 
            {
               dropDown4.options[i].selected = true;
               break;  
            }
         }     
      });  

      for (var i = 0; i < dropDown5.length; i++)
      {
         if (dropDown5.options[i].value==result['adviserID_Classes']) 
         {
            dropDown5.options[i].selected = true;
            break;  
         }
      }

   });
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
            url: 'Backend/a_ClassManagement.php',   
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
                optionEntry.text = "SY "+ obj['schoolYear'] + " Term " + obj['termNumber'];
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
         url: 'Backend/a_ClassManagement.php',  
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
    		url: 'Backend/a_ClassManagement.php',	
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


async function ajax_GetSubject(action)
{
  if (action == 'add')
  {
    var dropDown = document.getElementById("dropDown_AddModal_Subject");
      var gradeLevel = document.getElementById("dropDown_AddModal_GradeLevel").value;
  }
  else if (action == 'edit')
  {
    var dropDown = document.getElementById("dropDown_EditModal_Subject");
      var gradeLevel = document.getElementById("dropDown_EditModal_GradeLevel").value;
  }

  emptyDropDown(dropDown);

    return promise = new Promise((resolve, reject) =>
    {

        $.ajax({  
        type: 'POST',
        url: 'Backend/a_ClassManagement.php', 
        data: 
        {
          action: "4",
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
          optionEntry.text = obj['subjectName'];
          optionEntry.value = obj['subjectID'];
          dropDown.options.add(optionEntry);

        }

            dropDown[0].selectedIndex = 0;

            resolve();  
        })

      .fail(function(XMLHttpRequest, textStatus, errorThrown) 
      { 
        console.log('ERR: Error in Subject retrieval!\n' + errorThrown);  
         reject();
      });

    });

}


async function ajax_GetTeacher(action)
{
  if (action == 'add')
  {
    var dropDown = document.getElementById("dropDown_AddModal_Teacher");
  }
  else if (action == 'edit')
  {
    var dropDown = document.getElementById("dropDown_EditModal_Teacher");
  }

  emptyDropDown(dropDown);


  var request = $.ajax({  
    type: 'POST',
    url: 'Backend/a_ClassManagement.php', 
    data: 
    {
      action: "5"
    },
    dataType: 'json', 
    cache: false
  });

  request.done(function(data) 
  { 
      //iterate through json array
    for (var i = 0; i < data.length; i++)
    {
      var obj = data[i];
      var optionEntry = document.createElement("option");
      optionEntry.text = obj['employeeName'];
      optionEntry.value = obj['employeeID'];

      dropDown.options.add(optionEntry);
    }
    resolve();
  });

  request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  {
    console.log('ERR: Error in Teacher retrieval!\n' + errorThrown);     
    resolve();    
  });
}

//---------------------------------------------------------------------------
// M O D A L   A J A X E S
//---------------------------------------------------------------------------	

function ajax_AddClass()
{
	var var_SYTermID = document.getElementById("dropDown_AddModal_SchoolYear").value;
  var var_GradeLevelID = document.getElementById("dropDown_AddModal_GradeLevel").value;
  var var_SectionID = document.getElementById("dropDown_AddModal_Section").value;
  var var_SubjectID = document.getElementById("dropDown_AddModal_Subject").value;
  var var_TeacherID = document.getElementById("dropDown_AddModal_Teacher").value;


  alert(var_SYTermID + " " + var_GradeLevelID + " " + var_SectionID + " " + 
    var_SubjectID + " " + var_TeacherID);

    return promise = new Promise(function(resolve, reject)
    {
   	var request = $.ajax({	
   		type: 'POST',
   		url: 'Backend/a_ClassManagement.php',	
   		data: 
   		{
   			action: "11", 
   			sendSYTermID:      var_SYTermID,
        sendGradeLevelID:  var_GradeLevelID, 
   			sendSectionID:     var_SectionID,
        sendSubjectID:     var_SubjectID,
        sendTeacherID:     var_TeacherID

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
   		alert('Failure!');
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
   		url: 'Backend/a_ClassManagement.php',
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

function ajax_UpdateClass(
    var_ClassID, var_SchoolYear, 
    var_GradeLevel, var_Section, 
    var_Subject, var_Teacher)
{

	var request = $.ajax({	
		type: 'POST',
		url: 'Backend/a_ClassManagement.php',	
		data: 
		{
			action: "13",

			sendClassID      : var_ClassID    ,

			sendSYTermID     : var_SchoolYear ,
      sendGradeLevelID : var_GradeLevel ,
			sendSectionID    : var_Section    ,
      sendSubjectID    : var_Subject    ,
      sendTeacherID    : var_Teacher

		},

		dataType: 'text', 
		cache: false
	});

	request.done(function(data) 
	{ 
		alert('Success!');
		location.reload();
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Failure!');		
	});

}

function ajax_DeleteClass(var_ClassID, callback)
{
	var request = $.ajax({	
		type: 'POST',
		url: 'Backend/a_ClassManagement.php',	
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
		callback(true);	
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Failure!');
		callback(false);		
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
            url: 'Backend/a_ClassManagement.php',   
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
                optionEntry.text = "SY "+ obj['schoolYear'] + " Term " + obj['termNumber'] + " (" + obj['children'] + " children)";
                optionEntry.text_Alter = obj['schoolYear']
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
            url: 'Backend/a_ClassManagement.php',   
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
            url: 'Backend/a_ClassManagement.php',   
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




