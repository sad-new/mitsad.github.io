<?php

include 'b_ConnectionString.php';



	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
	    switch($action) 
	    {
	    	case '1' : loadEmployeeInfo();break;
	    	case '2' : getEmployeeInfo();break;
	        case '3' : updateEmployeeInfo();break;
	        //default : echo 'NOTHING';break;
	    }
	}

	function loadEmployeeInfo($accountID)
	{
		$employeeInfo = [];

		$query = "select * from employees LEFT JOIN accounts on accounts.accountID = employees.accountID_Employees where accountID_Employees = " . $accountID;

		$tableQuery = mysql_query($query) 
		or die ("cannot load tables");  

		while($getRow = mysql_fetch_assoc($tableQuery))
		{
			$employeeInfo = $getRow;
		}

		return $employeeInfo;
	}



	function getEmployeeInfo()
	{
		$capturedAccountID = $_POST['sentAccountID'];  
		$employeeInfo = loadEmployeeInfo($capturedAccountID);

		echo json_encode($employeeInfo);

	}



	function updateEmployeeInfo()
	{

		$capturedAccountID = $_POST['sentAccountID'];  

		$capturedEmployeeName = $_POST['sentEmployeeName'];  
		$capturedEmployeeAddress = $_POST['sentEmployeeAddress'];
		$capturedEmployeeContactNumber = $_POST['sentEmployeeContactNumber'];
		$capturedEmployeeEmail = $_POST['sentEmployeeEmail'];
		
		$capturedUserName = $_POST['sentUserName'];
		$capturedPassword = $_POST['sentPassword'];


		$query = "SELECT count(*) FROM `employees` WHERE accountID_Employees = " . $sentAccountID;
		$result = mysql_query($query); 


		if(mysql_fetch_array($result) !== 0)
		{
			$query = 
			"UPDATE employees
			set
				employeeName = '$capturedEmployeeName', 
				employeeAddress = '$capturedEmployeeAddress', 
				employeePhoneNumber = '$capturedEmployeeContactNumber', 
				employeeEmail = '$capturedEmployeeEmail'
			where 
				accountID_Employees = '$capturedAccountID'";  

			mysql_query($query); 

			$query = 
			"UPDATE accounts
			set
				userName = '$capturedUserName',
				password = '$capturedPassword'
			where
				accountID = '$capturedAccountID'";  

			mysql_query($query); 
		}

	}

?>