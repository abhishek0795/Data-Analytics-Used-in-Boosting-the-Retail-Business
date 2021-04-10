<?php

//process.php

$connect = new PDO("mysql:host=localhost; dbname=analytics", "root", "");

$query = "SELECT * FROM order_products__prior";

$statement = $connect->prepare($query);

$statement->execute();

echo $statement->rowCount();

?>