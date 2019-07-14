<html>
	<head>
		<title>Staff in a Specific Location</title>
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
		
		<h1>Staff in a Specific Location</h1>
		
		<p>Pick a location and you will be shown all users in a specific location.</p>
		<form action="staffinspecificlocation.php" method="get">
		
		<p><select name = "locationoptions" onchange="this.form.submit()">
		<option value = "null"> </option>
		<?php //this sets up the drop down box for the user
			$server = 'SQL2008.net.dcs.hull.ac.uk';
			$connectionInfo = array( "Database"=>"rde_508978");
			$conn = sqlsrv_connect($server,$connectionInfo);
			date_default_timezone_set('Europe/London');
			
			$distinctlocationgetQuery = "SELECT DISTINCT UserLocation FROM UserLocationDB";  //selects distinct locations from the database
			
			$distinctlocationgetresults = sqlsrv_query($conn, $distinctlocationgetQuery);

			while($rows = sqlsrv_fetch_array($distinctlocationgetresults, SQLSRV_FETCH_ASSOC))
			{
				$UserLocation = $rows['UserLocation'];
				echo "<option value=" .$UserLocation . ">" . $UserLocation . "</option>";
			}
	
		?>
		</select></p>
		</form>
		
		
		<?php
		
			$server = 'SQL2008.net.dcs.hull.ac.uk';
			$connectionInfo = array( "Database"=>"rde_508978");
			$conn = sqlsrv_connect($server,$connectionInfo);
			date_default_timezone_set('Europe/London');
			
			if ($_GET) //will display the users from the selected location
			{
				$locationgetQuery = "SELECT * FROM UserLocationDB WHERE UserLocation = ? ORDER BY UserId ASC";
				$locationarray = array($_GET["locationoptions"]);
				
				
				$getresults = sqlsrv_query($conn, $locationgetQuery, $locationarray);
				
				echo"<p><table><tr><th>UserId</th><th>Time</th></tr>";
				
				while($rows = sqlsrv_fetch_array($getresults, SQLSRV_FETCH_ASSOC)):
				
					$UserId = $rows['UserId'];
					$UpdateTimeDate = $rows['UpdateTimeDate'];
					$timeOutput = $UpdateTimeDate->getTimestamp();
					
					echo "<tr><td>" . $UserId . "</td>" ."<td>" . date("Y-m-d\tH:i:s", $timeOutput) . "</td></tr>";
			
				endwhile;
				
				echo"</table></p>";
			}
			
		sqlsrv_close($conn);
		?>
	</body>
</html>