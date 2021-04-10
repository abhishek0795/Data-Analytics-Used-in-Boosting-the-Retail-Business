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
			':user_id'	=>	$row[1],
            ':eval_set'	=>	$row[2],
            ':order_number' =>	$row[3],
            ':order_dow'	=>	$row[4],
            ':order_hour_of_day'	=>	$row[5],
			':days_since_prior_order' =>	$row[6]
		);

		$query = "
		INSERT INTO orders (order_id, user_id, eval_set, order_number, order_dow, order_hour_of_day,days_since_prior_order) 
    	VALUES (:order_id, :user_id, :eval_set, :order_number, :order_dow, :order_hour_of_day,:days_since_prior_order)
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