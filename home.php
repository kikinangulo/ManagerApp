<?php

session_start();
require_once("php/Database.php");
require_once("php/DBConn.php");
require_once("php/helper.php");
require_once("php/templating.php");

$navbar = get_navbar();

$manager_id = $_SESSION["manager_id"];
$manager_name= $_SESSION["manager_name"];

$team = get_team($manager_id, $Db);
$team_formatted = get_team_formatted($team);


?>
<html>
	<head>
		<title><?echo $manager_name;?>'s Home Page</title>
		<link rel="stylesheet" href='css/master.css' />
	</head>

	<body>

		<div id='header'>
			<h1> Fantasy Friend Football </h1>
		</div>

		<div id='content'>
			<? echo $navbar; ?>
			<div class='player_box'>
				<span class='title'> Manager </span> <span class='name'><?echo $manager_name;?></span> 
				<img class='pro_pic' src='https://graph.facebook.com/<?echo $manager_id;?>/picture' alt='manager photo'>
				</img>
			</div>
			<?
				echo $team_formatted;
			?>

		</div>

		<div id='footer'>
			
		</div>

	</body>
</html>
