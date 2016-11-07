<DOCTYPE html>
<html>  
<meta>  
<title>Funtime Restaurant</title>
</head>  
<body>


<div class="menu">
<?php include "base.php"; ?>

</div>

<p> <font size = "20" color = maroon >  Fun Time Bistro Menu</font></p>

<?php

function mprintResult($menu_result) { //prints results from a select 
	 echo "<table><tr>
	 <th>Name</th>
	 <th>Price</th>
	 <th>ImagePath</th>
	 <th>Description</th>
	 </tr>";
	 // output data of each row
	 while($row = $menu_result->fetch_assoc()) {
		 echo "<tr>
		 <td>" . $row["name"] . "</td>
		 <td>" . $row["price"] . "</td>
		 <td>" . $row["imagepath"] . "</td>
		 <td>" . $row["description"] . "</td>       
		 </tr>";
		 }  
	 echo "</table>";
}

function oprintResult($result) { //prints results from a select 
	 echo "<table><tr>
	 <th>order_id</th>
	 <th>customer_userName</th>
	 <th>chef_userName</th>
	 <th>orderdate</th>
	 <th>cookdate</th>
	 <th>status</th>
	 </tr>";
	 // output data of each row
	 while($row = $result->fetch_assoc()) {
		 echo "<tr>
		 <td>" . $row["order_id"] . "</td>
		 <td>" . $row["customer_userName"] . "</td>
		 <td>" . $row["chef_userName"] . "</td>
		 <td>" . $row["orderdate"] . "</td>  
		 <td>" . $row["cookeddate"] . "</td> 
		 <td>" . $row["status"] . "</td>      
		 </tr>";
		 }  
	 echo "</table>";
}

// Query database for available Menu Items
$menu_sql = "SELECT name, price, imagepath, description FROM MenuItem WHERE m_deleted = 'F'";
$menu_result = $conn->query($menu_sql);
mprintResult($menu_result);

// Query database for all Menu Items
$order_sql = "SELECT * FROM Orders";
$order_result = $conn->query($order_sql);
oprintResult($order_result);

echo $_SESSION['username']; 

$conn->close();
?>  

<p>Purchase an Item</p>

<form method="POST" action="admin_menu.php">
	<!--refresh page when submit-->
	<!--Input box text change-->
	<p>
		<input type="text" name="insName" size="18" pattern="*[A-Za-z]" placeholder="Name" required>
		<input type="text" name="insPrice" size="18" pattern="*[0-9]" placeholder="Price" required>
		<input type="text" name="insImage" size="18" placeholder="Image">
		<input type="text" name="insDescr" size="18" pattern="*[A-Za-z]" placeholder="Description">
		<!--define two variables to pass the value--> 
		<input type="submit" value="Purchase" name="insertsubmit"></p>
	</form>

	<a href="index.php"> Back to control panel

</body>
</html>

