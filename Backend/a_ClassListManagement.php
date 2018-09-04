<?php

include 'b_ConnectionString.php';

  //function selection block  
  if(isset($_POST['action']) && !empty($_POST['action'])) 
  {
      $action = $_POST['action'];
      switch($action) 
      {
        case '1' : ajax_LoadClassDetails();break;
        case '2' : ajax_LoadClassList();break;
        case '3' : ajax_UploadClassList();break; 
//        case '4' : ajax_RemoveClassList();break;
      }
  }


function ajax_LoadClassDetails()
{
  $captured_ClassID = $_POST['sent_ClassID'];

  $query = 
    "SELECT
    merged.sectionName,
    merged.schoolYear 

    FROM
    (
      SELECT * from classes as c

      INNER JOIN
      (SELECT sectionID, sectionName from sections) as se 
      on se.sectionID = c.sectionID_Classes 

      INNER JOIN 
      (SELECT syTermID, schoolYear from syterms) as sy 
      on sy.syTermID = c.syTermID_Start_Classes
    ) as merged

    WHERE merged.classID = $captured_ClassID";

  $tableQuery = mysql_query($query) 
    or die ("cannot load tables");      

  $classDetails = mysql_fetch_assoc($tableQuery); 
  echo json_encode($classDetails);
}

function ajax_LoadClassList()
{
  $captured_ClassID = $_POST['sent_ClassID'];

  $classListArray = []; 
  $query = 
  "SELECT classStudentID, studentLRN, studentGender, studentName 
  FROM classStudents 
  WHERE classID_ClassStudents = $captured_ClassID 
  ORDER BY studentGender DESC, studentName ASC;";  

    $tableQuery = mysql_query($query) 
      or die ("cannot load tables");  

  while($getRow = mysql_fetch_assoc($tableQuery))
  {
    $classListArray[] = $getRow;
  };

  echo json_encode($classListArray);
}



function ajax_UploadClassList()
{
  $captured_ClassListArray = $_POST['sent_ClassListArray'];
  $captured_ClassID = $_POST['sent_ClassID'];
  removeClassList($captured_ClassID);

  foreach ($captured_ClassListArray as $entry) 
  {
    $query = "INSERT INTO classStudents (classID_ClassStudents, studentLRN, studentGender,
    studentName) 
    VALUES 
    (
      '".$captured_ClassID."',
      '".$entry[0]."',
      '".$entry[1]."',
      '".$entry[2]."'
    )";

    $tableQuery = mysql_query($query) 
      or die ("cannot load tables");

  }

  echo json_encode(true);
}

function ajax_RemoveClassList()
{
  $captured_ClassID = $_POST['sent_ClassID'];
  removeClassList($captured_ClassID);
}

function removeClassList($classID)
{
  $query = "DELETE FROM classStudents WHERE classID_ClassStudents = $classID;";
  $tableQuery = mysql_query($query) 
      
  or die ("cannot load tables");
}

?>