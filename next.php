<?php
session_start();
require_once("php/Database.php");
require_once("php/DBConn.php");
require_once("php/helper.php");
require_once("php/templating.php");

$navbar = get_navbar();

$manager1 = $_SESSION["manager_id"];
$manager2 = get_team_2($manager1, $Db);
$_SESSION["manager_rival"] = $manager2;
if($manager2 == null){
	header("location: error.php");
}

$team1 = get_team($manager1, $Db);
$team2 = get_team($manager2, $Db);

$team1_html = get_team_formatted($team1);
$team2_html = get_team_formatted($team2);

?>
<html>
	<head>
		<title>Home Page</title>
		<link rel="stylesheet" href='css/master.css' />
		<script src='js/jquery.js'></script>
	</head>

	<body>
		<script>
			$(document).ready(function(){
				$(".tabnav").click(function(){
					var panenumber = $(this).attr("pid");
					$(".tab").hide();
					$("#pane"+panenumber).show();
				});

				$(".tab").hide();
			});
		</script>
		<div id='header'>
			<h1> Fantasy Friend Football </h1>
		</div>

		<div id='content'>
				<div id='bottom'>
					<? echo $navbar; ?>
				</div>
				<div id='top'>
					<ul id='navbar'>
						<li class='heading'><a class='nav tabnav' pid='0' href='#'>Match Details</a></li>
						<li class='heading'><a class='nav tabnav' pid='1' href='#'>Team 1</a></li>
						<li class='heading'><a class='nav tabnav' pid='2' href='#'>Team 2</a></li>
						<li class='heading'><a class='nav' pid='3' href='match.php'>Start Match</a></li>
					</ul>
				</div>
				<div id='clear' style='clear:both;'></div>
				<div class='tab' id='pane0' width:"500px">
					<table>
						<tr>
							<td class='tcpitch heading'> <?echo $manager1;?> </td>
							<td class='tcpitch'> Vs </td>
							<td class='tcpitch heading'> <?echo $manager2;?> </td>
						</tr>

					</table>
				</div>
				<div class='tab' id='pane1'>
					<?echo $team1_html;?>
				</div>
				<div class='tab' id='pane2'>
					<?echo $team2_html;?>
				</div>
			</div>
		
		<div id='footer'>

		</div>

	</body>
</html>


