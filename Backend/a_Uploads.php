<?php

 //    if(!isset($_SESSION)) {
	// 	session_start();
	// }

include 'b_ConnectionString.php';


	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) 
	{
    $action = $_POST['action'];
	    switch($action) 
	    {
        case '1' : getActiveTerm();break;
        case '2' : loadDropDown();break;
	    	case '3' : uploadCSVTable();break;
	    }
	}





  // 1
  function getActiveTerm()
  {
      $activeTermArray = array();
      $query = "SELECT * from syterms WHERE isActive = 1;";
      $tableQuery = mysql_query($query); 

      $activeTermArray = mysql_fetch_assoc($tableQuery);
      echo json_encode($activeTermArray);
  }


  // 2
  function loadDropDown()
  {

    $capturedSYTerm        = $_POST['sendSYTerm'];
    $capturedUserType      = $_POST['sendUserType'];
    $capturedAccountNumber = $_POST['sendAccountID'];  


    $classArray = array();

    $query = 
      'SELECT * FROM classes INNER JOIN sections 
      ON classes.sectionID_Classes = sections.sectionID
      INNER JOIN
        (SELECT  subjectID, subjectName FROM subjects) AS J1 
        ON classes.subjectID_Classes = J1.subjectID
      INNER JOIN
        (SELECT employeeID, employeeName FROM employees) AS J2
        ON classes.adviserID_Classes = J2.employeeID
      INNER JOIN
        (SELECT syTermID, schoolYear, termNumber FROM syTerms) AS J3
        ON classes.syTermID_Classes = J3.syTermID
      INNER JOIN
        (SELECT employeeID, accountID_Employees from employees) as J4
        ON classes.adviserID_Classes = J4.employeeID
      INNER JOIN
        (SELECT gradeLevelID, gradeLevelName from gradeLevels) as J5
        ON sections.gradeLevelID_Sections = J5.gradeLevelID
      ';

      if ($capturedUserType != 'schoolAdministrator')
      {
        $query .= ' AND J4.accountID_Employees = '.$capturedAccountNumber;
      }


    $tableQuery = mysql_query($query) 
      or die ("cannot load tables");  

    while($getRow = mysql_fetch_assoc($tableQuery))
    {
      
      $classEntry = array();

      $classEntry['classID']     = $getRow['classID'];

      $classEntry['syTermID']     = $getRow['syTermID'];
      // $classEntry['schoolYear']     = $getRow['schoolYear'];
      // $classEntry['termNumber']     = $getRow['termNumber'];

      $classEntry['sectionID']     = $getRow['sectionID'];
      $classEntry['sectionName']   = $getRow['sectionName'];
      $classEntry['gradeLevelID_Sections']   = $getRow['gradeLevelID_Sections'];
      $classEntry['gradeLevelName'] = $getRow['gradeLevelName'];

      $classEntry['subjectID']   = $getRow['subjectID'];
      $classEntry['subjectName']   = $getRow['subjectName'];

      $classEntry['employeeID']  = $getRow['employeeID'];
      $classEntry['employeeName']  = $getRow['employeeName'];

      $classArray[] = $classEntry;
    }

    echo json_encode($classArray);
  }


  // 3
	function uploadCSVTable()
	{


    $property = "max_input_vars";
    $propertyValue = 20000;
    ini_set ( $property, $propertyValue );

    //capture the entries
    $capturedCSVArray   = $_POST['sendCSVArray'];
    $capturedClass      = $_POST['sendSelectedClass'];  
    $capturedAccountID  = $_POST['sendAccountID'];  



    $query = 'DELETE FROM grades 
    WHERE classID_Grades = '.$capturedClass;
    mysql_query($query);



    //build the COLUMN NAMES
    $columnNames = "(accountID_Grades, classID_Grades,". implode(',',$capturedCSVArray[0]).')';

    
    //since i cannot upload more than 1000 variables at a time, 
    //we segment the upload by 20 entries at a time.
    for ($counter = 1 ; $counter < count($capturedCSVArray) ; $counter = $counter+20)
    {
      $endCount = $counter+20;
      if ($counter+20 > count($capturedCSVArray))
      {$endCount = count($capturedCSVArray);}

      //build the ROW ENTRIES
      $rowEntries = "";
      $rowEntriesUploaderInfo = "(".$capturedAccountID.",".$capturedClass .",";

      //build ROW ELEMENTS
      for($i = $counter ; $i < $endCount ; $i++)
      {
        $rowEntries = $rowEntries. $rowEntriesUploaderInfo .'"'. implode('","', $capturedCSVArray[$i]) . '")';
        
        //comma will be placed if there is a next entry otherwise, it is ommitted.
        if ($i < $endCount-1)
        {$rowEntries = $rowEntries . ", ";}     
      }

      $query = 'INSERT INTO grades'.$columnNames. ' VALUES '. $rowEntries.';';
      mysql_query($query);
      
    }

    echo json_encode(true);
	}

?>
