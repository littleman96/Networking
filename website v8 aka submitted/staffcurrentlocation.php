<html>
	<head>
		<title>Staff Current Location</title>
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
	
		<h1>Staff Current Location</h1>
		<p>The current location for all staff.</p>
		
		<table>
		<p><tr>
		<th>UserId</th> <!-- it is shown in a table -->
		<th>UserLocation</th>
		<th>Time</th>
		</tr>
		
		<?php
			$server = 'SQL2008.net.dcs.hull.ac.uk';
			$connectionInfo = array( "Database"=>"rde_508978");
			$conn = sqlsrv_connect($server,$connectionInfo);
			date_default_timezone_set('Europe/London');

			$locationgetQuery = "SELECT * FROM UserLocationDB ORDER BY UserId ASC"; //selects every user from the database
			
			$results = sqlsrv_query($conn, $locationgetQuery);
			
			while($rows = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)):
				$UserId = $rows['UserId'];
				$UserLocation = $rows['UserLocation'];
				$UpdateTimeDate = $rows['UpdateTimeDate'];
				$timeOutput = $UpdateTimeDate->getTimestamp();
				
				echo "<tr><td>" . $UserId . "</td>"; 
				echo "<td>" . $UserLocation . "</td>";
				echo "<td>" . date("Y-m-d\tH:i:s", $timeOutput) . "</td></tr>";
			endwhile;
	
			
			sqlsrv_close($conn);
		?>
		</table></p>
	</body>
</html>