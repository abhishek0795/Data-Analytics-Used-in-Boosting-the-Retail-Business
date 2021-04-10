<?php    
 if(isset($_POST["export_order_products__prior"]))  
 {  
      // CSV File Export

      $connect = mysqli_connect("localhost", "root", "", "analytics");  
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=order_products__prior.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('order_id', 'product_id', 'add_to_cart_order',	'reordered'));  
      $query = "SELECT * from order_products__prior";  
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?>