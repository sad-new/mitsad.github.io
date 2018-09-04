<?php
//session_destroy();
session_start();

	$username  = isset($_SESSION['userName']) ? $_SESSION['userName'] : '';
	$userType  = isset($_SESSION['userType']) ? $_SESSION['userType'] : '';
	$accountID = isset($_SESSION['accountID']) ? $_SESSION['accountID']: '';

	if($username  == "")
	{
		echo "<script>
		window.location.href='index.php';
		</script>";
	}

	else 
	{
		//do stuff
	}

?>
