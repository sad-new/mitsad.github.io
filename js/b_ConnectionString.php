<?php 

	//CONSTANTS
	$host = "localhost";
	$dbUser = "root";
	$dbPass = "";
	$dbName = "dbcapstone";



	$mySQL_HostName = $host;
	$mySQL_User 	= $dbUser;
	$mySQL_Password = $dbPass;
	$mySQL_Database = $dbName;


	//TEST DB
	$bd = 
	@mysql_connect($mySQL_HostName, $mySQL_User, $mySQL_Password)
	or die("error over here. (1001)");

	@mysql_select_db($mySQL_Database, $bd) 
	or die("error over here. (1002)"); 

	// function connectToDB()
	// {
	// 	mysql_connect($mySQL_HostName, $mySQL_User, $mySQL_Password, $mySQL_Database); 
	// }

?>
