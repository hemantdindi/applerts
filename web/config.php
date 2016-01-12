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
<br />
<form action="" method="post">
<table>
<?php
$ini_array = parse_ini_file($config_file_path);
 ?>
<tr><td>Resource Manager Host</td>
	<td><input type="text" disabled name="url" size="80" value="<?php echo $ini_array['resourcemanagerhost'] ?>" \></td>
</tr><tr><td>Resource Manager Port</td>
	<td><input type="text" disabled name="url" size="80" value="<?php echo $ini_array['resourcemanagerport'] ?>" \></td>
</tr>	
<tr><td>Database Host</td>
	<td><input type="text" disabled name="dbdriver" size="80" value="<?php echo $ini_array['dbhost'] ?>"\></td>		
</tr>	
<tr><td>Database Name</td>
	<td><input type="text" disabled name="dbname" size="80" value="<?php echo $ini_array['dbname'] ?>"\></td>	
</tr>	
<tr><td>Database User</td>
	<td><input type="text" disabled name="dbuser" size="80" value="<?php echo $ini_array['dbuser'] ?>"\></td>	
</tr>	
<tr><td>Database Password</td>
	<td><input type="password" disabled name="dbpasswd" size="80" value="<?php echo $ini_array['dbpasswd'] ?>"\></td>		
</tr>
<tr><td>Log4J Properties </td>
	<td><input type="text" disabled name="log4j" size="80" value="<?php echo $ini_array['log4j'] ?>"\></td>		
</tr>
<tr><td>SMTP Host</td>
	<td><input type="text" disabled name="smtphost" size="80" value="<?php echo $ini_array['smtphost'] ?>"\></td>		
</tr>
<tr><td>SMTP Port</td>
	<td><input type="text" disabled name="smtport" size="80" value="<?php echo $ini_array['smtpport'] ?>"\></td>		
</tr>
<tr><td>SMTP Sender</td>
	<td><input type="text" disabled name="smtpsender" size="80" value="<?php echo $ini_array['smtpsender'] ?>"\></td>		
</tr>

<tr><td>Alerts CC Team</td>
	<td><input type="text" disabled name="alertcc" size="80" value="<?php echo $ini_array['alertcc'] ?>"\></td>		
</tr>
</table>
</form>
</div>	
	
</body>
</html>
