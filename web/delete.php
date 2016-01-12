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
<style>

</style>		
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
$dbpass=$ini_array['dbpassword'];

?>
<div id="config-form">
Delete Alert<br />
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>	
<tr><td>Application Name</td>
	<td>
	<section id="intro">
		<select  name="apps" style="width: 600px">
		<?php
		 try { 
			$conn = new PDO("pgsql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
			$query='select app_name from alerts order by app_name;';
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
	</td>
</tr>	
</div>	
<tr>
	<td colspan="2">
		<input type="submit" Value="Delete"/>
	</td>
</tr>
</table>
</form>
</div>
<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		try { 
			$conn = new PDO("pgsql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
			$query="delete from alerts where app_name='" . htmlspecialchars($_POST["apps"]) . "';";
			$result=$conn->query($query);
			?>
				<script type="text/javascript">
					alert("Alert Deleted Successfully");
					window.location="./view.php";
				</script>
				<?php
		}catch (Exception $pe) {
		die("Could not connect to the database $dbname :" . $pe->getMessage());
		}
		$conn=null;
	//echo $query;
	}
	
?>
</body>
</html>