<?php    
 if(isset($_POST["export_aisles"]))  
 {  
      // CSV File Export 

      $connect = mysqli_connect("localhost", "root", "", "analytics");  
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=aisles.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('aisle_id', 'aisle'));  
      $query = "SELECT * from aisles";  
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?><?php    
 if(isset($_POST["export_departments"]))  
 {  
      // CSV File Export

      $connect = mysqli_connect("localhost", "root", "", "analytics");  
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=departments.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('department_id', 'department'));  
      $query = "SELECT * from departments";  
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?>