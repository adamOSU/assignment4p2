<?php

echo '<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Assignment 4</title>
	</head>

	<body>


		<form action="addMovie.php" method="get">
			Title: <input type="text" name="title"><br>
			Category: <input type="text" name="cat"><br>
			Length: <input type="text" name="len"><br>
			<input type="submit" value="Add Movie"><br>
		</form>';

$mysqli = new mysqli("localhost", "root", "", "testdb");
if ($mysqli->connect_errno)
{
	echo "Connection error ".$mysqli->connect_errno ." ".$mysqli->connect_error;
}
else
{
	echo "Connection worked!";
}

echo '<form action="sortRes.php" method="get"><select name="category"><option value="all">All Movies</option>';

$stmt = $mysqli->prepare("SELECT DISTINCT category FROM Movies");
$stmt->execute();
$stmt->bind_result($catRes);
while ($stmt->fetch())
{
	echo "<option value=\"$catRes\">$catRes</option>";
}

$stmt->close();

echo '</select><input type="submit" value="Sort"></form>';

echo '<table>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Category</th>
    <th>Length</th>
    <th>Rented</th>
  </tr>';

$stmt = $mysqli->prepare("SELECT * FROM Movies");
$stmt->execute();
$stmt->bind_result($result1, $result2, $result3, $result4, $result5);

while ($stmt->fetch())
{
	echo "<tr><td>$result1</td><td>$result2</td><td>$result3</td><td>$result4</td><td>$result5</td><td><form action=\"check.php\" method=\"get\"><input type=\"hidden\" name=\"$result1\" value=\"$result5\"><input type=\"submit\" value=\"Check In/Out\"></form></td><td><form action=\"delete.php\" method=\"get\"><input type=\"hidden\" name=\"delete\" value=\"$result1\"><input type=\"submit\" value=\"Delete Movie\"></form></td></tr>";
}

$stmt->close();
$mysqli->close();
echo '</table></body></html>';

?>