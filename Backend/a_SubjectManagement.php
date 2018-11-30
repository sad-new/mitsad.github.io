<?php

 //    if(!isset($_SESSION)) {
	// 	session_start();
	// }

include 'b_ConnectionString.php';

	//array that holds thae data for the chart that will apeear.
	$subjectArray = array();


	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
	    switch($action) 
	    {
	        case '2' : addNewSubject();break;
	        case '3' : retrieveSubject();break;
	        case '4' : updateSubject();break;
	        case '5' : removeSubject();break;
	        
	        case '7' : checkNewEntryForExistence();break;
	        case '8' : checkExistingEntry();break;

	        case '11' : loadGradeLevelsAndSubjectCount();break;
	        case '12' : loadSubjects();break;
	    }
	}



    function checkTableSize()
    {
      require 'b_ConnectionString.php';

      $query = "SELECT COUNT(*) FROM subjects";
      $result = mysqli_query($mySQL_ConStr, $query); 
      $tableCount = mysqli_fetch_row($result);
      return $tableCount[0];
    }


	//---------------------------------------------------------------------------
	// 2   A D D   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function addNewSubject()
	{
    require 'b_ConnectionString.php';

		$capturedSubjectNameData = $_POST['sendSubjectNameData'];
		$capturedSubjectGradeLevelData = $_POST['sendSubjectGradeLevelData'];

		$query = "INSERT INTO subjects (subjectName, gradeLevelID_Subjects) 
		VALUES (
		'$capturedSubjectNameData', 
		'$capturedSubjectGradeLevelData')";
		mysqli_query($mySQL_ConStr, $query);

	}



	//RETRIEVE ACCOUNTID OF THE LATEST CREATED ACCOUNT
	function getSectionID()
	{
    require 'b_ConnectionString.php';

			$query = "select sectionID from sections order by sectionID DESC";
			$result = mysqli_query($mySQL_ConStr, $query); 
			$accountID = mysqli_fetch_row($result);
			return $sectionID[0];
	}



	//---------------------------------------------------------------------------
	// 3   R E T R I E V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function retrieveSubject()
	{
    require 'b_ConnectionString.php';

		$capturedSubjectID = $_POST['sendSubjectID'];

		$query = "SELECT * FROM subjects WHERE subjectID = '$capturedSubjectID'";

		$result = mysqli_query($mySQL_ConStr, $query);
		$returnValue = mysqli_fetch_array($result);

		echo json_encode($returnValue);
	}




	//---------------------------------------------------------------------------
	// 4   U P D A T E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function updateSubject()
	{  
    require 'b_ConnectionString.php';
		
   	 $capturedSubjectID = $_POST['sendSubjectID'];
		$capturedSubjectNameData = $_POST['sendSubjectNameData'];
		$capturedSubjectGradeLevelData = $_POST['sendSubjectGradeLevelData'];
		

		$query = 
		"UPDATE subjects 
		SET 
		gradeLevelID_Subjects = '$capturedSubjectGradeLevelData',
		subjectName = '$capturedSubjectNameData'
		WHERE
		subjectID = '$capturedSubjectID'";


		mysqli_query($mySQL_ConStr, $query);
		
	}



	//---------------------------------------------------------------------------
	// 5   R E M O V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function removeSubject()
	{

    	require 'b_ConnectionString.php';

		$capturedSubjectID = $_POST['sendSubjectID'];

		//remove user from employees and accounts table
		$query = "delete from subjects where subjectID = $capturedSubjectID";
		mysqli_query($mySQL_ConStr, $query);
		//return 1;

	}



	// 7

	function checkNewEntryForExistence()
	{
		
	    require 'b_ConnectionString.php';

		$capturedGradeLevelID = $_POST['sendGradeLevelID'];
		$capturedSubjectName = $_POST['sendSubjectName'];


	    $query =
	    	"SELECT 1 as 'exists' FROM subjects 
		    WHERE 
		    (gradeLevelID_Subjects = '$capturedGradeLevelID') AND 
			(subjectName = '$capturedSubjectName') LIMIT 1";


	    $result = mysqli_query($mySQL_ConStr, $query);
	    $returnValue = mysqli_fetch_array($result);

    	echo json_encode($returnValue['exists']);   
	}


	// 8

	function checkExistingEntry()
	{
		
	    require 'b_ConnectionString.php';

	    $capturedSubjectID = $_POST['sendSubjectID'];
		$capturedGradeLevelID = $_POST['sendGradeLevelID'];
		$capturedSubjectName = $_POST['sendSubjectName'];


	    $query =
	    	"SELECT 1 as 'exists' FROM subjects 
		    WHERE 
		    (subjectID != '$capturedSubjectID') AND
		    (gradeLevelID_Subjects = '$capturedGradeLevelID') AND 
			(subjectName = '$capturedSubjectName')
			LIMIT 1";


	    $result = mysqli_query($mySQL_ConStr, $query);
	    $returnValue = mysqli_fetch_array($result);

    	echo json_encode($returnValue['exists']);   
	}

    //---------------------------------------------------------------------------
    // 1 1   L O A D   G R A D E   L E V E L S
    //---------------------------------------------------------------------------
    function loadGradeLevelsAndSubjectCount()
    {

      require 'b_ConnectionString.php';

  		$syTermCountArray = array();

  		$query = 
  		"SELECT 
			gl.gradeLevelID,
	      	gl.gradeLevelName,
	      	IFNULL(COUNT(s.subjectName), 0) AS 'children'
    		FROM 
    			gradelevels as gl  
  
		    LEFT JOIN 
		    	subjects as s  
		    ON s.gradeLevelID_Subjects = gl.gradeLevelID
		    GROUP by gl.gradeLevelID";

  		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
  			or die ("cannot load tables");  


  		while($getRow = mysqli_fetch_array($tableQuery))
  		{
  			$syTermCountArray[] = $getRow;
  		}

  		echo json_encode($syTermCountArray);
    }


    //---------------------------------------------------------------------------
    // 1 2   L O A D   S U B J E C T S
    //---------------------------------------------------------------------------
    function loadSubjects()
    {

      require 'b_ConnectionString.php';

    	$captured_SubjectYearLevel = $_POST['sendGradeLevel'];

        $subjectArray = array();
        $query = "select * from subjects
        where gradeLevelID_Subjects = $captured_SubjectYearLevel 
        ORDER BY subjectID ASC";

        $tableQuery = mysqli_query($mySQL_ConStr, $query) 
            or die ("cannot load tables");  

        while($getRow = mysqli_fetch_array($tableQuery))
        {  
            $subjectArray[] = $getRow;
        }

        echo json_encode($subjectArray);
    }






	//---------------------------------------------------------------------------
	// ****uNIMPLEMENTED YET (CHECK FOR USER EXISTENCE)
	//---------------------------------------------------------------------------
	function checkForUser($capturedUserNameData, $capturedPassData)
	{
    require 'b_ConnectionString.php';


 		$query = 
 		"SELECT EXISTS (SELECT * from accounts 
 		where username = '$capturedUserNameData' 
 		and password = '$capturedPassData')";
 		$result = mysqli_query($query);

 		//account exists.
 		if ($result)
 		{
 			$returnValue = "ISFOUND"; //FOUND
 		}

 		//account is missing.
 		else
 		{
 			$returnValue = "ISNOTFOUND"; //NOT FOUND
 		}

 		return $returnValue;
	}

?>