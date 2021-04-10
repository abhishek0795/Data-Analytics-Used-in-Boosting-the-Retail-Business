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
			':order_id'	=>	$row[0],
			':product_id' => $row[1],
            ':add_to_cart_order' =>	$row[2],
            ':reordered' =>	$row[3]		
		);

		$query = "
		INSERT INTO order_products__train (order_id, product_id, add_to_cart_order,	reordered) 
    	VALUES (:order_id,:product_id,:add_to_cart_order,:reordered)
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