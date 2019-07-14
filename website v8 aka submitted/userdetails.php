<html>
	<head>
		<title>User Personal Details</title>
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
		
		<h1>Update Users Personal Details</h1>
		
		<p>You can update the users forename and surname below.</p>
		
		<form action="userdetails.php" method="post">
			<p>Username:</p> <input type="text" name="name" required = "required"></input></p>
			<p>Forename:</p> <input type="text" name="forename" required = "required"></input></p>
			<p>Surname:</p> <input type="text" name="surname" required = "required"></input></p>
			<p><input type="submit" value="Update User Details" required = "required"></input></p>
		</form>
		
		<?php
			$server = 'SQL2008.net.dcs.hull.ac.uk';
			$connectionInfo = array( "Database"=>"rde_508978");
			$conn = sqlsrv_connect($server,$connectionInfo);
			
			if ($_POST)
			{
				$name = $_POST['name']; //gets the userid from the text box
				$forename = $_POST['forename']; //gets the forename from the text box
				$surname = $_POST['surname']; //gets the surname from the text box
	
				$UserQuery = "SELECT * FROM UserDetailsDB WHERE UserId = '$name'"; //gets eveything from the UserDetailsDB that matches the user id
					
				$results = sqlsrv_query($conn, $UserQuery, array($name));
				
				$rows = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
				
				if(!(empty($rows))) //if their is something in the database that matches the id it will update that users details
				{
					$UserUpdateQuery = "UPDATE UserDetailsDB SET UserForename = '$forename', UserSurname = '$surname' WHERE UserId = '$name'";
					sqlsrv_query($conn, $UserUpdateQuery);
				
					echo "<p>Updated name: " . $forename . " " .  $surname . " for user " . $name . "<p>";
				}
				else //if no ser can be found they will be told their isnt that user in the database
				{
					echo "No user found. Input their username and location into the <a href=locationpage.php>update location page</a> and then you can come back here.";
				}	
			}
			sqlsrv_close($conn);
		?>
	</body>
</html>