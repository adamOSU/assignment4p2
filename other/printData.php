<?php
$mysqli = new mysqli("localhost", "root", "", "testdb");
if ($mysqli->connect_errno)
{
	echo "Connection error ".$mysqli->connect_errno ." ".$mysqli->connect_error;
}
else
{
	echo "Connection worked!";
}

$stmt = $mysqli->prepare("SELECT * FROM Movies");
$stmt->execute();
$stmt->bind_result($results)

while ($stmt->fetch())
{
	echo $results. "<br>";
}

$stmt->close();

?>