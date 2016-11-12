<?php


// run when filter button is clicked
if(isset($_POST['select'])) {

    $col = $_POST['filter'];

    $num = $_POST['value'];

    $operator = $_POST['operator'];

    $name = "name,";
    $price = "price,";
    $img = "imagepath,";
    $desc = "description,";
    $qty = "quantity,";


    if(!isset($_POST['selname'])) {
        $name = "";
    } 

    if(!isset($_POST['selprice'])) {
        $price = "";
    } 

    if(!isset($_POST['selimg'])) {
        $img = "";
    } 

    if(!isset($_POST['seldesc'])) {
        $desc = "";
    } 

    if(!isset($_POST['selqty'])) {
        $qty = "";
    } 

    $att = rtrim("$name $price $img $desc $qty", ', '); 

    $query = "SELECT $att
    FROM MenuItem 
    WHERE $col $operator $num AND m_deleted = 'F'";

    if ($query) {
     $search_result = filterTable($query);
 }


} else {
    $query = "SELECT name, price, imagepath, description, quantity FROM MenuItem  WHERE m_deleted = 'F'";
    $search_result = filterTable($query);
}


// function to connect and execute the query
function filterTable($query)
{
    require "base.php";
    $filter_Result = $conn->query($query);
    return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Funtime Restaurant</title>
    <style>
        table,tr,th,td
        {
            border: 1px solid black;
        }
    </style>
    <p> <font size = "20" color = maroon >  Fun Time Bistro Menu</font></p>
</head>
<body>


    <!-- Form to filer by price / quantity  -->
    <form method="post">
        Show only Menu Items where

        <select name="filter">
            <option value="price">Price</option>
            <option value="quantity">Quantity</option>
        </select>

        is

        <select name="operator">
            <option value="=">=</option>
            <option value=">">></option>
            <option value="<"><</option>
        </select>

        <input type="number" name="value" step="0.01" min=0 required>

        <input type="hidden" name="select">

        &nbsp; <br/> <br/>

        Choose the attributes to display <br>

        <input type="checkbox" name="selname" value="y" checked /> Name
        <input type="checkbox" name="selprice" value="y" checked/> Price
        <input type="checkbox" name="selimg" value="y" checked/> Image
        <input type="checkbox" name="seldesc" value="y" checked/> Description
        <input type="checkbox" name="selqty" value="y" checked/> Quantity

        <input type="hidden" name="display">


        <input type="submit" value="Filter"> 

        &nbsp; &nbsp;

        or 

        &nbsp; &nbsp;

        <a href="filter_menu.php"> Show All Menu Items <a/>
            <br/><br/>

        </form>

        <!-- Repopulate tables after filtering-->
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Description</th>
                <th>Quantity</th>
            </tr>

            <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td>
                        <?php
                        if (isset($row['name'])) {
                            echo $row['name'];}
                            ?>
                        </td>

                        <td>
                            <?php 
                            if (isset($row['price'])) {
                                echo $row['price'];}
                                ?>
                            </td>

                            <td>
                                <?php 
                                if (isset($row['imagepath'])) {
                                    echo $row['imagepath'];}
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                    if (isset($row['description'])) {
                                        echo $row['description'];}
                                        ?>
                                    </td>

                                    <td>
                                        <?php 
                                        if (isset($row['quantity'])) {
                                            echo $row['quantity'];}
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile;?>
                            </table>

                        </body>
                        </html>