<?php
$server = 'SQL2008.net.dcs.hull.ac.uk';
$connectionInfo = array( "Database"=>"rde_508978");
$conn = sqlsrv_connect($server,$connectionInfo);
date_default_timezone_set('Europe/London'); 
if ($_GET) //if a get request is sent
{
	//get
	
	$getname = $_GET['name'];
	
	$locationgetQuery = "SELECT * FROM UserLocationDB WHERE UserId = ?"; //checks to see if the user id matches anything in the database
	
	$getresults = sqlsrv_query($conn, $locationgetQuery, array($getname));
	
	$rows = sqlsrv_fetch_array($getresults, SQLSRV_FETCH_ASSOC);

	if(!(empty($rows))) //if the user is in the database the location is returned
	{	
		$UserId = $rows['UserId'];
		$UserLocation = $rows['UserLocation'];
		$UpdateTimeDate = $rows['UpdateTimeDate'];
		$timeOutput = $UpdateTimeDate->getTimestamp();

		printf("HTTP/1.1 200 OK\r\nContent-Type: text/plain\r\n\r\n". $UserLocation . "\r\n");
	}
	else //otherwise an error message is shown that the user isn't in the system
	{
		echo"HTTP/1.1<space>404<space>Not<space>Found\r\nContent-Type:<space>text/plain\r\n<optional header lines>\r\n";		
	}
}

else if ($_POST) //if it is a post request 
{
	//outputting current location too screen
	$postname = $_POST['name']; //needs changing to recieving request
	$postlocation = $_POST['location'];
	
	$locationpostQuery = "SELECT * FROM UserLocationDB WHERE UserId = '$postname'";
	
	$results = sqlsrv_query($conn, $locationpostQuery, array($postname));
	
	$date = date('Y.m.d H:i:s');
				

	if (sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)) //return current location of user
	{
		//update location plus add too history
		$LocationUpdateQuery = "UPDATE UserLocationDB SET UserLocation = '$postlocation', UpdateTimeDate = '$date' WHERE UserId = '$postname'";
		sqlsrv_query($conn, $LocationUpdateQuery);
		
		//add to history database
		
		$LocationHistoryAddQuery = "INSERT INTO UserLocationHistoryDB (UserId, UserLocation, UpdateTimeDate) VALUES ('$postname', '$postlocation', '$date')";
		sqlsrv_query($conn, $LocationHistoryAddQuery);
		
		echo "HTTP/1.1<space>200<space>OK\r\nContent-Type:<space>text/plain\r\n<optional header lines>\r\n";
	}
	else //if user isn't in it. add them
	{
		//add to user
		
		$AddUserQuery = "INSERT INTO UserDetailsDB (UserId, UserForename, UserSurname) VALUES ('$postname', '','')";
		sqlsrv_query($conn, $AddUserQuery);

		//add to current location
		
		$LocationAddQuery = "INSERT INTO UserLocationDB (UserId, UserLocation, UpdateTimeDate) VALUES ('$postname', '$postlocation', '$date')";
		sqlsrv_query($conn, $LocationAddQuery);
		
		//add to history database
		
		$LocationHistoryAddQuery = "INSERT INTO UserLocationHistoryDB (UserId, UserLocation, UpdateTimeDate) VALUES ('$postname', '$postlocation', '$date')";
		sqlsrv_query($conn, $LocationHistoryAddQuery);
		
		//have return message.
					
		echo $postname . "HTTP/1.1<space>200<space>OK\r\nContent-Type:<space>text/plain\r\n<optional header lines>\r\n";
	}
				

}
sqlsrv_close($conn);
?>
