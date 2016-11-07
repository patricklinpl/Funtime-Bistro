<DOCTYPE html>
	<html>  
	<meta>  
	<title>Funtime Restaurant</title>
</head>  
<body>

	<p> <font size = "20" color = maroon >  Edit Menu</font></p>

	<?php

	require "base.php";

	//prints results from a select 
	function printResult($menu_result) { 
		echo "<table><tr>
		<th>NAME</th>
		<th>Price</th>
		<th>ImagePath</th>
		<th>Description</th>
		<th>Deleted?</th>
	</tr>";
	 // output data of each row
	while($row = $menu_result->fetch_assoc()) {
		echo "<tr>
		<td>" . $row["name"] . "</td>
		<td>" . $row["price"] . "</td>
		<td>" . $row["imagepath"] . "</td>
		<td>" . $row["description"] . "</td>       
		<td>" . $row["m_deleted"] . "</td>
	</tr>";
}  
echo "</table>";
}


if ($conn) {

// Create a new Menu Item 
	if (!empty($_POST['insName']) && !empty($_POST['insPrice'])) {

		$name = ($_POST['insName']);
		$price = ($_POST['insPrice']);
		$img = ($_POST['insImage']);
		$desc = ($_POST['insDescr']);

		if (ctype_alpha($name) && ctype_digit($price) && ctype_alpha($desc)) {
			
			$checkname = $conn->query("SELECT * FROM MenuItem WHERE name = '".$name."'");

			if($checkname->num_rows == 1) {
				echo "<script type='text/javascript'>alert('Menu Item already added!')</script>";
			}

			else {
				$insmenuquery = $conn->query("INSERT INTO MenuItem (name, price, imagepath, description, m_deleted) VALUES('".$name."', '".$price."', '".$img."', '".$desc."', 'F' )");

				if ($insmenuquery) {
					echo "<script type='text/javascript'>alert('Menu Item added successfully!')</script>";
				} else {
					echo "<script type='text/javascript'>alert('Menu Item cannot be added')</script>"; 
				}
			}
		} else {
			echo "<script type='text/javascript'>alert('Menu Item cannot be added')</script>";
		}

//Delete an existing Menu Item 
	}else  
	if (!empty($_POST['delName'])) {

		$name = ($_POST['delName']);
		$checkname = $conn->query("SELECT * FROM MenuItem WHERE name = '".$name."' AND m_deleted = 'F' ");

		if($checkname->num_rows == 0) {
			echo "<script type='text/javascript'>alert('Menu Item does not exist!')</script>";
		}
		else {
			$delmenuquery = $conn->query("UPDATE MenuItem SET m_deleted = 'T' WHERE name = '".$name."'");

			if ($delmenuquery) {
				echo "<script type='text/javascript'>alert('Menu Item deleted successfully!')</script>";
			}

		}

//Edit an existing Menu Item 
	} else  
	if (!empty($_POST['edName'])) {

		$name = ($_POST['edName']);
		$price = ($_POST['edPrice']);
		$img = ($_POST['edImage']);
		$desc = ($_POST['edDescr']);

		$checkname = $conn->query("SELECT * FROM MenuItem WHERE name = '".$name."' AND m_deleted = 'F' ");

		if($checkname->num_rows == 0) {
			echo "<script type='text/javascript'>alert('Menu Item does not exist!')</script>";
		}

		else {
			$editmenuquery = $conn->query("UPDATE MenuItem SET price = '".$price."', imagepath = '".$img."', description = '".$desc."' WHERE name = '".$name."'");

			if ($editmenuquery) {
				echo "<script type='text/javascript'>alert('Menu Item edited successfully!')</script>";
			}

		}
	}

}


// Query database for all Menu Items
$menu_sql = "SELECT * FROM MenuItem";
$menu_result = $conn->query($menu_sql);
printResult($menu_result);


$conn->close();
?>  


<p>Create a new Menu Item below:</p>

<form method="POST" action="admin_menu.php">
	<!--refresh page when submit-->
	<!--Input box text change-->
	<p>
		<input type="text" name="insName" size="18" pattern="*[A-Za-z]" placeholder="Name" required>
		<input type="text" name="insPrice" size="18" pattern="*[0-9]" placeholder="Price" required>
		<input type="text" name="insImage" size="18" placeholder="Image">
		<input type="text" name="insDescr" size="18" pattern="*[A-Za-z]" placeholder="Description">
		<!--define two variables to pass the value--> 
		<input type="submit" value="insert" name="insertsubmit"></p>
	</form>

	<p> Edit MenuItem: </p>
	<form method="POST" action="admin_menu.php">
		<!--refresh page when submit-->
		<p><input type="text" name="edName"  size="18" placeholder="Name of Item to edit">
			<input type="text" name="edPrice" size="18" placeholder="New Price">
			<input type="text" name="edImage" size="18" placeholder="New Image">
			<input type="text" name="edDescr" size="18" placeholder="New Description">
			<!--define two variables to pass the value-->
			<input type="submit" value="update" name="updatesubmit"></p>
		</form>

		<p> Delete a Menu Item</p>
		<form method="POST" action="admin_menu.php">
			<!--refresh page when submit-->
			<p><input type="text" name="delName" size="18" placeholder="Name">
				<!--define two variables to pass the value-->
				<input type="submit" value="delete" name="deletesubmit"></p>
			</form>

			<a href="index.php"> Back to control panel

			</body>
			</html>
