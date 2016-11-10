
<DOCTYPE html>
	<html>  
	<meta>  
	<title>Funtime Restaurant</title>
</head>  
<body>

	<p> <font size = "20" color = maroon>Edit Ingredients</font></p>

	<?php

	require "base.php";

//prints results from a select
	function printResult($ing_result) {  
		echo "<table><tr>
		<th>Name</th>
		<th>Deleted?</th>
	</tr>";
	 // output data of each row
	while($row = $ing_result->fetch_assoc()) {
		echo "<tr>
		<td>" . $row["name"] . "</td> 
		<td>" . $row["i_deleted"] . "</td>
	</tr>";
}  
echo "</table>";
}


if ($conn) {

//Insert new Ingredient
	if (!empty($_POST['insName'])) {

		$name = ($_POST['insName']);
		
		if (ctype_alpha(preg_replace('/\s+/', '', $name))) {

			$checkname = $conn->query("SELECT * FROM Ingredient WHERE name = '".$name."'");

			if($checkname->num_rows == 1) {
				echo "<script type='text/javascript'>alert('Ingredient has already added!')</script>";
			}

			else {
				$insingquery = $conn->query("INSERT INTO Ingredient (name, i_deleted) VALUES('".$name."', 'F' )");

				if ($insingquery) {
					echo "<script type='text/javascript'>alert('Ingredient was added successfully!')</script>";
				} else {
					echo "<script type='text/javascript'>alert('Ingredient cannot be added')</script>"; 
				}
			}
		}else {
			echo "<script type='text/javascript'>alert('Inputs are not valid, please try again')</script>";
		}

//Delete an existing Ingredient
	} else  
	if (!empty($_POST['delName'])) {

		$name = ($_POST['delName']);

		if (ctype_alpha(preg_replace('/\s+/', '', $name))) {

			$checkname = $conn->query("SELECT * FROM Ingredient WHERE name = '".$name."' AND i_deleted = 'F' ");

			if ($checkname->num_rows == 0) {
				echo "<script type='text/javascript'>alert('Ingredient does not exist!')</script>";
			}

			else {
				$delmenuquery = $conn->query("UPDATE Ingredient SET i_deleted = 'T' WHERE name = '".$name."'");

				if ($delmenuquery) {
					echo "<script type='text/javascript'>alert('Ingredient deleted successfully!')</script>";
				}
			}
		} else {
			echo "<script type='text/javascript'>alert('Inputs are not valid, please try again')</script>";
		}
	}
}

		// Query database for all Menu Items
$ing_sql = "SELECT * FROM Ingredient";
$ing_result = $conn->query($ing_sql);
printResult($ing_result);


$conn->close();
?>  


<p>Create a new Ingredient below:</p>
<form method="POST" action="ingredient.php">
	<!--refresh page when submit-->
	<!--Input box text change-->
	<p>
		<input type="text" name="insName" size="18" pattern="*[A-Za-z]" placeholder="Name" required>
		<!--define two variables to pass the value--> 
		<input type="submit" value="Insert" name="insertsubmit"></p>
	</form>

	<p> Delete an Ingredient</p>
	<form method="POST" action="ingredient.php">
		<!--refresh page when submit-->
		<p><input type="text" name="delName" size="18" pattern="*[A-Za-z]" placeholder="Name" required>
			<!--define two variables to pass the value-->
			<input type="submit" value="Delete" name="deletesubmit"></p>
		</form>

		<a href="index.php"> Back to control panel

		</body>
		</html>
