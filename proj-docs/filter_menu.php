<?php

// create the array (for viewing the form)
$form = array( 
    'namebox' => true, // default to checked
    'pricebox' => true, // default to checked
    'imgbox' => true, // default to checked
    'descbox' => true, // default to checked
    'qtybox' => true // default to checked
);


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
        $form['namebox'] = false;
    } 

    if(!isset($_POST['selprice'])) {
        $price = "";
        $form['pricebox'] = false;
    } 

    if(!isset($_POST['selimg'])) {
        $img = "";
        $form['imgbox'] = false;
    } 

    if(!isset($_POST['seldesc'])) {
        $desc = "";
        $form['descbox'] = false;
    } 

    if(!isset($_POST['selqty'])) {
        $qty = "";
        $form['qtybox'] = false;
    } 

    // remvove the last comma from select statement
    $att = rtrim("$name $price $img $desc $qty", ', '); 

    $query = "SELECT $att FROM MenuItem WHERE $col $operator $num AND m_deleted = 'F'";

    $search_result = filterTable($query);


} else {
    $query = "SELECT name, price, imagepath, description, quantity FROM MenuItem WHERE m_deleted = 'F'";
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

        <input type="checkbox" name="selname" value="yes" <?php echo $form['namebox'] ? 'checked' : '' ?> />Name
        <input type="checkbox" name="selprice" value="yes" <?php echo $form['pricebox'] ? 'checked' : '' ?> /> Price
        <input type="checkbox" name="selimg" value="yes" <?php echo $form['imgbox'] ? 'checked' : '' ?>/> Image
        <input type="checkbox" name="seldesc" value="yes" <?php echo $form['descbox'] ? 'checked' : '' ?>/> Description
        <input type="checkbox" name="selqty" value="yes" <?php echo $form['qtybox'] ? 'checked' : '' ?>/> Quantity

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