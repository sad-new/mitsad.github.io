<?php

 //    if(!isset($_SESSION)) {
	// 	session_start();
	// }

include 'b_ConnectionString.php';

	//array that holds thae data for the chart that will apeear.
	$sectionArray = array();


	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
	    switch($action) 
	    {
	        case '2' : addNewSection();break;
	        case '3' : retrieveSection();break;
	        case '4' : updateSection();break;
	        case '5' : removeSection();break;
	        //default : echo 'NOTHING';break;

	       	case '7' : checkNewEntryForExistence();break;
	        case '8' : checkExistingEntry();break;

            case '11' : loadGradeLevelsAndSectionCount();break;
            case '12' : loadSections();break;
	    }
	}



    function checkTableSize()
    {
      require 'b_ConnectionString.php';

      $query = 'SELECT COUNT(*) FROM sections';
      $result = mysqli_query($mySQL_ConStr, $query); 
      $tableCount = mysqli_fetch_row($result);
      return $tableCount[0];
    }


	//---------------------------------------------------------------------------
	// 2   A D D   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function addNewSection()
	{
    require 'b_ConnectionString.php';

		$capturedSectionNameData = $_POST['sendSectionNameData'];
		$capturedSectionGradeLevelData = $_POST['sendSectionGradeLevelData'];

		$query = "INSERT INTO sections (sectionName, gradeLevelID_Sections) 
		VALUES (
		'$capturedSectionNameData', 
		'$capturedSectionGradeLevelData')";
		mysqli_query($mySQL_ConStr, $query);

	}



	//RETRIEVE ACCOUNTID OF THE LATEST CREATED ACCOUNT
	function getSectionID()
	{
    require 'b_ConnectionString.php';

		$query = 'select sectionID from sections order by sectionID DESC';
		$result = mysqli_query($mySQL_ConStr, $query); 
		$accountID = mysqli_fetch_row($result);
		return $sectionID[0];
	}



	//---------------------------------------------------------------------------
	// 3   R E T R I E V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function retrieveSection()
	{
    require 'b_ConnectionString.php';

		$capturedSectionID = $_POST['sendSectionID'];
		$query = "SELECT * FROM sections WHERE sectionID = '$capturedSectionID'";

		$result = mysqli_query($mySQL_ConStr, $query);
		$returnValue = mysqli_fetch_array($result);

		echo json_encode($returnValue);
	}




	//---------------------------------------------------------------------------
	// 4   U P D A T E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function updateSection()
	{
    require 'b_ConnectionString.php';

		$capturedSectionID = $_POST['sendSectionID'];
		$capturedSectionNameData = $_POST['sendSectionNameData'];
		$capturedSectionGradeLevelData = $_POST['sendSectionGradeLevelData'];
		

		$query = "UPDATE sections 
		SET 
		gradeLevelID_Sections = '$capturedSectionGradeLevelData',
		sectionName = '$capturedSectionNameData'
		WHERE
		sectionID = '$capturedSectionID';";


		mysqli_query($mySQL_ConStr, $query);
		
	}



	//---------------------------------------------------------------------------
	// 5   R E M O V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function removeSection()
	{
    require 'b_ConnectionString.php';

		$capturedSectionID = $_POST['sendSectionID'];

		$query = "delete from sections where sectionID = $capturedSectionID";
		mysqli_query($mySQL_ConStr, $query);
		//return 1;

	}




	// 7

	function checkNewEntryForExistence()
	{
		
	    require 'b_ConnectionString.php';

		$capturedGradeLevelID = $_POST['sendGradeLevelID'];
		$capturedSectionName = $_POST['sendSectionName'];


	    $query =
	    	"SELECT 1 as 'exists' FROM sections 
		    WHERE 
		    (gradeLevelID_Sections = '$capturedGradeLevelID') AND 
			(SectionName = '$capturedSectionName') LIMIT 1";


	    $result = mysqli_query($mySQL_ConStr, $query);
	    $returnValue = mysqli_fetch_array($result);

    	echo json_encode($returnValue['exists']);   
	}


	// 8

	function checkExistingEntry()
	{
		
	    require 'b_ConnectionString.php';

	    $capturedSectionID = $_POST['sendSectionID'];
		$capturedGradeLevelID = $_POST['sendGradeLevelID'];
		$capturedSectionName = $_POST['sendSectionName'];


	    $query =
	    	"SELECT 1 as 'exists' FROM Sections 
		    WHERE 
		    (sectionID != '$capturedSectionID') AND
		    (gradeLevelID_Sections = '$capturedGradeLevelID') AND 
			(sectionName = '$capturedSectionName')
			LIMIT 1";


	    $result = mysqli_query($mySQL_ConStr, $query);
	    $returnValue = mysqli_fetch_array($result);

    	echo json_encode($returnValue['exists']);   
	}


    //---------------------------------------------------------------------------
    // 1 1   L O A D   G R A D E   L E V E L S
    //---------------------------------------------------------------------------
    function loadGradeLevelsAndSectionCount()
    {

      require 'b_ConnectionString.php';

  		$syTermCountArray = array();

  		$query = 
  				"SELECT 
  					gl.gradeLevelID,
  		        	gl.gradeLevelName,
  		        	IFNULL(COUNT(s.sectionName), 0) AS 'children'
  	    		FROM 
  	    			gradelevels as gl  
      
  			    LEFT JOIN 
  			    	sections as s  
  			    ON s.gradeLevelID_Sections = gl.gradeLevelID
  			    GROUP by gl.gradeLevelID";

  		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
  			or die ("cannot load tables");  


  		while($getRow = mysqli_fetch_assoc($tableQuery))
  		{
  			$syTermCountArray[] = $getRow;
  		}

  		echo json_encode($syTermCountArray);
    }


    //---------------------------------------------------------------------------
    // 1 2   L O A D   S U B J E C T S
    //---------------------------------------------------------------------------
    function loadSections()
    {
      require 'b_ConnectionString.php';

    	$captured_SectionYearLevel = $_POST['sendGradeLevel'];

        $sectionArray = array();
        $query = "select * from sections
        where gradeLevelID_Sections = $captured_SectionYearLevel 
        ORDER BY sectionID ASC";

        $tableQuery = mysqli_query($mySQL_ConStr, $query) 
            or die ("cannot load tables");  

        while($getRow = mysqli_fetch_array($tableQuery))
        {  
            $sectionArray[] = $getRow;
        }

        echo json_encode($sectionArray);
    }






	//---------------------------------------------------------------------------
	// ****uNIMPLEMENTED YET (CHECK FOR USER EXISTENCE)
	//---------------------------------------------------------------------------
	function checkForUser($capturedUserNameData, $capturedPassData)
	{
 		$query = "SELECT EXISTS (SELECT * from accounts where username = '$capturedUserNameData' and password = '$capturedPassData')";
 		$result = mysql_query($query);

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