<html>
<title>Applerts :: Application Alerts</title>
<head>
 <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./css/jquery.dataTables.min.css"> </link>
		<link rel="stylesheet" type="text/css" href="./css/default.css"> </link>
		<link rel="stylesheet" type="text/css" href="./css/menu-styles.css"></link>
		<script src="./js/Chart.js"></script>
</head>
<body>
<?php include('funcs.php')			; ?>
<?php include('menu.php')			; ?>
<?php include('globalconfig.php')	; ?>

<div id="config-form">
		<table class="alert-data" class="display" cellspacing="0" width="100%">
			<thead><tr><th>Serial</th><th>Application Name</th><th>Email Address</th></tr></thead>
			<tfoot><tr><th>Serial</th><th>Application Name</th><th>Email Address</th></tr></tfoot>
		<?php
		 $ini_array = parse_ini_file($config_file_path);
		$dbname=$ini_array['dbname'];
		$dbhost=$ini_array['dbhost'];
		$dbuser=$ini_array['dbuser'];
		$dbpass=$ini_array['dbpasswordd'];
		 try { 
		   $conn = new PDO("pgsql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
		   $pquery		= "select * from alerts order by id desc;";
		   //$res = pgquery("select * from alerts order by id desc;");
		 }catch (Exception $pe) {
			die("Could not connect to the database $dbname :" . $pe->getMessage());
		}
		foreach($conn->query($pquery) as $row) {
			
		?>			
			<tr><td><?php echo $row['id']; ?></td><td><?php echo $row['app_name']; ?></td><td><?php echo $row['email']; ?></td></tr>
		<?php } ?>	
		</table>

</div>
	 <script type="text/javascript" charset="utf8" src="./js/jquery-2.1.4.min.js"></script>
	 <script type="text/javascript" charset="utf8" src="./js/jquery.dataTables.min.js"></script>
	 <script>$(document).ready(function() {
		$('#alert-data').DataTable();
	} );</script>	
</body>
</html>
