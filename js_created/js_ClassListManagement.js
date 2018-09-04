
function object_Class()
{
  var classID = "";

  this.setClassID = function(var_ClassID)
  {
    classID = var_ClassID;
  };

  this.getClassID = function()
  {
    return classID;
  }

}

function object_ClassStudentEntry()
{
  var studentLRN = ""; 
  var studentName = ""; 
  var studentGender = ""; 
}

$(document).ready(function() 
{
  
  classStudentEntryArray = [];

  object_Class = new object_Class();

  let urlParams = new URLSearchParams(window.location.search);
  object_Class.setClassID(urlParams.get('ID'));

  var replacementEntries = [];

  ajax_LoadClassDetails(object_Class.getClassID());
  loadClassListTable(object_Class.getClassID());


  //capture CSV
  document.getElementById('fileCSV').onchange = function()
  {
    var file = this.files[0];
    loadCSVAndSecondaryTable(file)
    .then(function(result)
    {
      classStudentEntryArray = result; 
      alert(classStudentEntryArray + " here");
    });
  }



  $(document).on("click", "#button_Main_UploadList", function()
  {
    ajax_UploadClassListEntries(object_Class.getClassID(), classStudentEntryArray);
  });

  $(document).on("click", "#button_Main_Cancel", function()
  {
    document.getElementById("fileCSV").value = "";    
    classStudentEntryArray = [];
    document.getElementById("secondaryTableContainer").innerHTML = "";

  });

});



async function loadCSVAndSecondaryTable(file)
{

  var reader = new FileReader();
  var studentEntries = [];

  return promise = new Promise((resolve, reject) =>
  {

    reader.onerror = function(e) 
    {
      reader.abort();
      reject(new DOMException("Problem parsing input file."));
    };

    reader.onload = function(e)
    {

      var workBook = XLSX.read(this.result, {type: 'binary'});

      //READ AND PARSE THE FIRST SHEET
      var sheet1 = workBook.Sheets[workBook.SheetNames[0]];
      var XL_Worksheet = XLSX.utils.sheet_to_row_object_array(sheet1);


      //GET ALL THE STUDENT NAMES
      workBook.Sheets[workBook.SheetNames[0]]['!ref'] =  "B10:B58";
      var excelEntries = (XLSX.utils.sheet_to_row_object_array(sheet1, {header:1}));

      for (var i = 0 ; i < excelEntries.length ; i++)
      {
        if (excelEntries[i] != "")
        {
          var studentEntriesRow = []; 

          //STUDENT LRN
          studentEntriesRow.push(excelEntries[i][0]);  


          //GENDER
          workBook.Sheets[workBook.SheetNames[0]]['!ref'] =  "G"+ (10+i);
          var gradeEntries = (XLSX.utils.sheet_to_row_object_array(sheet1, {header:1}));
          studentEntriesRow.push(gradeEntries[0][0]); 


          //STUDENT NAME
          workBook.Sheets[workBook.SheetNames[0]]['!ref'] =  "C"+ (10+i);
          var gradeEntries = (XLSX.utils.sheet_to_row_object_array(sheet1, {header:1}));
          studentEntriesRow.push(gradeEntries[0][0]); 


          studentEntries.push(studentEntriesRow);
        }
      }


      // CREATE TABLE
      var studentEntryColumns = ["Student LRN", "Gender", "Student Name"];
      var tableContainer = document.getElementById("secondaryTableContainer");
      tableContainer.innerHTML = "";

      var table = document.createElement('table');
      table.id = "secondTable";
      table.className = "table"; 
      table.className += " table-bordred";
      table.className += " table-striped";

      var tableHead = document.createElement('thead');
      var tableHeader = document.createElement('tr');

      var tableBody = document.createElement('tbody');

      tableContainer.appendChild(table);
      
      table.appendChild(tableHead).appendChild(tableHeader);
      for (var i = 0; i <  studentEntryColumns.length; i++)
      {
          tableHeader.appendChild(document.createElement('th')).appendChild
          (document.createTextNode(studentEntryColumns[i]));
      }


      table.appendChild(tableBody);
      for (var i = 0; i < studentEntries.length; i++)
      {
        var tableRow = document.createElement('tr');
        tableBody.appendChild(tableRow);

        for (var j = 0; j < studentEntries[i].length ; j++)
        {
            var tableCell = document.createElement('td');
            tableRow.appendChild(tableCell);
            tableCell.appendChild(document.createTextNode(studentEntries[i][j]));
        }
      }


      var paragraph1 = document.createElement('p');
      paragraph1.setAttribute("data-placement","top");
      paragraph1.setAttribute("data-toggle","tooltip"); 
      paragraph1.setAttribute("title","clearFileUpload");

      var button_Main_UploadList = document.createElement('button');
      button_Main_UploadList.setAttribute("class","btn btn-primary");
      button_Main_UploadList.setAttribute("id","button_Main_UploadList"); 
      button_Main_UploadList.setAttribute("data-title","Edit"); 
      var button_Main_UploadList_Text = document.createTextNode("Upload List");

      var paragraph2 = document.createElement('p');
      paragraph2.setAttribute("data-placement","top");
      paragraph2.setAttribute("data-toggle","tooltip"); 
      paragraph2.setAttribute("title","clearFileUpload");

      var button_Main_Cancel = document.createElement('button');
      button_Main_Cancel.setAttribute("class","btn btn-primary");
      button_Main_Cancel.setAttribute("id","button_Main_Cancel"); 
      button_Main_Cancel.setAttribute("data-title","Edit"); 
      var button_Main_Cancel_Text = document.createTextNode("Cancel");

      tableContainer.appendChild(document.createElement('br')); 
      tableContainer.appendChild(document.createElement('br')); 

      tableContainer.appendChild(paragraph1)
      .appendChild(button_Main_UploadList)
      .appendChild(button_Main_UploadList_Text);

      tableContainer.appendChild(paragraph2)
      .appendChild(button_Main_Cancel)
      .appendChild(button_Main_Cancel_Text);

      tableContainer.appendChild(document.createElement('br')); 
      tableContainer.appendChild(document.createElement('br')); 

      resolve(studentEntries);
    };
    
  //DISPLAY ALL

    reader.readAsBinaryString(file);
  });

}

function loadClassListTable(var_ClassID)
{
  var tableContainer = document.getElementById("mainTableContainer");

  ajax_LoadClassListEntries(var_ClassID) 
  .then(function(result)
  {
    tableContainer.innerHTML = "";

    if (result != false)
    {

      var tableHeaderColumns = ['ID', 'Student LRN', 'Gender', 'Student Name']; 
      var arrayColumnNames = ['classStudentID', 'studentLRN', 'studentGender', 'studentName'];


      var table = document.createElement('table');
      table.id = "table";
      table.className = "table"; 
      table.className += " table-bordred";
      table.className += " table-striped";
      tableContainer.appendChild(table);


      var tableHead = document.createElement('thead');
      var tableHeader = document.createElement('tr');        
      table.appendChild(tableHead).appendChild(tableHeader);
      for (var i = 0; i <  tableHeaderColumns.length; i++)
      {
          tableHeader.appendChild(document.createElement('th')).appendChild
          (document.createTextNode(tableHeaderColumns[i]));
      }


      var tableBody = document.createElement('tbody');
      table.appendChild(tableBody);
      for (var i = 0; i < result.length; i++)
      {
        var tableRow = document.createElement('tr');
        
        tableBody.appendChild(tableRow);
        for (var j = 0; j < arrayColumnNames.length; j++)
        {
          var tableCell = document.createElement('td');
          tableRow.appendChild(tableCell);
          tableCell.appendChild(document.createTextNode(result[i][arrayColumnNames[j]]));
        }
      }


    }

    else 
    {
        alert('error here');
    }

  });

} 


function ajax_LoadClassDetails(var_ClassID)
{
  var header = document.getElementById("classListChartName");
  return promise = new Promise((resolve, reject) =>
  {
    $.ajax({    
        type: 'POST',
        url: 'Backend/a_ClassListManagement.php',   
        data: 
        {
            action: "1",
            sent_ClassID : var_ClassID
        },
        dataType: 'json',
        cache: false
    })
    .done(function(result)
    {
      header.innerHTML = "List of Registered Students for Section <b>" + result["sectionName"] + "</b> in SY <b>" + result["schoolYear"] + "</b>";
      resolve();
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) 
    {
      console.log("ERROR in loading Class List Details\n" + errorThrown);
      reject();
    });

  });

}


function ajax_LoadClassListEntries(var_ClassID)
{
  return promise = new Promise((resolve, reject) =>
  {
    $.ajax({    
        type: 'POST',
        url: 'Backend/a_ClassListManagement.php',   
        data: 
        {
            action: "2",
            sent_ClassID : var_ClassID
        },
        dataType: 'json',
        cache: false
    })
    .done(function(result)
    {
      resolve(result);
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) 
    {
      console.log("ERROR in loading Class List Entries\n" + errorThrown);
      reject();
    });

  });

}

function ajax_UploadClassListEntries(var_ClassID, var_ClasslistArray)
{

  alert(var_ClasslistArray + " text");

  return promise = new Promise((resolve, reject) =>
  {
    $.ajax({    
        type: 'POST',
        url: 'Backend/a_ClassListManagement.php',   
        data: 
        {
            action: "3",
            sent_ClassID : var_ClassID,
            sent_ClassListArray : var_ClasslistArray
        },
        dataType: 'json',
        cache: false
    })
    .done(function(result)
    {
      alert('Upload Success!');
      location.reload();
      resolve();
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) 
    {
      console.log("ERROR in uploading Class List Entries\n" + errorThrown);
      reject();
    });

  });  
}