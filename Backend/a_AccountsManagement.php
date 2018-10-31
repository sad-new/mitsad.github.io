<?php

  //  if(!isset($_SESSION)) 
  //  {
	//    session_start();
	//  }

  require_once 'b_ConnectionString.php';


	$teacherArray = array();


	if(isset($_POST['sent_Action']) && 
    !empty($_POST['sent_Action'])) 
  {

    $captured_Action = $_POST['sent_Action'];
    require_once 'b_ConnectionString.php';
    switch($captured_Action) 
    {


  	  case '1' : loadTables();break;
      case '2' : ajax_AddNewTeacher();break;
      case '3' : ajax_RetrieveTeacher();break;
      case '4' : ajax_UpdateTeacher();break;
      case '5' : ajax_RemoveTeacher();break;

      case '11' : ajax_CheckForAccountName_Add();break;
      case '12' : ajax_CheckForAccountName_Edit();break;

      //default : echo 'NOTHING';break;
    }
	}

    //---------------------------------------------------------------------------
    // 0 )   N O N   A J A X   S T U F F
    //---------------------------------------------------------------------------

    //RETRIEVE ACCOUNTID OF THE LATEST CREATED ACCOUNT
    function getAccountID()
    {
      require 'b_ConnectionString.php';

      $query = 'select accountID from accounts order by accountID DESC';
      $result = mysqli_query($mySQL_ConStr, $query); 
      $accountID = mysqli_fetch_row($result);
      return $accountID[0];
    }

    function checkTableSize()
    {
      require 'b_ConnectionString.php';

      $query = 'SELECT COUNT(*) FROM accounts';
      $result = mysqli_query($mySQL_ConStr, $query); 
      $tableCount = mysqli_fetch_row($result);
      return $tableCount[0];
    }


	//---------------------------------------------------------------------------
	// 1 )   L O A D   T A B L E S
	//---------------------------------------------------------------------------
	function loadTables()
	{
    require 'b_ConnectionString.php';

		$query = 
		"select accountID, userName, userType, accountImage, 
		employeeID, employeeName, employeeImage 

		from accounts LEFT JOIN employees 
		on accounts.accountID = employees.accountID_Employees 
		where userType = 'teacher'
    ORDER BY accountID asc";
		
		//$teacherArray = mysql_query($query) 
		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_array($tableQuery))
		{
			//fill one row of the array
			$teacherEntry = array();

			$teacherEntry['accountID']     = $getRow['accountID'];
			$teacherEntry['userName']      = $getRow['userName'];
			$teacherEntry['userType']      = $getRow['userType'];   
			$teacherEntry['accountImage']  = $getRow['accountImage']; 
			$teacherEntry['employeeID']    = $getRow['employeeID']; 
			$teacherEntry['employeeName']  = $getRow['employeeName']; 
			$teacherEntry['employeeImage'] = $getRow['employeeImage']; 

			$teacherArray[] = $teacherEntry;

		}


		return $teacherArray;
	}


	//---------------------------------------------------------------------------
	// 2 )   A D D   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function ajax_AddNewTeacher()
	{
    require 'b_ConnectionString.php';

		$captured_EmployeeName = $_POST['sent_EmployeeName'];
		$captured_UserName = $_POST['sent_UserName'];
		$captured_Password = $_POST['sent_Password'];


		//insert teacher info to accounts table
		$query = "
      INSERT INTO accounts (userName, password, userType) 
		  VALUES ('$captured_UserName', '$captured_Password', 'teacher')";
		mysqli_query($mySQL_ConStr, $query);


		$accountID = getAccountID();

		//insert teacher to employees table
		$query = "
      INSERT INTO employees (accountID_Employees, employeeName) 
		  VALUES ('$accountID', '$captured_EmployeeName');";
		$result = mysqli_query($mySQL_ConStr, $query);

	}


	//---------------------------------------------------------------------------
	// 3 )   R E T R I E V E   T E A C H E R   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function ajax_RetrieveTeacher()
	{
    require 'b_ConnectionString.php';

		$captured_AccountID = $_POST['sent_AccountID'];

		$query = "select accountID, userName, userType, accountImage, password,
		employeeID, employeeName, employeeImage 

		from accounts LEFT JOIN employees 
		on accounts.accountID = employees.accountID_Employees 
		where accountID = $captured_AccountID";

		$result = mysqli_query($mySQL_ConStr, $query);
		$returnValue = mysqli_fetch_array($result);

		echo json_encode($returnValue);


	}




	//---------------------------------------------------------------------------
	// 4 )   U P D A T E   T E A C H E R   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function ajax_UpdateTeacher()
	{
    require 'b_ConnectionString.php';

		$captured_AccountID = $_POST['sent_AccountID'];
		$captured_EmployeeName = $_POST['sent_EmployeeName'];
		$captured_UserName = $_POST['sent_UserName'];
		$captured_Password = $_POST['sent_Password'];

		$query = "UPDATE accounts 
		SET userName = '$captured_UserName',
		password = '$captured_Password'
		WHERE accountID = '$captured_AccountID';";
		
		mysqli_query($mySQL_ConStr, $query);
		
		$query = "UPDATE employees 
		SET employeeName = '$captured_EmployeeName'
		where accountID_Employees = '$captured_AccountID';";


		mysqli_query($mySQL_ConStr, $query);
	}



	//---------------------------------------------------------------------------
	// 5 )   R E M O V E   T E A C H E R   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function ajax_RemoveTeacher()
	{
    require 'b_ConnectionString.php';

		$captured_AccountID = $_POST['sent_AccountID'];

		//remove user from employees and accounts table
		$query = 
                "delete from employees 
                where accountID_Employees = $captured_AccountID";
		mysqli_query($mySQL_ConStr, $query);
		$query = "delete from accounts where accountID = $captured_AccountID";
		mysqli_query($mySQL_ConStr, $query);

		//return 1;

	}






	//---------------------------------------------------------------------------
	// 1 1 )   I N C L U S I V E   O F   C U R R E N T   U S E R N A M E
	//---------------------------------------------------------------------------
	function ajax_CheckForAccountName_Add()
	{
    require 'b_ConnectionString.php';

    $captured_UserName = $_POST['sent_UserName'];

 		$query = "SELECT EXISTS (SELECT * from accounts 
            where username = '$captured_UserName')
            as ifExists";
 		
        $result = mysqli_query($mySQL_ConStr, $query);
        $returnValue = mysqli_fetch_array($result);

 		echo json_encode($returnValue);
	}

  //---------------------------------------------------------------------------
  // 1 2 )   E X C L U S I V E   O F   C U U R E N T   U S E R N A M E
  //---------------------------------------------------------------------------
  function ajax_CheckForAccountName_Edit()
  {
    require 'b_ConnectionString.php';

    $captured_AccountID = $_POST['sent_AccountID'];
    $captured_UserName = $_POST['sent_UserName'];

    $query = "SELECT EXISTS (SELECT * from accounts where 
    username = '$captured_UserName' and 
    accountID != '$captured_AccountID') 
    as ifExists";

    $result = mysqli_query($mySQL_ConStr, $query);
    $returnValue = mysqli_fetch_array($result);

    echo json_encode($returnValue);
  }


?>