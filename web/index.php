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

<?php 
	$ini_array = parse_ini_file($config_file_path);
	$dbname=$ini_array['dbname'];
	$dbhost=$ini_array['dbhost'];
	$dbuser=$ini_array['dbuser'];
	$dbpass=$ini_array['dbpassword'];
	
	$rmhost=$ini_array['resourcemanagerhost'];
	$rmport=$ini_array['resourcemanagerport'];

?>

	<div id="canvas_brd">
		<table width="100%">
			<tr>
				<td colspan=2><canvas id="polar-area" width=800 height=150 /></td>	
			</tr>		
			<tr>
				<td colspan=2><center>Last 10 days Application Statistics</center></td>	
			</tr>			
			<tr>
				<td>&nbsp;<br /><canvas id="chart-area" width=200 height=200 /></td>
				<td>
					<div id="rmvals">
						<table class=".alert-data">
								<?php
								$statsurl  ="http://" . $rmhost . ":" . $rmport . "/ws/v1/cluster/info"	;
								$statscont = file_get_contents($statsurl)				;
								$enstats   = utf8_encode($statscont)					;
								$statsobj  = json_decode($enstats,true)					;			
								$startOn = ($statsobj['clusterInfo']['startedOn'])/1000	;
								$t=microtime(true);			
								$epoch = $t - $startOn;
								$flrepoch=floor($epoch);
								$dt = new DateTime("@$flrepoch");								
								?>
								<tr>
								<td>Resource Manager Uptime</td>
								<td >: <?php echo date_format($dt,"d \D\a\y\s H \H\o\u\\r\s i \M\i\\n\u\\t\\e\s s \S\\e\c\s")?></td>
								</tr>
								<tr><td>Resource Manager State</td><td>: <?php echo $statsobj['clusterInfo']['state'];?></td></tr>
								<tr><td>Resource Manager High Availability State</td><td>: <?php echo $statsobj['clusterInfo']['haState']; ?></td></tr>
								<?php
								$statsurl  ="http://" . $rmhost . ":" . $rmport . "/ws/v1/cluster/metrics"	;
								$statscont = file_get_contents($statsurl)				;
								$enstats   = utf8_encode($statscont)					;
								$statsobj  = json_decode($enstats,true)					;
								?>
								<tr><td>Total Nodes</td><td>: <?php echo $statsobj['clusterMetrics']['totalNodes'];?></td></tr>
								<tr><td>Active Nodes</td><td>: <?php echo $statsobj['clusterMetrics']['activeNodes'];?></td></tr>
								<tr><td>Lost Nodes</td><td>: <?php echo $statsobj['clusterMetrics']['lostNodes'];?></td></tr>
								<tr><td>Unhealthy Nodes</td><td>: <?php echo $statsobj['clusterMetrics']['unhealthyNodes'];?></td></tr>
								<tr><td>Decommissioned Nodes</td><td>: <?php echo $statsobj['clusterMetrics']['decommissionedNodes']; ?></td></tr>
						</table>
					</div>
				</td>
			</tr>			
			<tr>
				<td>Total Application Statistics</td><td><center>Resource Manager Cluster Information</center></td>
			</tr>
		</table>		
	</div>
		<script>
		var ctx  = document.getElementById("chart-area").getContext("2d"); 
		var ctx1 = document.getElementById("polar-area").getContext("2d");

			var gradient_suc = ctx1.createLinearGradient(200, 200, 200, 300);
				gradient_suc.addColorStop(0, 	'rgba(155,232,100,10)'); 				
				gradient_suc.addColorStop(.5, 	'rgba(155,232,100,50)'); 				
				gradient_suc.addColorStop(1, 	'rgba(155,232,100,80)');
				
		    var gradient_fail = ctx1.createLinearGradient(200, 200, 200, 300);
				gradient_fail.addColorStop(0, 	'rgba(246,41,12,10)'); 	
				gradient_fail.addColorStop(.5, 	'rgba(246,41,12,50)'); 				
				gradient_fail.addColorStop(1, 	'rgba(246,41,12,80)');				
		    
			var gradient_kill = ctx1.createLinearGradient(200, 200, 200, 300);
				gradient_kill.addColorStop(0, 	'rgba(73,155,234,10)'); 	
				gradient_kill.addColorStop(.5, 	'rgba(73,155,234,50)'); 				
				gradient_kill.addColorStop(1, 	'rgba(73,155,234,80)');
		
		var pieData = [
				{ value: <?php echo getStateCount($rmhost, $rmport, "killed");?>,		color:gradient_kill,highlight: "rgba(151,187,205,0.75)",label: "Killed"	},
				{ value: <?php echo getStateCount($rmhost, $rmport, "finished");?>,	color:gradient_suc,highlight: "rgba(155,232,100,.8)",label: "Finished"	},
				{ value: <?php echo getStateCount($rmhost, $rmport, "failed");?>,		color:"#D00000",highlight: "#E80000",label: "Failed"	}
			];

			
			<?php 
			$labels 		= "";
			$success_vals	= "";
			$fail_vals		= "";
			$kill_vals		= "";
							 					
					 try { 
					   $conn = new PDO("pgsql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
					 
					//echo "<br />" .date("Y, jS F",  $row['rep_date']);
					
					}catch (Exception $pe) {						
						die("Could not connect to the database $dbname :" . $pe->getMessage());
					}
					$sql = "select rep_date, 					 sum(case when app_final_status  = 'SUCCEEDED' 	then count else 0 end) as succeeded, 					 sum(case when app_final_status  = 'FAILED' 		then count else 0 end) as failed, 					 sum(case when app_final_status  = 'KILLED' 		then count else 0 end) as killed 					 from view_report group by rep_date order by rep_date desc limit 10;";
					foreach($conn->query($sql) as $row){
						$labels 		= '"' . date("jS M Y",  strtotime($row['rep_date'])) . '",' . $labels ;
						$success_vals	= $row['succeeded']. "," . $success_vals;
						$fail_vals		= $row['failed']. "," . $fail_vals;
						$kill_vals		= $row['killed']. "," . $kill_vals;
					}
					
			?>
	var bardata = {
			labels: [<?php echo $labels; ?>],
			datasets: [
				{
					label			: "Success",
					fillColor		: gradient_suc,
					strokeColor		: "rgba(155,232,100,.8)",
					highlightFill	: "rgba(155,232,100,.8)",
					highlightStroke	: gradient_suc,	
					data: [<?php echo $success_vals; ?>]
				},
				{
					label			: "Failed",
					fillColor		: gradient_fail,
					strokeColor		: "rgba(246,41,0,.5)",
					highlightFill	: "rgba(246,41,0,.5)",
					highlightStroke	: gradient_fail,
					data: [<?php echo $fail_vals; ?>]
				},
				{
					label			: "Killed",
					fillColor		: gradient_kill,
					strokeColor		: "rgba(151,187,205,0.8)",
					highlightFill	: "rgba(151,187,205,0.75)",
					highlightStroke	: gradient_kill,
					data: [<?php echo $kill_vals; ?>]
				}
			]
		};			
				window.myPie = new Chart(ctx).Doughnut(pieData);
				window.mybar = new Chart(ctx1).Bar(bardata,{scaleGridLineWidth : 2,barStrokeWidth :1,barDatasetSpacing : 3,barValueSpacing : 40,responsive : true,animationEasing: "easeInBounce"
				});
				
	</script>	
</body>
</html>
