<html>
	<head>
		<title>Location History</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<ul>
		<li><a href=index.php>Home</a></li>
		<li><a href=locationpage.php>Location</a></li>
		<li><a href=locationhistory.php>Location history</a></li>
		<li><a href=userdetails.php>User's Details</a></li>
		<li><a href=staffcurrentlocation.php>Staff Current Location</a></li>
		<li><a href=staffinspecificlocation.php>Specific Location</a></li>
		</ul>
	
		<h1>Location History of User</h1>
		
		<p>This page will show all the users location for the last 24 hours.</p>
		
		<form action="locationhistory.php" method="get">
			<p>Username:</p> <input type="text" name="name" required = "required"></input></p>
			<p><input type="submit" value ="Get Location History"></p></input>
		</form>
				
		<br>
		
		<?php
			$server = 'SQL2008.net.dcs.hull.ac.uk';
			$connectionInfo = array( "Database"=>"rde_508978");
			$conn = sqlsrv_connect($server,$connectionInfo);
			date_default_timezone_set('Europe/London');
	
			if ($_GET)
			{
				$getname = $_GET['name'];
		
				$date = date('Y.m.d H:i:s'); //formats the date
		
				$locationgethistoryQuery = "SELECT * FROM UserLocationHistoryDB WHERE UserId = ? ORDER BY UpdateTimeDate DESC"; //gets all the locations a user has been which matches a user id. it is ordered it is done in descending order
		
				$gethistoryresults = sqlsrv_query($conn, $locationgethistoryQuery, array($getname));
		
		
				echo "<p><table>"; //set out in a table
				echo "<tr><th>Location</th><th>Time</th></tr>";

				while($rows = sqlsrv_fetch_array($gethistoryresults, SQLSRV_FETCH_ASSOC))
				{						
					$UserId = $rows['UserId'];
					$UserLocation = $rows['UserLocation'];
					$UpdateTimeDate = $rows['UpdateTimeDate'];
					$timeOutput = $UpdateTimeDate->getTimestamp(); //this helps get it in to a readable format
				
			
					if(strtotime('-1 day')< ($timeOutput)) //won't show anything over a day ago
					{
						echo "<tr><td>" . $UserLocation . "</td>";
						echo "<td>" . date("Y-m-d\tH:i:s", $timeOutput) . "</td></tr>";
					}
				}
			
				echo "</table></p>";
				

				
			}
			sqlsrv_close($conn);
		?>
	</body>
</html>