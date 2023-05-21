<?php 
	$server = 'localhost';
	$dbname = 'nutriplan';
	$user = 'root';
	$pass = '';

	$conn = mysqli_connect($server, $user, $pass, $dbname);

	if (!$conn){
		die ("Błąd połączenia z bazą ". mysqli_connect_error());
	}
 ?>