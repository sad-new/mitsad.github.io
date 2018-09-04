



function object_Class()
{
  var classID = "";
  var schoolYear = "";  
  var sectionName = "";

  this.setClassID = function(var_ClassID)
  {
    classID = var_ClassID;
  };

  this.setSectionName = function(var_SectionName)
  {
    sectionName = var_SectionName;
  };

  this.setSchoolYear = function(var_SchoolYear)
  {
    schoolYear = var_SchoolYear;
  };

  this.getVariables = function()
  {
    var classDetails = new Object();

    classDetails["classID"] = classID;
    classDetails["schoolYear"] = schoolYear;
    return classDetails;
  };

  this.getClassID = function()
  {
    return classID;
  }

  this.getSectionName = function()
  {
    return sectionName;
  }

  this.getSchoolYear = function()
  {
    return schoolYear;
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

    this.getVariables = function()
    {
        var classSubjectDetails = new Object();

        classSubjectDetails["classSubjectID"] = classSubjectID;
        classSubjectDetails["subject"] = subject;  
        classSubjectDetails["teacher"] = teacher;

        return classSubjectDetails;
    };

    this.getClassSubjectID = function()
    {
      return classSubjectID;
    }
}


$(document).ready(function() 
{

  object_Class = new object_Class();

  let urlParams = new URLSearchParams(window.location.search);
  object_Class.setClassID(urlParams.get('ID'));
     
  object_ClassSubject = new object_ClassSubject();  

  mainPage_Load_Items(object_Class.getClassID(), object_Class);


  $(document).on("change", "#dropDown_Main_SYTerm", function()
  {
    mainPage_Load_Table(object_Class.getClassID(), this.value); 
  });

//---------------------------------------------------------------------------
// A D D   C L A S S   M O D A L
//---------------------------------------------------------------------------	


  $(document).on("click", "#button_Main_AddClassSubject", function()
  {
    modal_Load_DropDowns('add', object_Class.getClassID());
  });

	$('#button_AddModal_AddClassSubject').click(function(e) 
	{
		ajax_AddClassSubject(object_Class.getClassID());
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

    document.getElementById("radio_Edit_AllTerms").checked = true;

    object_ClassSubject.setClassSubjectID(this.value);	

    var syTermID = document.getElementById("dropDown_Main_SYTerm").value;
		modal_Load_DropDowns('edit', object_Class.getClassID())
    .then(function(result)
    {
			ajax_RetrieveClassSubject(object_ClassSubject.getClassSubjectID());
    });
	});


	 $(document).on( "click", "#button_EditModal_UpdateClassSubject", function() 
	{
		var var_ClassSubjectID = object_ClassSubject.getClassSubjectID();

		var var_Subject = document.getElementById("dropDown_EditModal_Subject").value;
		var var_Teacher = document.getElementById("dropDown_EditModal_Teacher").value;

    var affectedTerms = 0; 

    if (document.getElementById("radio_Edit_AllTerms").checked == true) {
      affectedTerms = 1; 
    }
    else if (document.getElementById("radio_Edit_SingleTerm").checked == true) {
      affectedTerms = 2; 
    }
    else
    { 
    }

    if (affectedTerms > 0)
    {
		  ajax_UpdateClassSubject(var_ClassSubjectID, var_Subject, var_Teacher, affectedTerms);
	  }

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
		  object_ClassSubject.setClassSubjectID(this.value);
      
      var deleteModal_TextBox = document.getElementById('deleteModal_Message');
      deleteModal_TextBox.innerHTML = "";

      var deleteModal_Span = document.createElement('span');
        deleteModal_Span.class = "glyphicon glyphicon-warning-sign";

      var deleteModal_Text1 = 
      " Are you sure you want to delete this? ";


      var deleteModal_Text2 = 
      " Take note that all instances of this subject in section "
        +object_Class.getSectionName() + " in SY " + object_Class.getSchoolYear() + " will be removed.";


      deleteModal_TextBox.appendChild(deleteModal_Span);
      deleteModal_TextBox.appendChild(document.createTextNode(deleteModal_Text1));
      deleteModal_TextBox.appendChild(document.createElement("br"));
      deleteModal_TextBox.appendChild(document.createTextNode(deleteModal_Text2));


  	});

	$('#button_DeleteModal_DeleteClassSubject').click(function(e) 
	{

		var var_ClassSubjectID = object_ClassSubject.getClassSubjectID();
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


async function modal_SetEditDropDownChoices()
{

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
		alert('Failure!');
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

function ajax_UpdateClassSubject(var_ClassSubjectID, var_Subject, var_Teacher, var_AffectedTerms)
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

      sent_AffectedTerms: var_AffectedTerms
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
            action: "21",
            sent_ClassID: var_ClassID
        },
        dataType: 'json', 
        cache: false
    });    
    request.done(function(result) 
    {
      header.innerHTML = "List of Registered Subjects for Section <b>" + result["sectionName"] + "</b> in SY <b>" + result["schoolYear"] + "</b>";
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
              action: "22",
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
                action : "23",
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
