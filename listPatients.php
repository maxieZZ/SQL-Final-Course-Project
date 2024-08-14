<?php
include('connectionData.txt');
$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');
?>

<html>
<head>
       <title>HOSPITAL MANAGEMENT DATABASE</title>
</head>

<body bgcolor="white">

<h3>Hospital Patient Information</h3>

<hr>

<?php

$query = "SELECT p.fname, p.lname, p.age, p.diagnosis e.fname, e.lname, d.department FROM patient p JOIN employee e USING(essn) JOIN doctor d USING(essn) ORDER BY p.fname, p.lname ";

?>

<p>
The query:
<p>
<?php
print $query;
?>

<hr>
<p>
Result of query:
<p>

<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

print "<pre>";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
  {
    print "\n";
    print "$row[firstName]  $row[lastName] $row[age] $row[diagnosis] $row[DoctorfirstName] $row[DoctorlastName] $row[DoctorDepartment]";
  }
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
<a href="findCustState.txt" >Contents</a>
of the PHP program that created this page. 	 
 
</body>
</html>