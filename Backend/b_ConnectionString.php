<?php 

	// CONSTANTS. CHANGE THESE.
	$host = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbName = "sadNew_v10";


	// VARIABLES
	$mySQL_HostName = $host;
	$mySQL_User 	= $dbUser;
	$mySQL_Password = $dbPass;
	$mySQL_Database = $dbName;

	// TEST DB
	$bd = 
	@mysqli_connect($mySQL_HostName, $mySQL_User, $mySQL_Password)
	or die("error over here. (1001)");

	@mysqli_select_db($bd, $mySQL_Database) 
	or die("error over here. (1002)"); 


  $con = mysqli_connect($mySQL_HostName, $mySQL_User, $mySQL_Password, $mySQL_Database);
  
	

?>
