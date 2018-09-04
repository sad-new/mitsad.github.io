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

            case '11' : loadGradeLevelsAndSectionCount();break;
            case '12' : loadSections();break;
	    }
	}



    function checkTableSize()
    {
        $query = 'SELECT COUNT(*) FROM sections';
        $result = mysql_query($query); 
        $tableCount = mysql_fetch_row($result);
        return $tableCount[0];
    }


	//---------------------------------------------------------------------------
	// 2   A D D   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function addNewSection()
	{
		$capturedSectionNameData = $_POST['sendSectionNameData'];
		$capturedSectionGradeLevelData = $_POST['sendSectionGradeLevelData'];

		$query = "INSERT INTO sections (sectionName, gradeLevelID_Sections) 
		VALUES (
		'$capturedSectionNameData', 
		'$capturedSectionGradeLevelData')";
		mysql_query($query);

	}



	//RETRIEVE ACCOUNTID OF THE LATEST CREATED ACCOUNT
	function getSectionID()
	{
			$query = 'select sectionID from sections order by sectionID DESC';
			$result = mysql_query($query); 
			$accountID = mysql_fetch_row($result);
			return $sectionID[0];
	}



	//---------------------------------------------------------------------------
	// 3   R E T R I E V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function retrieveSection()
	{
		$capturedSectionID = $_POST['sendSectionID'];

		$query = "SELECT * FROM sections WHERE sectionID = '$capturedSectionID'";

		$result = mysql_query($query);
		$returnValue = mysql_fetch_array($result);

		echo json_encode($returnValue);
	}




	//---------------------------------------------------------------------------
	// 4   U P D A T E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function updateSection()
	{

		$capturedSectionID = $_POST['sendSectionID'];
		$capturedSectionNameData = $_POST['sendSectionNameData'];
		$capturedSectionGradeLevelData = $_POST['sendSectionGradeLevelData'];
		

		$query = "UPDATE sections 
		SET 
		gradeLevelID_Sections = '$capturedSectionGradeLevelData',
		sectionName = '$capturedSectionNameData'
		WHERE
		sectionID = '$capturedSectionID';";


		mysql_query($query);
		
	}



	//---------------------------------------------------------------------------
	// 5   R E M O V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function removeSection()
	{
		$capturedSectionID = $_POST['sendSectionID'];

		//remove user from employees and accounts table
		$query = "delete from sections where sectionID = $capturedSectionID";
		mysql_query($query);
		//return 1;

	}



    //---------------------------------------------------------------------------
    // 1 1   L O A D   G R A D E   L E V E L S
    //---------------------------------------------------------------------------
    function loadGradeLevelsAndSectionCount()
    {

		$syTermCountArray = array();

		$query = 
				"SELECT 
					gl.gradeLevelID,
		        	gl.gradeLevelName,
		        	IFNULL(COUNT(s.sectionName), 0) AS 'children'
	    		FROM 
	    			gradeLevels as gl  
    
			    LEFT JOIN 
			    	sections as s  
			    ON s.gradeLevelID_Sections = gl.gradeLevelID
			    GROUP by gl.gradeLevelID";

		$tableQuery = mysql_query($query) 
			or die ("cannot load tables");  


		while($getRow = mysql_fetch_assoc($tableQuery))
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

    	$captured_SectionYearLevel = $_POST['sendGradeLevel'];

        $sectionArray = array();
        $query = "select * from sections
        where gradeLevelID_Sections = $captured_SectionYearLevel 
        ORDER BY sectionID ASC";

        $tableQuery = mysql_query($query) 
            or die ("cannot load tables");  

        while($getRow = mysql_fetch_array($tableQuery))
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