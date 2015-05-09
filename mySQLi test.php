<?php
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","dejonga-db","KlZLMGQrHb0blbkw","dejonga-db");
if (!$mysqli || $mysqli->connect_errno)
{
	echo "Connection error ".$mysqli->connect_errno ." ".$mysqli->connect_error;
}


$>