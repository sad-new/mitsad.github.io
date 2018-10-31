<?php

  if(!isset($_SESSION)) 
  {
		session_start();
	}

include 'b_ConnectionString.php';


//get variables
$POSTed_UserName = $_POST['f_UserName'];
$POSTed_Password = $_POST['f_Password'];


//Check DB for matching username+Password
$query = mysqli_query($mySQL_ConStr, "select * from ".$mySQL_Database.".accounts where username='$POSTed_UserName' and password ='$POSTed_Password'");
$checkRows = $query->num_rows;  

if ($checkRows!=0)
{
	while($row = mysqli_fetch_assoc($query))
	{
		$fetched_UserName = $row['userName'];
		$fetched_Password = $row['password'];
		$fetched_AccountType = $row['userType'];
		$fetched_AccountID = $row['accountID'];
	}


 	if($POSTed_UserName==$fetched_UserName&&
    $POSTed_Password==$fetched_Password)
	{

		$_SESSION['userName'] = $fetched_UserName;
		$_SESSION['userType'] = $fetched_AccountType;
		$_SESSION['accountID'] = $fetched_AccountID;


		session_write_close();
		echo "<script>window.location.href='./Dashboard.php';</script>";
		exit();
	}

	// NEITHER
	else 
	{
		//echo "3";
		echo "<script>alert('Sorry, but you are not authorized!');</script>";
	}
}

	
	//Blank Username/Password
	else if($POSTed_UserName=="" or $POSTed_Password=="")
	{ 
		//echo "4";
		$error_msg="<font color='red'>Blank Fields</font>";
		echo $error_msg;
	}

	//Wrong Username/Password
	else
	{
		//echo "5";
		$error_msg="<font color='red'>Incorrect Username or Password</font>";
		echo $error_msg;
	}


?>