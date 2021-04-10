<?php

//import.php

header('Content-type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");

set_time_limit(0);

ob_implicit_flush(1);

session_start();

if(isset($_SESSION['csv_file_name']))
{
	$connect = new PDO("mysql:host=localhost; dbname=analytics", "root", "");

	$file_data = fopen('file/' . $_SESSION['csv_file_name'], 'r');

	fgetcsv($file_data);

	while($row = fgetcsv($file_data))
	{
		$data = array(
			':product_name'	=>	$row[0],
			':aisle_id'	=>	$row[1],
            ':department_id'	=>	$row[2]	
		);

		$query = "
		INSERT INTO products (product_name,aisle_id,department_id) 
    	VALUES (:product_name,:aisle_id,:department_id)
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		sleep(1);

		if(ob_get_level() > 0)
		{
			ob_end_flush();
		}
	}

	unset($_SESSION['csv_file_name']);
}

?>