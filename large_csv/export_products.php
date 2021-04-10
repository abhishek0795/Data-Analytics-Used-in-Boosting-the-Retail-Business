<?php    
 if(isset($_POST["export_products"]))  
 {  
      // CSV File Export

      $connect = mysqli_connect("localhost", "root", "", "analytics");  
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=products.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('product_id','product_name','aisle_id','department_id'));  
      $query = "SELECT * from products";  
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?>