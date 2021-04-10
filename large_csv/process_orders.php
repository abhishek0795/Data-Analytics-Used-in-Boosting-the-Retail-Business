<?php

//process.php

$connect = new PDO("mysql:host=localhost; dbname=analytics", "root", "");

$query = "SELECT * FROM orders";

$statement = $connect->prepare($query);

$statement->execute();

echo $statement->rowCount();

?>