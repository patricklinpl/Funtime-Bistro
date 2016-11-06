
<DOCTYPE html>
<html>  
<meta>  
<title>Funtime Restaurant</title>
</head>  
<body>

<p> <font size = "20" color = maroon >  Fun Time Bistro Menu</font></p>

<?php

require "connect.php";

function printResult($menu_result) { //prints results from a select 
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

	if (!empty($_POST['insName']) && !empty($_POST['insPrice'])) {

		$name = mysql_real_escape_string($_POST['insName']);
    	$price = mysql_real_escape_string($_POST['insPrice']);
    	$img = mysql_real_escape_string($_POST['insImage']);
    	$desc = mysql_real_escape_string($_POST['insDescr']);

    	$checkname = $conn->query("SELECT * FROM MenuItem WHERE name = '".$name."'");
      
	if($checkname->num_rows == 1) {
        echo "<h1>Error</h1>";
        echo "<p>MenuItem has already been added</p>";
     }

    else {
        	$insmenuquery = $conn->query("INSERT INTO MenuItem (name, price, imagepath, description, m_deleted) VALUES('".$name."', '".$price."', '".$img."', '".$desc."', 'F' )");
        	if($insmenuquery) {
        		echo "<h1>Success</h1>";
        		echo "<p>MenuItem was added</p>";
        	}
        	else {
            	echo "<h1>Error</h1>";
            	echo "<p>MenuItem cannot be added</p>";    
     		}       
     	}
	} else 	
		if (!empty($_POST['delName'])) {

			$name = mysql_real_escape_string($_POST['delName']);
			$checkname = $conn->query("SELECT * FROM MenuItem WHERE name = '".$name."' AND m_deleted = 'F' ");

			if($checkname->num_rows == 0) {
        		echo "<h1>Error</h1>";
        		echo "<p>MenuItem does not exist</p>";
			}
			else {
				$delmenuquery = $conn->query("UPDATE MenuItem SET m_deleted = 'T' WHERE name = '".$name."'");

				if ($delmenuquery) {
					echo "<h1>Success</h1>";
        			echo "<p>MenuItem was deleted</p>";
        		}
				else {
					echo "<h1>Error</h1>";
        			echo "<p>MenuItem already deleted</p>";  
				}
			}
		}

	if ($_POST) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: menu.php");
	} else {
		echo "Admin View";
		// Query database for all Menu Items
		$menu_sql = "SELECT * FROM MenuItem";
		$menu_result = $conn->query($menu_sql);
		printResult($menu_result);
	}

	$conn->close();

} else {
	echo "cannot connect";
}
?>  

<p>Create a new Menu Item below:</p>
<form method="POST" action="menu.php">
<!--refresh page when submit-->
<!--Input box text change-->
   <p>
   <input type="text" name="insName" size="18" placeholder="Name">
   <input type="text" name="insPrice" size="18" placeholder="Price">
   <input type="text" name="insImage" size="18" placeholder="Image">
   <input type="text" name="insDescr" size="10" placeholder="Description">
<!--define two variables to pass the value--> 
<input type="submit" value="insert" name="insertsubmit"></p>
</form>

<p> Edit MenuItem: </p>
<form method="POST" action="menu.php">
<!--refresh page when submit-->
   <p><input type="text" name="oldName" size="18" placeholder="Old Username">
   <input type="text" name="newName" placeholder="New Username" size="18">
<!--define two variables to pass the value-->
<input type="submit" value="update" name="updatesubmit"></p>
</form>

<p> Delete a Menu Item</p>
<form method="POST" action="menu.php">
<!--refresh page when submit-->
   <p><input type="text" name="delName" size="18" placeholder="Name">
<!--define two variables to pass the value-->
<input type="submit" value="delete" name="deletesubmit"></p>
</form>

</body>
</html>