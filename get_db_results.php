<?php 

function getResults($data)

{
	require 'database.php';

	$records = $conn->prepare('SELECT user_id,email_address,password,username FROM users WHERE $data = :$data');
	$records->bindParam(':$data', $_POST['$data']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	return $results;

}


?>