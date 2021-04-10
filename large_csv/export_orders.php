<?php    
 if(isset($_POST["export_orders"]))  
 {  
      // CSV File Export

      $connect = mysqli_connect("localhost", "root", "", "analytics");  
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=orders.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('order_id','user_id','eval_set','order_number','order_dow',	'order_hour_of_day','days_since_prior_order'));  
      $query = "SELECT * from orders";  
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?>