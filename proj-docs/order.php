<?php include "base.php"; ?>

<DOCTYPE html>
  <html>  
  <meta>  
  <title>Order</title>
</head>  
<body>

  <p> <font size = "20" color = maroon >  Order</font></p>

  <?php

  $uName = ($_SESSION['Username']);

  $openorderexist = $conn->query("
    SELECT *
    FROM Orders
    WHERE customer_username = '".$uName."' AND status = 'open'");

  if ($openorderexist->num_rows == 0) {
    // Case 1: CREATE NEW ORDER
    echo "No open orders"; 
    echo '<form action="" method="post"><input type="submit" name="NewOrder" value="Create New Order" /></form></td>"';
    
    if(isset($_POST['NewOrder'])) {
      $mName = $_POST["NewOrder"];

  // NEED dynamic Date
      $makeneworder = $conn->query("INSERT INTO Orders (customer_userName, chef_userName, orderdate, cookeddate, status) VALUES('".$uName."', 'chef1', DATE '2016-11-01', NULL, 'open')");

      if ($makeneworder) {
        echo "<script type='text/javascript'>alert('New Order opened')</script>";
        header( "refresh:0;" );
      }
      else {
       echo "<script type='text/javascript'>alert('Failed to create new Order')</script>";
     }
   }
 }
 else {
    // Case 2: SELECT AN ORDER ID

$oid_sql = "SELECT order_id FROM Orders WHERE customer_userName = '".$uName."' AND status = 'open'";
 $oid_result = $conn->query($oid_sql);
 // $orderid = mysql_fetch_assoc($oid_sql);
 $row = $oid_result->fetch_array(MYSQLI_ASSOC);
 $orderid = $row['order_id'];

  function printResult($contains_result) { //prints results from a select 
    echo "<table><tr>
    <th>OrderID</th>
    <th>Item Name</th>
    <th>Quantity</th>
  </tr>";
  // output data of each row
  while($row = $contains_result->fetch_assoc()) {
   echo "<tr>
   <td>" . $row["order_id"] . "</td>
   <td>" . $row["name"] . "</td>
   <td>" . $row["qty"] . "</td>
 </tr>";
}  
echo "</table>";
}

echo "Open Orders";
    // Query database for all Menu Items
$contains_sql = "SELECT * FROM Contains WHERE order_id = '".$orderid."'";
$contains_result = $conn->query($contains_sql);
printResult($contains_result);



function printMenuResult($menu_result) { 
  echo "<table><tr>
  <th>NAME</th>
  <th>Price</th>
  <th>ImagePath</th>
  <th>Description</th>
  <thAdd</th>
</tr>";
while($row = $menu_result->fetch_array(MYSQLI_ASSOC)) {
  echo "<tr>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['imagepath'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  echo '<td><form action="" method="post"><input type="hidden" name="mName" value="'.$row['name'].'"></td>';
  echo '<td><input type="submit" name="AddItem" value="Add" /></form></td>"';
  echo "</tr>";
}
echo "</table>";
}

if(isset($_POST['AddItem'])) {
// here comes your delete query: use $_POST['deleteItem'] as your id
// $delete = $_POST['deleteItem']
// $sql = "DELETE FROM `tablename` where `id` = '$delete'"; 
  $mName = $_POST['mName'];
  $addsql = $conn->query("INSERT INTO Contains (order_id, name, qty) VALUES('".$orderid."', '".$mName."', '1')");
  if ($addsql) {
    echo "<script type='text/javascript'>alert('Item added to Order!')</script>";
    header( "refresh:0;" );
  }
  else {
   echo "<script type='text/javascript'>alert('Item already in Order!')</script>";
 }
}

echo "Available Items to Order";
    // Query database for all Menu Items
$menu_sql = "SELECT * FROM MenuItem WHERE m_deleted = 'F'";
$menu_result = $conn->query($menu_sql);
printMenuResult($menu_result);

}

?>

</body>
</html>