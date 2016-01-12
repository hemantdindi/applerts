<html>
<title>Applerts :: Application Alerts</title>
<head>
 <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./css/jquery.dataTables.min.css"> </link>
		<link rel="stylesheet" type="text/css" href="./css/default.css"> </link>
		<link rel="stylesheet" type="text/css" href="./css/menu-styles.css"></link>
				<script src="./js/jquery-2.1.4.min.js"></script>
		<script src="./js/Chart.js"></script>
				<script src="./js/zelect.js"></script>
	
  <script>
    $(setup)
    function setup() {
      $('#intro select').zelect({ placeholder:'Select Application Name' })
    }
  </script>
</head>
<body>
<?php include('funcs.php')			; ?>
<?php include('menu.php')			; ?>
<?php include('globalconfig.php')	; ?>

<?php
$ini_array = parse_ini_file($config_file_path);
$dbname=$ini_array['dbname'];
$dbhost=$ini_array['dbhost'];
$dbuser=$ini_array['dbuser'];
$dbpass=$ini_array['dbpasswd'];

?>
<div id="config-form">
Select Application<br />
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>	
<tr>
	<td>Application Name</td>
	<td>
	<section id="intro">
		<select  name="apps" style="width: 600px">
		<?php
		 try { 
			$conn = new PDO("pgsql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
			$query='select distinct app_name from applerts_db order by app_name asc;';
		foreach($conn->query($query) as $row) {
			?>  
			<option value="<?php echo $row['app_name']; ?>"><?php echo $row['app_name']; ?></option>
			<?php
		}
		}catch (Exception $pe) {
		die("Could not connect to the database $dbname :" . $pe->getMessage());
		}
		$conn=null;
		?>
		</select>
	</section>
	</td><td rowspan="2"><!--- Additional Information---></td>
</tr>	
</div>	
<tr>
	<td colspan="2">
		<input type="submit" Value="Report"/>
	</td>
</tr>
</table>
</form>
<div class="appselected"> &nbsp;</div>
<hr />
<canvas id="app-runs" width=1024 height=400/>
</div>
<?php
	$labels="";
	$elptme="";
	$exe_avgdata ="";
	$executions=0;
	$avgextime=0;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//document.getElementById('appselected').innerHTML = htmlspecialchars($_POST["apps"]) . "<br />"; ?>
		<script> $("div.appselected").html=(<?php echo htmlspecialchars($_POST["apps"]) ?>);</script>
		<?php try { 
			$conn = new PDO("pgsql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
			$sqlquery="select app_start_time,app_elapsed_time from applerts_db where app_name='" . htmlspecialchars($_POST["apps"]) . "' order by app_start_time desc;";			
			$sqlquery2="select count(*) as executions, avg(cast(app_elapsed_time as NUMERIC)) as avgextime  FROM applerts_db where app_name='" . htmlspecialchars($_POST["apps"]) . "' group by app_name ;";
		}catch (Exception $pe) {
		die("Could not connect to the database $dbname :" . $pe->getMessage());
		}
		foreach($conn->query($sqlquery2) as $row2){ 
		$executions = $row2['executions'];
		$avgextime	= $row2['avgextime'];
		}		
		
		foreach($conn->query($sqlquery) as $row){
			$labels 		= '"' . date("jS M",  strtotime($row['app_start_time'])) . '",' . $labels ;
			$elptme			= $row['app_elapsed_time']. "," .$elptme;
			$exe_avgdata 		= $avgextime . "," . $exe_avgdata;
		}	
		

		

				
			//$result=$conn->query($query);		
			?>
			<script>
				var ctx  = document.getElementById("app-runs").getContext("2d"); 

				var data = {
					labels: [<?php echo $labels; ?>],
					datasets: [
						{
							label: "My First dataset",
							fillColor: "rgba(248,248,255,.2)",
							strokeColor: "rgba(246,41,12,.5)",
							pointColor: "rgba(246,41,12,.5",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(246,41,12,1)",
							scaleLineWidth: 1,
							data: [<?php echo $exe_avgdata; ?>]
						},					
						{
							label: "My Second dataset",
							fillColor: "rgba(151,187,205,0.2)",
							strokeColor: "rgba(151,187,205,1)",
							pointColor: "rgba(151,187,205,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(151,187,205,1)",
							data: [<?php echo $elptme; ?>]
						}						
					]
				};
				var myLineChart = new Chart(ctx).Line(data, {
					bezierCurve: false
				});
				$( "div.appselected" ).text("Application Name : <?php echo htmlspecialchars($_POST["apps"]); ?>");
			</script>
			<?php		
	echo $exe_data;			
		$conn=null;
	}
	
?>
	
</body>
</html>
