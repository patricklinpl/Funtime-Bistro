<?php include "base.php"; ?>
<!--Test Oracle file for UBC CPSC304 2011 Winter Term 2
  Created by Jiemin Zhang
  Modified by Simona Radu
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->
<p> <font size = "20" color = maroon >  Fun Time Bistro</font></p>

   

<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

function printResult($result) { //prints results from a select statement
	echo "<br>Got data from table Users:<br>";
	echo "<table>"	 ;
	echo "<tr>
	<th>Username</th><th>Type</th><th>Password</th><th>Name</th><th>Phone</th><th>Address</th><th>Createdate</th><th>uDelete</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr>
		<td>" . $row["USERNAME"] . "</td>
		<td>" . $row["TYPE"] . "</td>
		<td>" . $row["PASSWORD"] . "</td>
		<td>" . $row["NAME"] . "</td>
		<td>" . $row["PHONE"] . "</td>
		<td>" . $row["ADDRESS"] . "</td>
		<td>" . $row["CREATEDATE"] . "</td>
		<td>" . $row["U_DELETED"] . "</td>
		</tr>" ; //or just use "echo $row[0]" 
	}
	echo "</table>";

}

// Connect Oracle...
if ($db_conn) {

	// if (array_key_exists('reset', $_POST)) {
	// 	// Drop old table...
	// 	echo "<br> dropping table <br>";
	// 	executePlainSQL("Drop table tab1");

	// 	// Create new table...
	// 	echo "<br> creating new table <br>";
	// 	executePlainSQL("create table tab1 (userName varchar(20), password varchar(20), name varchar2(30), phone char(12), address Varchar(30), createDate Date, u_delete CHAR(1), primary key (userName))");
	// 	OCICommit($db_conn);

	//} else
		if (array_key_exists('insertsubmit', $_POST)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['insNo'],
				":bind2" => $_POST['insType'],
				":bind3" => $_POST['insPassword'],
				":bind4" => $_POST['insName'],
				":bind5" => $_POST['insPhone'],
				":bind6" => $_POST['insAddress'],
				":bind7" => $_POST['insCreatedate'],
				":bind8" => $_POST['insUdelete']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into tab1 values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8)", $alltuples);
			OCICommit($db_conn);

		} else
			if (array_key_exists('updatesubmit', $_POST)) {
				// Update tuple using data from user

				$tuple = array (
					":bind1" => $_POST['oldName'],
					":bind2" => $_POST['newName']

				);
				$alltuples = array (
					$tuple
				);
				executeBoundSQL("update tab1 set userName=:bind2 where userName=:bind1", $alltuples);
   				echo "Hello world foo";
				OCICommit($db_conn);

			} else
				if (array_key_exists('dostuff', $_POST)) {
					// Insert data into table...
					executePlainSQL("insert into tab1 values (10, 'Frank')");
					// Inserting data into table using bound variables
					$list1 = array (
						":bind1" => 6,
						":bind2" => "All"
					);
					$list2 = array (
						":bind1" => 7,
						":bind2" => "John"
					);
					$allrows = array (
						$list1,
						$list2

					);
					executeBoundSQL("insert into tab1 values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7)", $allrows); //the function takes a list of lists
					// Update data...
					//executePlainSQL("update tab1 set nid=10 where nid=2");
					// Delete data...
					//executePlainSQL("delete from tab1 where nid=1");
					OCICommit($db_conn);
				}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: oracle-test.php");
	} else {
		// Select data...
		$result = executePlainSQL("SELECT * FROM Users");
		printResult($result);

	}

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */

/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode */

/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */
?>

