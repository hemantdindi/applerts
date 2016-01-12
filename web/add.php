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

$appname	= "&nbsp;"	;
$appemail	= "&nbsp;"	;
$process	= false		;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$process	= true		;
    if (empty($_POST["appname"])) {
        $appname = "Specify the Application Name";
		$process=false;
    }
    if (empty($_POST["email"])) {
        $appemail = "Specify the Email Address";
		$process=false;		
    } else {
		if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
			$appemail = "Invalid Email Address";
			$process=false;				
		}		
	}
	}
	if ($process){
			 $ini_array = parse_ini_file($config_file_path);
			$dbname=$ini_array['dbname'];
			$dbhost=$ini_array['dbhost'];
			$dbuser=$ini_array['dbuser'];
			$dbpass=$ini_array['dbpassword'];
			 try { 
			   $conn = new PDO("pgsql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
			   $app=$_POST["appname"];
			   $eml=$_POST["email"];
			   $query="insert into alerts values(DEFAULT,'$app','$eml','enabled')";
			   $result=$conn->query($query);
				
				?>
				<script type="text/javascript">
					alert("Alert Added Successfully");
					window.location="./view.php";
				</script>
				<?php
			 }catch (Exception $pe) {
				die("Could not connect to the database $dbname :" . $pe->getMessage());
			}
			$conn=null;
	}	
?>

<div id="config-form">
Configure a new alert<br />
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<table>	
<tr><td>Application Name</td>
	<td><input type="text" name="appname" size="100" value="<?php echo $_POST["appname"]?>"><span class="must">* <br /><?php echo $appname;?></span> </td>
</tr>	
<tr><td>Email</td>
	<td><input type="text" name="email" size="100" value="<?php echo $_POST["email"]?>"><span class="must">* <br /><?php echo $appemail;?></span></td>		
</tr>
<tr>
	<td colspan="2">
		<input type="submit" class="ft" Value="Save"/>
	</td>
</tr>
</table>
</form>
NOTE: Field marked as <span class="must">*</span> are mandatory.	
	</div>	
</body>
</html>
