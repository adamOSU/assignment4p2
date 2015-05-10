<?php
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "dejonga-db", "KlZLMGQrHb0blbkw", "dejonga-db");
if ($mysqli->connect_errno)
{
	echo "Connection error ".$mysqli->connect_errno ." ".$mysqli->connect_error;
}

$did = $_GET["delete"];

//deletes specified movie from the movies table
$stmt = $mysqli->prepare("DELETE FROM Movies WHERE id=?");
$stmt->bind_param("i", $did);
$stmt->execute();
$stmt->close();

echo '<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Assignment 4</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>


		<form action="addMovie.php" method="get">
			Title: <input type="text" name="title" required="required"><br>
			Category: <input type="text" name="cat"><br>
			Length: <input type="number" name="len"><br>
			<input type="submit" value="Add Movie"><br>
		</form><br><br>';

//selects the distinct categories in the list and outputs them into a dropdown menu
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
    <th>Title</th>
    <th>Category</th>
    <th>Length</th>
    <th>Rented</th>
  </tr>';

//queries the database and prints out all movies into a table
$stmt = $mysqli->prepare("SELECT * FROM Movies");
$stmt->execute();
$stmt->bind_result($result1, $result2, $result3, $result4, $result5);

while ($stmt->fetch())
{
	echo "<tr><td>$result2</td><td>$result3</td><td>$result4</td>";

	if ($result5 == 0)
	{
		echo "<td>Available</td>";
	}
	elseif ($result5 == 1)
	{
		echo "<td>Checked Out</td>";
	}
	echo "<td><form action=\"check.php\" method=\"get\"><input type=\"hidden\" name=\"$result1\" value=\"$result5\"><input type=\"submit\" value=\"Check In/Out\"></form></td><td><form action=\"delete.php\" method=\"get\"><input type=\"hidden\" name=\"delete\" value=\"$result1\"><input type=\"submit\" value=\"Delete Movie\"></form></td></tr>";
}
$stmt->close();

echo '</table>';
echo "<br><br><form action=\"deleteAll.php\" method=\"get\"><input type=\"submit\" value=\"Delete All Movies\"></form>";
echo "</body></html>";

$mysqli->close();
?>