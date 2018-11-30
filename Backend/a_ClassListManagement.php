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
        case '1' : load_Main_ClassDetails(); break;

        case '3' : loadCurrentClassList();break;
	    	case '4' : uploadCSVTable();break;
	    }
	}





  function load_Main_ClassDetails()
  {

    include 'b_ConnectionString.php';


    $captured_ClassID = $_POST['sent_ClassID'];

    $query = 
      "SELECT
      merged.gradeLevelName,
      merged.sectionName,
      merged.schoolYear,
      merged.studentCount

      FROM
      (
        SELECT *, IFNULL(COUNT(cs.classStudentID), 0) AS studentCount  
        from classes as c

        INNER JOIN
        (SELECT gradeLevelID, gradeLevelName from gradeLevels) as gl 
        on gl.gradeLevelID = c.gradeLevelID_Classes 
         
          
        INNER JOIN
        (SELECT sectionID, sectionName from sections) as se 
        on se.sectionID = c.sectionID_Classes 

        INNER JOIN 
        (SELECT syTermID, schoolYear from syterms) as sy 
        on sy.syTermID = c.syTermID_Start_Classes

        LEFT JOIN
        classStudents as cs
        on cs.classID_ClassStudents = c.classID
        group by c.classID


      ) as merged

      WHERE merged.classID = '$captured_ClassID'";

    $tableQuery = mysqli_query($mySQL_ConStr, $query) 
      or die ("cannot load tables");      

    $classSubjectDetails = mysqli_fetch_assoc($tableQuery); 
    echo json_encode($classSubjectDetails);
  }



  // 2 (none)



  // 3
  function loadCurrentClassList()
  {
    include "b_ConnectionString.php";

    $captured_ClassID      = $_POST['sent_ClassID'];  

    $classListArray = [];

    $query = "SELECT studentNumber, studentName, studentGender FROM classstudents
    WHERE classID_ClassStudents = '$captured_ClassID' ORDER by studentGender DESC, studentName ASC"; 

    $tableQuery = mysqli_query($mySQL_ConStr, $query);
    while($getRow = mysqli_fetch_row($tableQuery))
    {  
        $classListArray[] = $getRow;
    }
    echo json_encode($classListArray);
  }




  // 4
	function uploadCSVTable()
	{

    include "b_ConnectionString.php";

    $property = "max_input_vars";
    $propertyValue = 20000;
    ini_set ( $property, $propertyValue );

    //capture the entries
    $captured_CSVArray   = $_POST['send_CSVArray'];
    $captured_ClassID      = $_POST['send_ClassID'];  


    $query = 'DELETE FROM classstudents
    WHERE classID_ClassStudents = '.$captured_ClassID;
    mysqli_query($mySQL_ConStr, $query);




    //build the COLUMN NAMES
    $columnNames = "(classID_ClassStudents, studentNumber, studentName, studentGender)";
    
    //since i cannot upload more than 1000 variables at a time, 
    //we segment the upload by 20 entries at a time.
    for ($counter = 0 ; $counter < count($captured_CSVArray) ; $counter = $counter+20)
    {
      $endCount = $counter+20;
      if ($counter+20 > count($captured_CSVArray))
      {$endCount = count($captured_CSVArray);}

      //build the ROW ENTRIES
      $rowEntries = "";
      $rowEntriesClassInfo = "(".$captured_ClassID .",";
      for($i = $counter ; $i < $endCount ; $i++)
      {
        $rowEntries = $rowEntries . $rowEntriesClassInfo . '"' . implode('","', $captured_CSVArray[$i]) . '")';
        
        //comma will be placed if there is a next entry. 
        //otherwise, it is ommitted.
        if ($i < $endCount-1)
        {$rowEntries = $rowEntries . ", ";}     
      }

      $query = 'INSERT INTO classstudents '.$columnNames. ' VALUES '. $rowEntries.';';
      mysqli_query($mySQL_ConStr, $query);
      
    }

    echo json_encode(true);
	}

?>
