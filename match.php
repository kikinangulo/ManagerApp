<?php

session_start();
require_once("php/Database.php");
require_once("php/DBConn.php");
require_once("php/helper.php");

$manager1 = $_SESSION["manager_id"];
$manager_name= $_SESSION["manager_name"];
$manager2 = $_SESSION["manager_rival"];

$team1 = get_team($manager1, $Db);
$team2 = get_team($manager2, $Db);

$match_layout = get_team_formatted_match($team1, $team2);

?>

<html>
	<head>
		<title><?echo $manager_name;?>'s MATCH</title>
		<link rel="stylesheet" href='css/master.css' />
		<script src='js/jquery.js'></script>
	</head>
	<body>
		<script>
		var pace = 1000;
		var time = 90;
		var intervalObj;

		$(document).ready(function(){
			$("#start").click(function(){
					intervalObj = setInterval(decrementMins, pace);
					$("#start").hide();
				});

			$("#time").text(time);
			$("#timeminute").text("Mins");
		});


		function decrementMins(){
			if(time > 0) {
				time --;
				$("#time").text(time);
			}else{
				clearInterval(intervalObj);	
			}
		}
		</script>
		<div id='header'>
			<span><img src='http://graph.facebook.com/<?echo $manager1;?>/picture' /><strong>Vs</strong><img src='http://graph.facebook.com/<?echo $manager2;?>/picture' /></span>
		</div>

		<div id='content'>
			<? echo $match_layout; ?>
			<a href='#' id='start'>Click to Start</a>
			<span> <span id='time'></span><span id='timeminute'></span> </span>
		</div>

		<div id='footer'>
		</div>
	</body>
</html>
