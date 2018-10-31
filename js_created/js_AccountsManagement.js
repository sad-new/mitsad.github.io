
function object_Account()
{
    var accountID = "0";
    var employeeName = "";
    var userName = "";
    var password = "";


    this.setVariables = function(set_AccountID, set_EmployeeName, set_UserName, set_Password)
    {
        accountID = set_AccountID;
        employeeName = set_EmployeeName;
        userName = set_UserName;
        password = set_Password;
    };

    this.getVariables = function()
    {
        var accountDetails = new Object();

        accountDetails["accountID"] = accountID;
        accountDetails["employeeName"] = employeeName;
        accountDetails["userName"] = userName;  
        accountDetails["password"] = password;

        return accountDetails;
    };

    this.purgeVariables = function()
    {
        accountID = "0";
        employeeName = "";
        userName = "";
        password = "";      
    };
}

$(document).ready(function() 
{

  var obj_AccountObject = new object_Account();

  //---------------------------------------------------------------------------
  // A D D
  //---------------------------------------------------------------------------

	$('#button_Main_Add').click(function(e) 
	{	

    obj_AccountObject.purgeVariables();  
		$('#addModalResponse').empty(); 
	});

	$('#button_AddModal_Add').click(function(e) 
	{

    checkAddModal();
	});



    //---------------------------------------------------------------------------
    // E D I T
    //---------------------------------------------------------------------------

	$('.button_Table_Edit').click(function(e) 
	{	
    fillEditModal(this.value, obj_AccountObject);
	});



	$('#button_EditModal_Update').click(function(e) 
	{ 
    checkEditModal(obj_AccountObject);

	});  



    //---------------------------------------------------------------------------
    // D E L E T E 
    //---------------------------------------------------------------------------

	$('.button_Table_Delete').click(function(e) 
	{
        //set obj_AccountObject
        obj_AccountObject.setVariables
        (
            this.value,
            "",
            "",
            ""
        );  
	});

	$('#button_DeleteModal_Delete').click(function(e) 
	{
		ajax_DeleteAccount(obj_AccountObject.getVariables()["accountID"]);
	});
});


//---------------------------------------------------------------------------
// N O N   A J A X   F X N
//---------------------------------------------------------------------------



async function checkAddModal()
{
    var employeeName = $('#addModal_TextBox_EmployeeName').val();
    var userName = $('#addModal_TextBox_UserName').val();
    var password = $('#addModal_TextBox_Password').val();   

    await checkModalForErrors('add', '0', employeeName, userName, password)
    .then(function(result)
    {
      if (result != '') 
      {
        $('form #addModal_Response').removeClass().addClass('error')
          .html('<strong>Please correct the errors below.</strong>' + result ).fadeIn('fast'); 
      }

      else
      {
        ajax_AddAccount(employeeName, userName, password)
      }
    });
}



async function checkEditModal(obj_AccountObject)
{
    var accountID = obj_AccountObject.getVariables()["accountID"];

    alert(accountID);

    var employeeName = $('#editModal_TextBox_EmployeeName').val();
    var userName = $('#editModal_TextBox_UserName').val();
    var password = $('#editModal_TextBox_Password').val();  

    await checkModalForErrors('edit', accountID, employeeName, userName, password)
    .then(function(result)
    {
      if (result != '') 
      {
        $('form #editModal_Response').removeClass().addClass('error')
            .html('<strong>Please correct the errors below.</strong>' + result ).fadeIn('fast');   
      }

      else
      {   
          ajax_UpdateAccount(accountID, employeeName, userName, password);
      }
    });
}



async function fillEditModal(accountID, obj_AccountObject)
{ 

    await ajax_RetrieveAccount(accountID)
    .then(function(result)
    {
        //set obj_AccountObject
        obj_AccountObject.setVariables
        (
            accountID,
            result['employeeName'],
            result['userName'],
            result['password']
        );    

        //set textboxes
        $(".form-group #editModal_TextBox_EmployeeName").val(result['employeeName']);
        $(".form-group #editModal_TextBox_UserName").val(result['userName']);
        $(".form-group #editModal_TextBox_Password").val(result['password']);        
    }); 

    $('#editModalResponse').empty();  
}





async function checkModalForErrors(action, accountID, employeeName, userName, password)
{
    var isValid = '';
    var isRequired = ' is required.';  
    var isTaken = '" is already taken.';

    if (employeeName == '' || employeeName <= 1) 
    { isValid += '</br>Your Name' + isRequired; }

    if (userName == '' || userName <= 1) 
    { isValid += '</br>Your Username' + isRequired; }
    
    else
    {
        await ajax_CheckUserNameIfExists(
          action, accountID, userName)
        .then(function(result)
        {
            if ((result != null)&&(result == 1))
            {
                isValid += '</br> the Username "' 
                  + userName + isTaken;
            }
        });
    }

    if (password == '' ) 
    {
        isValid += '</br>Your Password' + isRequired;   
    }

    return isValid;
}


//---------------------------------------------------------------------------
// A J A X   C A L L S
//---------------------------------------------------------------------------




function ajax_AddAccount(employeeName, userName, password) 
{
  return promise = new Promise((resolve, reject) =>
  {
  	var request = $.ajax({	
      	type: 'POST',
      	url:$(this).attr("action"),		
      	data: 
      	{
      		sent_Action: "2",
      		sent_EmployeeName: employeeName,
      		sent_UserName: userName,
      		sent_Password: password
      	},
      	dataType: 'text',
      	cache: false
      });
      
      request.done(function(data) 
      { 
         alert('User Created!'); 
         location.reload();
         resolve();
      });

      request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
      {
          alert('Error in User Creation!');           
          reject('Error in User Creation!');
      });

      request.always(function(XMLHttpRequest, status) 
      {           
          //location.reload();
      });
  });
};


function ajax_RetrieveAccount(accountID)
{

  return promise = new Promise((resolve, reject) =>
  {
    var request = $.ajax({	
		type: 'POST',
		url: 'Backend/a_AccountsManagement.php',
		data: 
		{
			sent_Action: "3",
			sent_AccountID : accountID
		},
		dataType: 'json',
		cache: false
    });
		
    request.done(function(data) 
		{ 
      var accountDetails = 
      {
          employeeName : data['employeeName'],
          userName : data['userName'],
          password : data['password']
      };

      resolve(accountDetails);
		});

		request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
		{
			alert('Error in Retrieving Teacher Info!'); 		
      reject(errorThrown);
		});

	});	
};


function ajax_UpdateAccount(accountID, employeeName, userName, password)
{

   alert(accountID); 
	$.ajax({		
		type: 'POST',
		//url:$(this).attr("action"),	
		url: 'Backend/a_AccountsManagement.php',
		data: 
		{
			sent_Action: "4",
			sent_AccountID: accountID,
			sent_EmployeeName: employeeName,
			sent_UserName: userName,
			sent_Password: password
		},

		dataType: 'text',
		cache: false,

		success: function(data) 
		{ 
			alert('Updated Teacher Info!'); 
		},

		error: function(data, XMLHttpRequest, textStatus, errorThrown) 
		{
			alert('Error in Updating Teacher Info!'); 		
		},
		
		complete: function(XMLHttpRequest, status) 
		{ 	
		 	location.reload();
		}
	});
};


function ajax_DeleteAccount(accountID)
{
	$.ajax({		
		type: 'POST',
		//url:$(this).attr("action"),	
		url: 'Backend/a_AccountsManagement.php',
		data: 
		{
			sent_Action: "5",
			sent_AccountID: accountID
		},

		dataType: 'text',
		cache: false,

		success: function(data) 
		{ 
			alert('Successfully deleted the entry!'); 
		},

		error: function(data, XMLHttpRequest, textStatus, errorThrown) 
		{
			alert('Error in Deleting account Entry!'); 		
		},

		//complete. refresh the page.
		complete: function(XMLHttpRequest, status) 
		{ 	
		 	location.reload();
		}
		
	});	
};

function ajax_CheckUserNameIfExists(action, accountID, userName)
{
    var actionToBeDone = "";  

    switch (action)
    {
        case "add":  
            actionToBeDone = '11';  
            break;  
        case "edit":
            actionToBeDone = '12';
            break;
    }

  return promise = new Promise((resolve, reject) =>
  {
    var request = $.ajax({
        type: 'POST',
        url: 'Backend/a_AccountsManagement.php',
        data: 
        {
            sent_Action : actionToBeDone,
            sent_AccountID : accountID,
            sent_UserName : userName
        },

        dataType: 'json',
        cache: false,
    });

    request.done(function(data) 
    {
        resolve(data['ifExists']);
    });

    request.fail(function(XMLHttpRequest, textStatus, errorThrown) 
    {    
        console.log(errorThrown);
        reject();    
    }); 
  });
}
