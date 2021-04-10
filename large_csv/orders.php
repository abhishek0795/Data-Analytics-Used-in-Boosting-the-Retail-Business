<!DOCTYPE html>
<html>
	<head>
	    <!--Typed.js-->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/typed.js"></script>
        <title>Handling Large CSV File Data</title>		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
		</script>
		<style>
		a.active {
        background-color:#e3eae4;
        color: black;
        }
        </style>
	</head>
	<body>
		<!-- Fixed navbar -->
	<div class="sticky-top">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Large CSV File</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
			<li><a href="../index.html">Home</a></li>
            <li><a href="./products.php">Products</a></li>
			<li><a class="active" href="./orders.php">Orders<span class="sr-only">(current)</span>
		    </a></li>
            <li><a href="./order_products__prior.php">Order_Products__Prior</a></li>
			<li><a href="./order_products__train.php">Order_Products__Train</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
</div>
		<br />
		<br />
		<h1 style="color:Brown;" class="jumbotron-heading text-center"><span id="typed"></span></h1><br>
		<div class="container">
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Import, Display and Export CSV File Data</h3>
				</div>
  				<div class="panel-body">
  					<span id="message"></span>
  					<form id="sample_form" method="POST" enctype="multipart/form-data" class="form-horizontal">
  						<div class="form-group">
  							<label class="col-md-4 control-label">Select CSV File</label>
  							<input type="file" name="file" id="file" />
  						</div>
  						<div class="form-group" align="center">
  							<input type="hidden" name="hidden_field" value="1" />
  							<input type="submit" name="import" id="import" class="btn btn-warning" value="Import" />
  						</div>
  					</form>
					<div class="form-group" align="center">
						<form method="post" enctype="multipart/form-data">
                        <input type="submit" name="display" value="Display"class="btn btn-success">
						</form>
					</div>
					<div class="form-group text-center"> 
                    <form method="post" action="export_orders.php" enctype="multipart/form-data">
                    <input type="submit" name="export_orders" value="Export" class="btn btn-danger">
                    </form>
                    </div>
  					<div class="form-group" id="process" style="display:none;">
  						<div class="progress">
  							<div class="progress-bar progress-bar-striped active" role="progressbar" role="progressbar" aria-valuemin="0" aria-valuemax="100">
  								<span id="process_data">0</span> - <span id="total_data">0</span>
  							</div>
  						</div>
  					</div>
  				</div>
  			</div>
		</div>
		<div class="container-fluid">
        <h1 style="color:#262496" class="text-center">Displaying Orders CSV Data From MySQL Database </h1>
        <table class="table table-striped" style="border-collapse: collapse;width: 100%;color:#9b870c;font-family: monospace;font-size: 25px;text-align: left;">
        <tr style="background-color: #f2f2f2">
        <th width="15%" style="background-color: purple;color: white;">Order_Id</th>
        <th width="15%" style="background-color: purple;color: white;">User_Id</th>            
        <th width="15%" style="background-color: purple;color: white;">Eval_Set</th>
        <th width="15%" style="background-color: purple;color: white;">Order_Number</th>
        <th width="15%" style="background-color: purple;color: white;">Order_DOW</th>
        <th width="25%" style="background-color: purple;color: white;">Order_Hour_of_Day</th>
        <th width="20%" style="background-color: purple;color: white;">Days_Since_Prior_Order</th>
        </tr>
	</body>
</html>
<div id="typed-strings">
</div> 
  <script>
     var typed = new Typed('#typed',{
                    strings:["Upload CSV File Here!","The Large CSV File Data will Fetch From MySql Database"],
                    backSpeed: 15,
                    smartBackspace: true,
                    backDelay: 1200,
                    startDelay: 1000,
                    typeSpeed: 25,
                    loop: false,

                  }) 
  </script>            
<script>
	
	$(document).ready(function(){

		var clear_timer;

		$('#sample_form').on('submit', function(event){
			$('#message').html('');
			event.preventDefault();
			$.ajax({
				url:"upload_orders.php",
				method:"POST",
				data: new FormData(this),
				dataType:"json",
				contentType:false,
				cache:false,
				processData:false,
				beforeSend:function(){
					$('#import').attr('disabled','disabled');
					$('#import').val('Importing');
				},
				success:function(data)
				{
					if(data.success)
					{
						$('#total_data').text(data.total_line);

						start_import();

						clear_timer = setInterval(get_import_data, 2000);

						//$('#message').html('<div class="alert alert-success">CSV File Uploaded</div>');
					}
					if(data.error)
					{
						$('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
						$('#import').attr('disabled',false);
						$('#import').val('Import');
					}
				}
			})
		});

		function start_import()
		{
			$('#process').css('display', 'block');
			$.ajax({
				url:"import_orders.php",
				success:function()
				{

				}
			})
		}

		function get_import_data()
		{
			$.ajax({
				url:"process_orders.php",
				success:function(data)
				{
					var total_data = $('#total_data').text();
					var width = Math.round((data/total_data)*100);
					$('#process_data').text(data);
					$('.progress-bar').css('width', width + '%');
					if(width >= 100)
					{
						clearInterval(clear_timer);
						$('#process').css('display', 'none');
						$('#file').val('');
						$('#message').html('<div class="alert alert-success">Data Successfully Imported</div>');
						$('#import').attr('disabled',false);
						$('#import').val('Import');
					}
				}
			})
		}

	});
</script>
<!-- CSV File Display -->
 <?php
  $conn = mysqli_connect("localhost", "root", "", "analytics");
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM orders";
  $result = $conn->query($sql);
  if(isset($_POST["display"])){
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["order_id"]. "</td><td>" . $row["user_id"]. "</td><td>" .$row["eval_set"]."</td><td>" . $row["order_number"]."</td><td>" . $row["order_dow"]."</td><td>" .$row["order_hour_of_day"]."</td><td>" .$row["days_since_prior_order"]."</td></tr>";
    }}
  echo "<table>";
  $conn->close();
  ?>
  
