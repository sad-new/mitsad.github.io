<?php 

	// CONSTANTS. CHANGE THESE.

	$host = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbName = "karlkrum_sadnew_v11";


	// VARIABLES
	$mySQL_HostName = $host;
	$mySQL_User 	= $dbUser;
	$mySQL_Password = $dbPass;
	$mySQL_Database = $dbName;

	// TEST DB
	$mySQL_ConStr = 
	@mysqli_connect(
    $mySQL_HostName, $mySQL_User, 
    $mySQL_Password, $mySQL_Database);
    
	if (mysqli_connect_errno())
    {
       echo "error over here. (1001)\n" . mysqli_connect_error();
    }

// 	@mysqli_select_db($mySQL_ConStr, $mySQL_Database) 
// 	or die("error over here. (1002)\n" . mysqli_connect_error() ); 


?>
