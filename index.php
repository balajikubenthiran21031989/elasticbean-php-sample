<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<body background="images/2.png" style="background-repeat:no-repeat;
background-size: 100% 100%">
<br><br><br><br>
<div class="container">
  <div class="jumbotron vertical-center">
  	<table class="grid" cellspacing="0">
  		<tr>
  <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td colspan="4">
<!-- Input form -->
  	<form method="post">
  <div class="form-group" action="post">
    <label for="firstname">Name:</label>
    <input type="text" class="form-control" name="firstname">
  </div>
  <div class="form-group" action="post">
    <label for="lastname">Name:</label>
    <input type="text" class="form-control" name="lasttname">
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="text" class="form-control" name="email">
  </div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success">Submit</button>
</form></td>  
  <td colspan="4"></td>
</tr>
</table>
<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    	<td>ID</td>
    	<td>FIRSTNAME</td>
    	<td>LASTNAME</td>
	<td>EMAIL</td>
  </tr>

<?php

$result = mysqli_query($conn, "SELECT * FROM PERSON");

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
       "<td>",$query_data[3], "</td>";
  echo "</tr>";
}
?>
</table>
</div>
</div>

<!-- Clean up. -->
<?php
	mysqli_free_result($result);
	mysqli_close($conn)
?>
<?php
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$email=$_POST['email'];

/* Connect ti MySQL and select the database. */
// Create connection
$conn = new mysqli(getenv('RDS_HOSTNAME'), getenv('RDS_USERNAME'), getenv('RDS_PASSWORD'));
// Check connection
if ($conn->connect_error) {
	echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
$database = mysqli_select_db($conn,getenv('RDS_DATABASE'));

/* If input fields are populated, add a row to the PERSON table. */
  	$firstname = htmlentities($_POST['firstname']);
	$lastname = htmlentities($_POST['lastname']);
	$email = htmlentities($_POST['email']);


  if (strlen($firstname) || strlen($lastname)) || strlen($email) {
    AddPerson($conn, $firstname, $lastname,$email);
  }
}
?>


<?php
/* Add person info to the table. */
function Addperson($conn,$firstname,$lastname,$email) {
	$f = mysqli_real_escape_string($conn, $firstname);
	$l = mysqli_real_escape_string($conn, $lastname);
	$e = mysqli_real_escape_string($conn, $email);
if(isset($_POST['firstname']) && (isset($_POST['lastname']) && isset($_POST['email'])){
$sql = "INSERT INTO data (firstname,lastname,email) VALUES ('$f','$l','$e')";

if ($conn->query($sql) === TRUE) {
    echo "Person Details added successfully";
} else {
	if(!mysqli_query($conn,$sql))
    echo "<p>Error adding person data.</p>" . $sql . "<br>" . $conn->error;
}

/* Check whether the table exists and, if not, create it. */
function VerifyPersonTable($conn, $dbName) {
  if(!TableExists("Person", $conn, $dbName))
  {
     $sql = "CREATE TABLE PERSON (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	 FIRSTNAME VARCHAR(45),
	 LASTNAME VARCHAR(45),
         EMAIL VARCHAR(90)
       )";

     if(!mysqli_query($conn, $sql)) echo("<p>Error creating table.</p>");
  }
}

/* Check for the existence of a table */
function TableExists($tableName,$conn,$dbName) {
	$t = mysqli_real_escape_string($conn, $tableName);
  	$d = mysqli_real_escape_string($conn, $dbName);

  $checktable = mysqli_query($conn,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>
</body>
</html>
