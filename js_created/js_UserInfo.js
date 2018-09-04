$(document).ready(function() 
{

	$('.editEmployeeEntry').click(function(e) 
	{	
		getEmployeeInfo(accountID);
	});


	//the UPDATE in the modal
	$("#updateEditedEmployeeEntry").click(function(e) 
	{ 
		var employeeName = $('#getEmployeeName').val(); 
		var employeeAddress = $('#getEmployeeAddress').val(); 
		var employeeContact = $('#getEmployeeContact').val(); 
		var employeeEmail = $('#getEmployeeEmail').val();

		var userName = $('#getUserName').val(); 
		var password = $('#getPassword').val();

		updateEmployeeInfo(accountID, employeeName, employeeAddress, employeeContact, employeeEmail, userName, password);
	});

});


function getEmployeeInfo(accountID)
{
    alert('asdasd');

	$.ajax({		
		type: 'POST',
		url: 'Backend/a_UserInfo.php',
		data: 
		{
			action : '2',
			sentAccountID : accountID  
		},

		dataType: 'JSON',
		async: false,
		cache: false,

		success: function(data) 
		{ 

			var employeeName = document.getElementById('getEmployeeName');
			var employeeAddress = document.getElementById('getEmployeeAddress');
			var employeeContact = document.getElementById('getEmployeeContact');
			var employeeEmail = document.getElementById('getEmployeeEmail'); 

			var userName = document.getElementById('getUserName'); 
			var password = document.getElementById('getPassword'); 

			employeeName.value = data['employeeName'];
			employeeAddress.value = data['employeeAddress'];
			employeeContact.value = data['employeePhoneNumber'];
			employeeEmail.value = data['employeeEmail'];

			userName.value = data['userName'];
			password.value = data['password'];
		},

		error: function(data, XMLHttpRequest, textStatus, errorThrown) 
		{
			console.log('ERR: cannot retrieve employee Info'); 		
		}
	});

}

function updateEmployeeInfo
(accountID, 
employeeName, employeeAddress, employeeContact, employeeEmail, 
userName, password)
{


	$.ajax({		
		type: 'POST',
		//url:$(this).attr("action"),	
		url: 'Backend/a_UserInfo.php',
		data: 
		{
			action : '3',

			sentAccountID : accountID,  

			sentEmployeeName : employeeName,  
			sentEmployeeAddress : employeeAddress, 
			sentEmployeeContactNumber : employeeContact, 
			sentEmployeeEmail : employeeEmail, 
			
			sentUserName : userName, 
			sentPassword : password 
		},

		dataType: 'text',
		async: false,
		cache: false,

		success: function(data) 
		{ 
			alert('Updated Employee Info');
		},

		error: function(data, XMLHttpRequest, textStatus, errorThrown) 
		{
			console.log('ERR: cannot update employee info'); 		
		},
		
		complete: function(XMLHttpRequest, status) 
		{ 	
		 	location.reload();
		}
	});
}