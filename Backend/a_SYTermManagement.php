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
      include "b_ConnectionString.php";

      $query = "SELECT COUNT(*) FROM syterms";
      $result = mysqli_query($mySQL_ConStr, $query); 
      $tableCount = mysqli_fetch_row($result);
      return $tableCount[0];
    }



    function getActiveTerm()
    {
      include 'b_ConnectionString.php';

      $activeTermArray = array();
      $query = "SELECT * from syterms WHERE isActive = 1;";
      $tableQuery = mysqli_query($mySQL_ConStr, $query); 

      $activeTermArray = mysqli_fetch_assoc($tableQuery);
      return $activeTermArray;
    }


	//--------------------------------------------------------------------------
	// 2   A D D   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function addNewSYTerm()
	{
    require 'b_ConnectionString.php';

		$capturedSchoolYearData = $_POST['sendSchoolYearData'];
		for ($counter = 1 ; $counter <= 4 ; $counter++)
		{
			$query = 
				"INSERT INTO syterms (schoolYear, termNumber, isActive) 
				VALUES ('$capturedSchoolYearData', '" . $counter . "', '0');";

			mysqli_query($mySQL_ConStr, $query);
		}

		autoSetActiveSYTerm();
	}


  //SET THE FIRST TERM'S 'ACTIVE TERM' COL TO 1
  //SET EVERY OTHER TERM TO 0
	function autoSetActiveSYTerm()
	{
    require 'b_ConnectionString.php';

		$activeTermArray = array();
    $query = "SELECT * from syterms WHERE isActive = 1;";
    $tableQuery = mysqli_query($mySQL_ConStr, $query); 

    $activeTermArray = mysqli_fetch_assoc($tableQuery);


		if (sizeof($activeTermArray) != 1)
		{
			$query = 
				"SELECT * FROM syterms 
        		ORDER BY schoolYear ASC , termNumber ASC LIMIT 0, 1;";
			$tableQuery = mysqli_query($mySQL_ConStr, $query);   

			while($getRow = mysqli_fetch_assoc($tableQuery))
			{
				$selectedSYTerm = $getRow['syTermID'];
			}

		    $query = 
		    "UPDATE syterms SET isActive = '1' 
	        WHERE syTermID = $selectedSYTerm;";
	      	mysqli_query($mySQL_ConStr, $query);
		        
	      	$query = 
	      	"UPDATE syterms SET isActive = '0' 
	        WHERE syTermID != $selectedSYTerm;";
		    mysqli_query($mySQL_ConStr, $query);
	    }
    	
	}


	//---------------------------------------------------------------------------
	// 3   R E T R I E V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function retrieveSYTerm()
	{
    require 'b_ConnectionString.php';

		$capturedSYTermID = $_POST['sendSYTermID'];

		$query = 
		"SELECT * FROM syterms 
      	WHERE syTermID = '$capturedSYTermID'";

		$result = mysqli_query($mySQL_ConStr, $query);
		$returnValue = mysqli_fetch_array($result);

		echo json_encode($returnValue);
	}




	//---------------------------------------------------------------------------
	// 4   U P D A T E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------
	function updateSYTerm()
	{

    require 'b_ConnectionString.php';

		$capturedIsActiveData   = $_POST['sendIsActiveData'];
		$capturedSYTermIDData   = $_POST['sendSYTermIDData'];

		$query = "UPDATE syterms 
			SET isActive = '$capturedIsActiveData'
			WHERE syTermID = '$capturedSYTermIDData'";

		mysqli_query($mySQL_ConStr, $query);
		
		if ($capturedIsActiveData == '1')
		{
			$query = "UPDATE syterms 
				SET isActive = '0'
				WHERE
				syTermID != '$capturedSYTermIDData'";


			mysqli_query($mySQL_ConStr, $query);
		}

      //autoSetActiveSYTerm();
	}

	//---------------------------------------------------------------------------
	// 5   R E M O V E   S E C T I O N   E N T R Y   ( F R O M   A J A X   C A L L )
	//---------------------------------------------------------------------------	
	function removeSYTerm()
	{
    	require 'b_ConnectionString.php';

		$captured_SchoolYear = $_POST['sendSchoolYear'];

		$query = 
		"DELETE from syterms 
      	WHERE schoolYear = $captured_SchoolYear";
		mysqli_query($mySQL_ConStr, $query);


	    $query = 
	    	"SELECT 1 AS 'exists' FROM syterms 
	      	WHERE isActive = 1 LIMIT 1";
	    $result = mysqli_query($mySQL_ConStr, $query);
	    $returnValue = mysqli_fetch_array($result);

	    autoSetActiveSYTerm();

	    echo json_encode($returnValue);
	}


	// 7
	function checkSYTermForExistence()
	{
	    require 'b_ConnectionString.php';

	    $capturedSchoolYear = $_POST['sendSchoolYear'];

	    $query =
	    	"SELECT 1 as 'exists' FROM syterms 
		    WHERE schoolYear = '$capturedSchoolYear'
		    LIMIT 1";

	    $result = mysqli_query($mySQL_ConStr, $query);
	    $returnValue = mysqli_fetch_array($result);

	    echo json_encode($returnValue['exists']);       
	}



    //---------------------------------------------------------------------------
    // 1 1
    //---------------------------------------------------------------------------


    function loadSYTermList()
    {
      require 'b_ConnectionString.php';

      $activeTermData = array();

      $query = 
      	"SELECT * FROM syterms 
        ORDER by schoolYear ASC, termNumber ASC";
      $tableQuery = mysqli_query($mySQL_ConStr, $query) 
          or die ("cannot load tables"); 

      $syTermArray = array();
      while($getRow = mysqli_fetch_assoc($tableQuery))
      {
        $syTermArray[] = $getRow; 
      }
      $activeTermData[] = $syTermArray;




      $query = 
      	"SELECT syTermID from syterms 
        WHERE isActive = 1";
      $tableQuery = mysqli_query($mySQL_ConStr, $query);
      $activeTerm = mysqli_fetch_assoc($tableQuery);
      $activeTermData[] = $activeTerm;






      echo json_encode($activeTermData);
    }


    //---------------------------------------------------------------------------
    // 1 2
    //---------------------------------------------------------------------------

    function setActiveTerm()
    {
      require 'b_ConnectionString.php';

      $captured_SYTermID = $_POST['sendSYTermID'];


      $query = "UPDATE syterms SET isActive = '1' 
      WHERE syTermID = $captured_SYTermID;";
      mysqli_query($mySQL_ConStr, $query);

      $query = "UPDATE syterms SET isActive = '0' 
      WHERE syTermID != $captured_SYTermID;";
      mysqli_query($mySQL_ConStr, $query);


      echo json_encode(true);
    }

	//---------------------------------------------------------------------------
	// 1 3   L O A D   Y E A R S
	//---------------------------------------------------------------------------
	function loadYears()
	{
    include 'b_ConnectionString.php';

		$schoolYearArray = array();

		$query = 
		"select distinct schoolYear from syterms 
      order by schoolYear ASC";
		
    $tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_assoc($tableQuery))
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
    include 'b_ConnectionString.php';

		$syTermArray = array();

		$query = 
			"select * from syterms 
			where schoolYear = $captured_SchoolYear
			ORDER BY termNumber ASC";

		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_assoc($tableQuery))
		{  
			$syTermArray[] = $getRow; 
		}

		 return $syTermArray;
	}



?>