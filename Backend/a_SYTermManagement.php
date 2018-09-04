<?php

 //    if(!isset($_SESSION)) {
	// 	session_start();
	// }

include 'b_ConnectionString.php';



	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
	    switch($action) 
	    {
	        case '2' : addNewSYTerm();break;

	        case '3' : retrieveSYTerm();break;
	        case '4' : updateSYTerm();break;
	        case '5' : removeSYTerm();break;

            case '7' : checkSYTermForExistence();break;

            case '11' : loadSYTermList();break;
            case '12' : setActiveTerm();break;
			   case '13' : loadYears();break;
	      	case '14' : loadTables();break;
	        //default : echo 'NOTHING';break;
	    }
	}



    function checkTableSize()
    {
        $query = 'SELECT COUNT(*) FROM syTerms';
        $result = mysql_query($query); 
        $tableCount = mysql_fetch_row($result);
        return $tableCount[0];
    }



    function getActiveTerm()
    {
        $activeTermArray = array();
        $query = "SELECT * from syterms WHERE isActive = 1;";
        $tableQuery = mysql_query($query); 

        $activeTermArray = mysql_fetch_assoc($tableQuery);
        return $activeTermArray;
    }


	//---------------------------------------------------------------------------
	// 2   A D D   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function addNewSYTerm()
	{

		$capturedSchoolYearData = $_POST['sendSchoolYearData'];

		for ($counter = 1 ; $counter <= 4 ; $counter++)
		{
			$query = "INSERT INTO syTerms (schoolYear, termNumber, isActive) 
			VALUES ('$capturedSchoolYearData', '" . $counter . "', '0');";

			mysql_query($query);
		}

		autoSetActiveSYTerm();
	}



	function autoSetActiveSYTerm()
	{

		$activeTermArray = array();
        $query = "SELECT * from syterms WHERE isActive = 1;";
        $tableQuery = mysql_query($query); 

        $activeTermArray = mysql_fetch_assoc($tableQuery);



		if (sizeof($activeTermArray) == 1)
		{
			$query = "SELECT * FROM syterms ORDER BY syTermID ASC LIMIT 0, 1;";
			$tableQuery = mysql_query($query);   

			while($getRow = mysql_fetch_assoc($tableQuery))
			{
				$selectedSYTerm = $getRow['syTermID'];
			}

	        $query = 
	        "UPDATE syterms SET isActive = '1' WHERE syTermID = $selectedSYTerm;";
			mysql_query($query);
	        $query = 
	        "UPDATE syterms SET isActive = '0' WHERE syTermID != $selectedSYTerm;";
	        mysql_query($query);
    	}
    	
	}


	//---------------------------------------------------------------------------
	// 3   R E T R I E V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function retrieveSYTerm()
	{
		$capturedSYTermID = $_POST['sendSYTermID'];

		$query = "SELECT * FROM syTerms WHERE syTermID = '$capturedSYTermID'";

		$result = mysql_query($query);
		$returnValue = mysql_fetch_array($result);

		echo json_encode($returnValue);
	}




	//---------------------------------------------------------------------------
	// 4   U P D A T E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function updateSYTerm()
	{

		$capturedIsActiveData   = $_POST['sendIsActiveData'];
		$capturedSYTermIDData   = $_POST['sendSYTermIDData'];

		$query = "UPDATE syTerms 
			SET 
			isActive = '$capturedIsActiveData'
			WHERE
			syTermID = '$capturedSYTermIDData'";


		mysql_query($query);
		
		if ($capturedIsActiveData == '1')
		{
			$query = "UPDATE syTerms 
				SET isActive = '0'
				WHERE
				syTermID != '$capturedSYTermIDData'";


			mysql_query($query);
		}

      autoSetActiveSYTerm();
	}

	//---------------------------------------------------------------------------
	// 5   R E M O V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function removeSYTerm()
	{
		$captured_SchoolYear = $_POST['sendSchoolYear'];

		//remove user from employees and accounts table
		$query = "delete from syTerms where schoolYear = $captured_SchoolYear";
		mysql_query($query);
		//return 1;

		autoSetActiveSYTerm();
	}


    function checkSYTermForExistence()
    {
        $capturedSchoolYear = $_POST['sendSchoolYear'];

        $query = "SELECT 1 FROM syTerms WHERE schoolYear = '$capturedSchoolYear'";

        $result = mysql_query($query);
        $returnValue = mysql_fetch_array($result);

        echo json_encode($returnValue);       
    }


    //---------------------------------------------------------------------------
    // 1 1
    //---------------------------------------------------------------------------


    function loadSYTermList()
    {
        $syTermArray = array();

        $query = "SELECT * FROM syTerms 
        ORDER by schoolYear ASC, termNumber ASC";
        $tableQuery = mysql_query($query) 
            or die ("cannot load tables"); 

        while($getRow = mysql_fetch_assoc($tableQuery))
        {
            $syTermArray[] = $getRow; 
        }

        echo json_encode($syTermArray);
    }


    //---------------------------------------------------------------------------
    // 1 2
    //---------------------------------------------------------------------------

    function setActiveTerm()
    {
        $captured_SYTermID = $_POST['sendSYTermID'];


        $query = "UPDATE syterms SET isActive = '1' 
        WHERE syTermID = $captured_SYTermID;";
        mysql_query($query);

        $query = "UPDATE syterms SET isActive = '0' 
        WHERE syTermID != $captured_SYTermID;";
        mysql_query($query);


        echo json_encode(1);
    }

	//---------------------------------------------------------------------------
	// 1 3   L O A D   Y E A R S
	//---------------------------------------------------------------------------
	function loadYears()
	{
		$schoolYearArray = array();

		$query = "select distinct schoolYear from syterms order by schoolYear ASC";
		$tableQuery = mysql_query($query) 
			or die ("cannot load tables");  

		while($getRow = mysql_fetch_assoc($tableQuery))
		{
			$schoolYearArray[] = $getRow; 
		}
		return $schoolYearArray;
	}


	//---------------------------------------------------------------------------
	// 1 4   L O A D   T A B L E S
	//---------------------------------------------------------------------------
	function loadTerms($captured_SchoolYear)
	{
		$syTermArray = array();

		$query = "select * from syTerms 
				where schoolYear = $captured_SchoolYear
				ORDER BY termNumber ASC";

		$tableQuery = mysql_query($query) 
			or die ("cannot load tables");  

		while($getRow = mysql_fetch_assoc($tableQuery))
		{  
			$syTermArray[] = $getRow; 
		}

		 return $syTermArray;
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