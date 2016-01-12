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
	<table id="joblist" class="display" cellspacing="0" width="100%"> 
		  <thead> 
				 <tr> 
					<th>Application ID</th><th>User</th><th>Application Name</th><th>Final Status</th><th>Start Time</th><th>Finished Time</th><th>Elapsed Time (in ms)</th>
				 </tr> 
		   </thead>    
		   <tfoot> 
				<tr> 
					<th>Application ID</th><th>User</th><th>Application Name</th><th>Final Status</th><th>Start Time</th><th>Finished Time</th><th>Elapsed Time (in ms)</th> 
				</tr>  
		   </tfoot>

<?php		
		$ini_array = parse_ini_file($config_file_path);
		$dbname=$ini_array['dbname'];
		$dbhost=$ini_array['dbhost'];
		$dbuser=$ini_array['dbuser'];
		$dbpass=$ini_array['dbpassword'];
		
		 try { 
		   $conn = new PDO("pgsql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
		   $pquery		= "select app_id,app_user,app_name,app_final_status,app_start_time,app_finish_time,app_elapsed_time from applerts_db;";		   
		   
		   foreach($conn->query($pquery) as $row) {
			   ?>
				<tr>
					<td><?php echo $row['app_id'];?></td>
					<td><?php echo $row['app_user'];?></td>
					<td><?php echo $row['app_name'];?></td>
					<td><?php echo $row['app_final_status'];?></td>
					<td><?php echo $row['app_start_time'];?></td>
					<td><?php echo $row['app_finish_time'];?></td>
					<td><?php echo $row['app_elapsed_time'];?></td>
				</tr>
			   <?php
		   }
		   //$res = pgquery("select * from alerts order by id desc;");
		 }catch (Exception $pe) {
			die("Could not connect to the database $dbname :" . $pe->getMessage());
		}
?>
		   
	</table>
	
	 <script type="text/javascript" charset="utf8" src="./js/jquery-2.1.4.min.js"></script>
	 <script type="text/javascript" charset="utf8" src="./js/jquery.dataTables.min.js"></script>
	 <script>$(document).ready(function() {
		$('#joblist').DataTable({"order": [[ 4, "desc" ]]});
	} );</script>		   
</div>
	
</body>
</html>
