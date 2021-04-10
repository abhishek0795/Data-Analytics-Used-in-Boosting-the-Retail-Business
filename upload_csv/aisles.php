<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Typed.js-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/typed.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
    <style>
    
    a.active {
        background-color:red;
        color: white;
        }
    
    li a {
     display: block;
     color: #000;
     padding: 8px 16px;
     text-decoration: none;
     }
    /* Change the link color on hover */
    li a:hover {
    background-color: #4256c9;
    color: white;
    }
    
    </style>
    
    <title>Handling CSV File</title>
  
  </head>
  
  <body>
    <div class="sticky-top">
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
     <a class="navbar-brand">CSV File</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="../index.html">Home</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="./aisles.php">Aisles</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./departments.php">Departments</a>
      </li>
      </ul>
  </div>
  </nav>
  </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  
  <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Import, Export and Display CSV File Here!</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  </div>
  <h1 class="display-1 jumbotron-heading text-center"><span id="typed"></span></h1><br>
   <form method="post" enctype="multipart/form-data">
    <div class="form-group text-center">  
    <label>Select CSV File:</label>
    <input type="file" name="file" required/>
    <div class="container mt-4">
    <input type="submit" name="submit_aisles" value="Import" class="btn btn-info btn-lg"/>
    </div>
    </div>
    </form>
   <div class="form-group text-center">  
   <form method="post" enctype="multipart/form-data">
   <input type="submit" name="display" value="Display"class="btn btn-success btn-lg">
   </form>
   </div>
   <div class="container">
   <div class="form-group text-center"> 
  <form method="post" action="export.php" enctype="multipart/form-data">
  <input type="submit" name="export_aisles" value="Export" class="btn btn-danger btn-lg">
  </form>
  </div>
  </div>
  <div class="container mt-5">
  <h1 class="h1 text-center">Displaying Aisles CSV Data From MySQL Database</h1>  
  </div>
  <div class="container mt-4">
  <table class="table table-striped" style="border-collapse: collapse;width: 100%;color:#9b870c;font-family: monospace;font-size: 25px;text-align: left;">
  <tr style="background-color: #f2f2f2">
  <th width="45%" style="background-color: purple;color: white;">Aisle_Id</th>
  <th style="background-color: purple;color: white;">Aisle</th>
  </tr>
<div id="typed-strings">
</div> 
  <script>
     var typed = new Typed('#typed',{
                    strings:["Upload CSV File Here!","The CSV File Data will Fetch From MySql Database"],
                    backSpeed: 15,
                    smartBackspace: true,
                    backDelay: 1200,
                    startDelay: 1000,
                    typeSpeed: 25,
                    loop: false,
                  }) 
  </script> 
  </body>
</html>

<!--CSV File Import -->
<?php
// Check connection  
$connect = mysqli_connect("localhost", "root", "", "analytics");
if(isset($_POST["submit_aisles"]))
{
 if($_FILES['file']['name'])
 {
  $filename = explode(".", $_FILES['file']['name']);
  if($filename[1] == 'csv')
  {
   $handle = fopen($_FILES['file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
    $item1 = mysqli_real_escape_string($connect, $data[0]);  
                
                $query = "INSERT into aisles(aisle) values('$item1')";
                mysqli_query($connect,$query);
   }
   fclose($handle);
   echo "<script>alert('File Imported');</script>";
  }
  else{
     echo "<script>alert('Invalid File Extention');</script>";
   }
 }
}
?>

<!-- CSV File Display -->
 <?php
  $conn = mysqli_connect("localhost", "root", "", "analytics");
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM aisles";
  $result = $conn->query($sql);
  if(isset($_POST["display"])){
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["aisle_id"]. "</td><td>" . $row["aisle"] ."</td></tr>";
    }}
  echo "<table>";
  $conn->close();
  ?>
  
  
  