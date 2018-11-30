



function object_Class()
{
  var classID = "";
  var className = "";  
  var sectionName = "";
  var schoolYear = "";  



  this.setClassID = function(var_ClassID)
  {
    classID = var_ClassID;
  };

  this.setClassName = function(var_ClassName)
  {
    className = var_ClassName;
  };

  this.setSchoolYear = function(var_SchoolYear)
  {
    schoolYear = var_SchoolYear;
  };

  this.setSectionName = function(var_SectionName)
  {
    sectionName = var_SectionName;
  };



  this.getClassID = function()
  {
    return classID;
  }

  this.getClassName = function()
  {
    return className;
  }

  this.getSchoolYear = function()
  {
    return schoolYear;
  }

  this.getSectionName = function()
  {
    return sectionName;
  }

}


function object_ClassSubject()                
{
	var classSubjectID = "";
  var subject = "";
  var teacher = "";

    this.setClassSubjectID = function(var_ClassSubjectID)
    {
      classSubjectID = var_ClassSubjectID;
    };

    this.setSubject = function(var_Subject)
    {
        subject = var_Subject;
    };

    this.setTeacher = function(var_Teacher)
    {
        schoolYear = var_SchoolYear;
    };



    this.getClassSubjectID = function()
    {
      return classSubjectID;
    }

    this.gettSubject = function()
    {
        return subject;
    };

    this.getTeacher = function()
    {
        return schoolYear;
    };



    this.purgeVariables = function()
    {
      classSubjectID = "";
      subject = "";
      teacher = "";
    }
}


$(document).ready(function() 
{
  object_ClassObject = new object_Class();
  object_ClassSubjectObject = new object_ClassSubject();


  var selected = localStorage.getItem('classID');
    if (selected == null)
  {
    window.location = "ClassManagement.php";
  }

  else
  {
    object_ClassObject.setClassID(selected);
    mainPage_Load_Items(object_ClassObject.getClassID(), object_ClassObject);
  }


  $(document).on("change", "#dropDown_Main_SYTerm", function()
  {
    mainPage_Load_Table(object_ClassObject.getClassID(), this.value); 
  });

//---------------------------------------------------------------------------
// A D D   C L A S S   M O D A L
//---------------------------------------------------------------------------	


  $(document).on("click", "#button_Main_AddClassSubject", function()
  {
    modal_Load_DropDowns('add', object_ClassObject.getClassID());

    term = $("#dropDown_Main_SYTerm option:selected").text();
    term = term.substr(0, term.indexOf('('));

    document.getElementById("addModal_Heading").innerHTML = "Add a new Class for <b> "
    + object_ClassObject.getSectionName() +"</b> in <b>" + term +"</b>";

  });

	$('#button_AddModal_AddClassSubject').click(function(e) 
	{
    $('#response').empty();
    object_ClassSubjectObject.purgeVariables();
    addClassSubject(object_ClassSubjectObject);
	});


	$('#dropDown_AddModal_Subject').change(function(e) 
	{	
	});

	$('#dropDown_AddModal_Teacher').change(function(e) 
	{	
	});	

//---------------------------------------------------------------------------
// E D I T   C L A S S   M O D A L
//---------------------------------------------------------------------------	

  $(document).on("click", ".button_Main_EditClassSubject", function() 
	{	
    $('#response').empty();

    object_ClassSubjectObject.purgeVariables();
    object_ClassSubjectObject.setClassSubjectID(this.value);	

    retrieveClassSubject(object_ClassSubjectObject);
	});


	 $(document).on( "click", "#button_EditModal_UpdateClassSubject", function() 
	{
    $('#response').empty();
    updateClassSubject(object_ClassObject, object_ClassSubjectObject);
  });

	$('#dropDown_EditModal_SchoolYear').change(function(e) 
	{	
	});

	$('#dropDown_EditModal_Section').change(function(e) 
	{	
		ajax_GetSubject('edit');
	});

	$('#dropDown_EditModal_Subject').change(function(e) 
	{	
	});

	$('#dropDown_EditModal_Teacher').change(function(e) 
	{	
	});	

//---------------------------------------------------------------------------
// D E L E T E   C L A S S   M O D A L
//---------------------------------------------------------------------------	


    $(document).on( "click", ".button_Main_DeleteClassSubject", function() 
    {
		  object_ClassSubjectObject.setClassSubjectID(this.value);
      
      var deleteModal_TextBox = document.getElementById('deleteModal_Message');
      deleteModal_TextBox.innerHTML = "";

      var deleteModal_Span = document.createElement('span');
        deleteModal_Span.class = "glyphicon glyphicon-warning-sign";

      var deleteModal_Text1 = 
      " Are you sure you want to delete this? ";


      var deleteModal_Text2 = 
      " Take note that all instances of this subject in section "
        +object_ClassObject.getSectionName() + " in SY " + object_ClassObject.getSchoolYear() + " will be removed.";


      deleteModal_TextBox.appendChild(deleteModal_Span);
      deleteModal_TextBox.appendChild(document.createTextNode(deleteModal_Text1));
      deleteModal_TextBox.appendChild(document.createElement("br"));
      deleteModal_TextBox.appendChild(document.createTextNode(deleteModal_Text2));


  	});

	$('#button_DeleteModal_DeleteClassSubject').click(function(e) 
	{

		var var_ClassSubjectID = object_ClassSubjectObject.getClassSubjectID();
		ajax_DeleteClassSubject(var_ClassSubjectID);
	});


});


//---------------------------------------------------------------------------
// D R O P D O W N   C O N T R O L S
//---------------------------------------------------------------------------	


async function mainPage_Load_Items(var_ClassID, object_Class)
{
  await ajax_LoadMainSYTerm(var_ClassID);

  var syTermID = document.getElementById('dropDown_Main_SYTerm');
  var var_SYTermID = syTermID.options[syTermID.selectedIndex].value

  await ajax_LoadClassDetails(var_ClassID)
  .then
  (function(result)
  {
    object_Class.setSchoolYear(result['schoolYear']);
    object_Class.setSectionName(result['sectionName']);
  });
  await mainPage_Load_Table(var_ClassID, var_SYTermID); 
}






async function mainPage_Load_Table(var_ClassID, var_SYTerm)
{
    var tableContainer = document.getElementById("mainTableContainer");

    ajax_GetClassTableEntries(var_ClassID, var_SYTerm) 
    .then(function(result)
    {
        tableContainer.innerHTML = "";

        if (result != false)
        {
            
            var tableHeaderColumns = ['ClassSubject ID', 'Subject', 'Teacher', '', ''];
            var subTableHeaderTitledColumns = ['classSubjectID', 'subjectName', 'employeeName'];

            var syTermID = document.getElementById('dropDown_Main_SYTerm');

            var table = document.createElement('table');
            table.id = "mainTable";
            table.className = "table"; 
            table.className += " table-bordred";
            table.className += " table-striped";

            var tableHead = document.createElement('thead');
            var tableHeader = document.createElement('tr');

            var tableBody = document.createElement('tbody');

            tableContainer.appendChild(table);
            
            table.appendChild(tableHead).appendChild(tableHeader);
            for (var i = 0; i <  tableHeaderColumns.length; i++)
            {
                tableHeader.appendChild(document.createElement('th')).appendChild
                (document.createTextNode(tableHeaderColumns[i]));
            }

            table.appendChild(tableBody);
            for (var i = 0; i < result.length; i++)
            {
                var tableRow = document.createElement('tr');
                tableBody.appendChild(tableRow);

                for (var j = 0; j < subTableHeaderTitledColumns.length; j++)
                {
                    var tableCell = document.createElement('td');
                    tableRow.appendChild(tableCell);
                    tableCell.appendChild(document.createTextNode(result[i][subTableHeaderTitledColumns[j]]));
                }


                var paragraph1 = document.createElement('p');
                paragraph1.setAttribute("data-placement","top");
                paragraph1.setAttribute("data-toggle","tooltip"); 
                paragraph1.setAttribute("title","Edit");

                var button_EditClass = document.createElement('button');
                button_EditClass.setAttribute("class","btn btn-primary btn-xs button_Main_EditClassSubject"); 
                button_EditClass.setAttribute("data-title","Edit"); 
                button_EditClass.setAttribute("data-toggle","modal"); 
                button_EditClass.setAttribute("data-target","#edit");  
                button_EditClass.setAttribute("name","editClassSubjectButton");
                button_EditClass.setAttribute("value",result[i]['classSubjectID']);

                var span1 = document.createElement('span');
                span1.setAttribute("class","glyphicon glyphicon-pencil");



                var paragraph2= document.createElement('p');
                paragraph2.setAttribute("data-placement","top");
                paragraph2.setAttribute("data-toggle","tooltip"); 
                paragraph2.setAttribute("title","Delete");

                var button_DeleteClass = document.createElement('button');
                button_DeleteClass.setAttribute("class","btn btn-danger btn-xs button_Main_DeleteClassSubject"); 
                button_DeleteClass.setAttribute("data-title","Delete"); 
                button_DeleteClass.setAttribute("data-toggle","modal"); 
                button_DeleteClass.setAttribute("data-target","#delete");  
                button_DeleteClass.setAttribute("name","deleteClassSubjectButton");
                button_DeleteClass.setAttribute("value",result[i]['classSubjectID']);

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

        else 
        {
            alert('error here');
        }
    });
}





async function modal_Load_DropDowns(action, var_ClassSubjectID)
{
    await ajax_GetSubject(action, var_ClassSubjectID);
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




async function addClassSubject(Object_ClassObject)
{

  var invalidCounter = 0;
  var errorMsg = "";
  var required = ' is required.';

  var classID = object_ClassObject.getClassID();
  var syTermID = $('#dropDown_Main_SYTerm').val();
  var subjectID = $('#dropDown_AddModal_Subject').val();
  var teacherID = $('#dropDown_AddModal_Teacher').val();

  if (syTermID == null)
  {
        invalidCounter++;
        errorMsg += '</br>A SchoolYear Term is required.';
  }

  if (subjectID == null)
  {
        invalidCounter++;
        errorMsg += '</br>A Subject is required.';
  }

  if (teacherID == null)
  {
        invalidCounter++;
        errorMsg += '</br>A Teacher is required.';
  }

  await ajax_CheckNewEntryForExistence(classID, syTermID, subjectID)
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
    ajax_AddClassSubject(object_ClassObject.getClassID());
  }

}


async function retrieveClassSubject(obj_ClassSubjectObject)
{
    var syTermID = document.getElementById("dropDown_Main_SYTerm").value;
    await modal_Load_DropDowns('edit', object_ClassObject.getClassID())
    .then(function(result)
    {
      ajax_RetrieveClassSubject(object_ClassSubjectObject.getClassSubjectID());
    });
}


async function updateClassSubject(object_classObject, object_ClassSubjectObject)
{
    
    var invalidCounter = 0;
    var errorMsg = "";
    var required = ' is required.';

    var classID = object_ClassObject.getClassID();
    var syTermID = $('#dropDown_Main_SYTerm').val();
    var subjectID = $('#dropDown_EditModal_Subject').val();
    var teacherID = $('#dropDown_EditModal_Teacher').val();
    var classSubjectID = object_ClassSubjectObject.getClassSubjectID();


    if (syTermID == null)
    {
          invalidCounter++;
          errorMsg += '</br>A SchoolYear Term is required.';
    }

    if (subjectID == null)
    {
          invalidCounter++;
          errorMsg += '</br>A Subject is required.';
    }

    if (teacherID == null)
    {
          invalidCounter++;
          errorMsg += '</br>A Teacher is required.';
    }

    await ajax_CheckExistingEntry(classID, syTermID, subjectID, classSubjectID)
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
    ajax_UpdateClassSubject(classSubjectID, subjectID, teacherID);
  }
}



//---------------------------------------------------------------------------
// D R O P D O W N   A J A X E S   ( A D D , E D I T )
//---------------------------------------------------------------------------	


function ajax_GetSubject(action, var_ClassID)
{

	if (action == 'add')
	{
			var dropDown = document.getElementById("dropDown_AddModal_Subject");
	}
	else if (action == 'edit')
	{
			var dropDown = document.getElementById("dropDown_EditModal_Subject");
	}	

   emptyDropDown(dropDown);

   return promise = new Promise((resolve, reject) =>
   {

      $.ajax({	
    		type: 'POST',
    		url: 'Backend/a_ClassSubjectManagement.php',	
    		data: 
    		{
    			action: "4", 
    			sent_ClassID: var_ClassID
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
    			optionEntry.text = "Grade " + obj['gradeLevelID_Subjects'] + " - " + obj['subjectName'];
    			optionEntry.value = obj['subjectID'];

    			dropDown.options.add(optionEntry);
    		}          
        resolve();
    	})

      .fail(function(XMLHttpRequest, textStatus, errorThrown) 
    	{
    		console.log('Error in Subject retrieval!\n' + errorThrown); 	
        reject('Error in Subject retrieval!');	
    	});

   });
}

function ajax_GetTeacher(action)
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

    return promise = new Promise((resolve, reject) =>
    {
        $.ajax({	
    		type: 'POST',
    		url: 'Backend/a_ClassSubjectManagement.php',	
    		data: 
    		{
    			action: "5"
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
    			optionEntry.text = obj['employeeName'];
    			optionEntry.value = obj['employeeID'];

    			dropDown.options.add(optionEntry);
    		}
            resolve();
    	})
      .fail(function(XMLHttpRequest, textStatus, errorThrown) 
    	{
    		console.log('Error in Teacher retrieval!\n' + errorThrown); 	
            reject('Error in Teacher retrieval!');		
    	});
    });
}


//---------------------------------------------------------------------------
// M O D A L   A J A X E S
//---------------------------------------------------------------------------	

function ajax_AddClassSubject(var_ClassID)
{
  var syTermID = document.getElementById("dropDown_Main_SYTerm").value;
	var addSubject = document.getElementById("dropDown_AddModal_Subject").value;
	var addTeacher = document.getElementById("dropDown_AddModal_Teacher").value;


	var request = $.ajax({	
		type: 'POST',
		url: 'Backend/a_ClassSubjectManagement.php',	
		data: 
		{
			action: "6", 
			sent_SYTermID:   syTermID,
			sent_ClassID:    var_ClassID,
			sent_SubjectID:  addSubject,
			sent_AdviserID:  addTeacher 
		},
		dataType: 'json', 
		cache: false
	});

	request.done(function(data) 
	{ 
		alert('Success!');
    location.reload();
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		alert('Error in adding ClassSubject! ' + errorThrown);
	});

}

function ajax_RetrieveClassSubject(classSubjectID)
{
	var request = $.ajax({	
		type: 'POST',	
		url: 'Backend/a_ClassSubjectManagement.php',
		data: 
		{
			action: "7",
			sent_ClassSubjectID: classSubjectID
		},
		dataType: 'json',
		cache: false
    });

	request.done(function(data) 
	{ 

		var dropDown_Subject = document.getElementById("dropDown_EditModal_Subject");
		var dropDown_Teacher = document.getElementById("dropDown_EditModal_Teacher");


    for (var i = 0; i < dropDown_Subject.length; i++)
    {
      if (dropDown_Subject.options[i].value==data['subjectID_ClassSubjects']) 
      {
        dropDown_Subject.options[i].selected = "Selected";
        break;  
      }
    }

		for (var i = 0; i < dropDown_Teacher.length; i++)
		{
		 	if (dropDown_Teacher.options[i].value==data['teacherID_ClassSubjects']) 
		 	{
        dropDown_Teacher.options[i].selected = "Selected";
        break;              		
      }
		}

	});

	request.fail(function(data, XMLHttpRequest, textStatus, errorThrown) 
	{
		console.log('Error in Retrieving Class Subject Info!\n' + errorThrown); 		
	});	
}

function ajax_UpdateClassSubject(var_ClassSubjectID, var_Subject, var_Teacher)
{

	var request = $.ajax({	
		type: 'POST',
		url: 'Backend/a_ClassSubjectManagement.php',	
		data: 
		{
			action: "8",

			sent_ClassSubjectID: var_ClassSubjectID,
			sent_SubjectID:      var_Subject,
			sent_TeacherID:      var_Teacher,
		},
		dataType: 'JSON', 
		cache: false
	});

	request.done(function(data) 
	{ 
		alert('Success!');
		location.reload();
	});

	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
	{
		console.log('Error in UPDATING Class Subject!\n' + errorThrown);		
	});

}

function ajax_DeleteClassSubject(var_ClassSubjectID, callback)
{

  alert(var_ClassSubjectID);
	var request = $.ajax({	
		type: 'POST',
		url: 'Backend/a_ClassSubjectManagement.php',	
		data: 
		{
			action: "9", 
			sent_ClassSubjectID:  var_ClassSubjectID
		},
		dataType: 'json', 
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
		alert('Failure!\n' + errorThrown);
		callback(false);		
	});

}



function ajax_LoadClassDetails(var_ClassID)
{
  var header = document.getElementById("classSubjectChartName")

  return promise = new Promise(function(resolve, reject)
  {
    var request = $.ajax({  
        type: 'POST',
        url: 'Backend/a_ClassSubjectManagement.php',   
        data: 
        {
            action: "22",
            sent_ClassID: var_ClassID
        },
        dataType: 'json', 
        cache: false
    });    
    request.done(function(result) 
    {
      header.innerHTML = "List of Registered Subjects for <b>" + result["gradeLevelName"] + "</b> section <b>" + result["sectionName"] + "</b> in SY <b>" + result["schoolYear"] + "</b>";
      resolve(result);
    });

    request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    {
      console.log('ERR: Cannot Class Details.\n' + errorThrown);
      reject();
    });
  });
}


function ajax_LoadMainSYTerm(var_ClassID)
{
  var dropDown  = document.getElementById("dropDown_Main_SYTerm");
  emptyDropDown(dropDown);


  return promise = new Promise(function(resolve, reject)
  {
      var request = $.ajax({  
          type: 'POST',
          url: 'Backend/a_ClassSubjectManagement.php',   
          data: 
          {
              action: "23",
              sent_ClassID: var_ClassID
          },
          dataType: 'json', 
          cache: false
      });    

      request.done(function(result) 
      {
        result.forEach(function(entry)
        {
          var optionEntry = document.createElement("option");
          optionEntry.text = "SY "+ entry['schoolYear'] + " Term " +  
          entry['termNumber'] + " (" + entry['children'] + " children)";
          optionEntry.value = entry['syTermID'];

          dropDown.options.add(optionEntry);
        });         
        resolve();
      });

  	request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
  	{
  		console.log('ERR: Cannot Retrieve School Year.\n' + errorThrown);
      reject();
  	});
  });
}


function ajax_GetClassTableEntries(var_ClassID, var_SYTermID)
{

    return promise = new Promise(function(resolve, reject){
        var request = $.ajax({  
            type: 'POST',
            url: 'Backend/a_ClassSubjectManagement.php',   
            data : 
            {
                action : "24",
                sent_ClassID : var_ClassID,
                sent_SYTermID : var_SYTermID
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
            console.log('ERR: Cannot Retrieve class Subjects.\n' + errorThrown);   
            reject();    
        });    
    });
}





function ajax_CheckNewEntryForExistence(classID, syTermID, subjectID)
{
    return promise = new Promise(function(resolve, reject){
        var request = $.ajax({  
            type: 'POST',
            url: 'Backend/a_ClassSubjectManagement.php',   
            data : 
            {
                action : "31",
                sent_ClassID : classID,
                sent_SYTermID : syTermID,
                sent_SubjectID : subjectID
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

function ajax_CheckExistingEntry(classID, schoolYearID, subjectID, classSubjectID)
{
    return promise = new Promise(function(resolve, reject){
        var request = $.ajax({  
            type: 'POST',
            url: 'Backend/a_ClassSubjectManagement.php',   
            data : 
            {
                action : "32",
                sent_ClassID : classID,
                sent_SYTermID : schoolYearID,
                sent_SubjectID : subjectID,
                sent_ClassSubjectID : classSubjectID
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


