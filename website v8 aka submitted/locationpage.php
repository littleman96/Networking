<html>
	<head>
		<title>Update or query a users location</title>
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
		
		<h1>Find or Update a users's location</h1> 
		<p>Click on one of the buttons below to query or update a users's location.</p>
		<p>Below will query a users location</p><!-- to query the users location -->
		<form action="location.php" method="GET">  
			<p>Username:</p> <input type="text" name="name" required = "required"></input></p>
			<!-- <p>Location:</p> <input type="text" id="getlocation" name="getlocation"></input></p> -->
			<p><input type="submit" value="Get Location"></input></p>
		</form>
				<br>
		
		<p>Below will update a users location</p> <!-- to update the users location -->
		<form action="location.php" method="POST">
			<p>Username:</p> <input type="text" name="name" required></input></p>
			<p>Location:</p> <input type="text" name="location" required = "required"></input></p>
			<p><input type="submit" value ="Update Location"></p></input>
		</form>
		</body>
</html>