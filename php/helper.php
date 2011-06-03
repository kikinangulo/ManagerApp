<?php

/*
*	manager id is the players facebook unique id
*	Db is an database object used as a wrapper around mysql database queries
*	will return 0 if the user already has a team
*	will create and return 1 if is in db
*/
function create_team($manager_id, $Db){
	$query = sprintf("INSERT INTO user(user_id, team_id, score, active) VALUES('%d',NULL, '1', '1')", $manager_id);
	$Db->query($query);
	return ($Db->affected_rows() > 0);
}

/*
*	manager id is the players facebook unique id
*	Db is an database object used as a wrapper around mysql database queries
*	team is a array of players facebook unique ids
*	Rich, maybe check this for errors at insert time using Db->affected_rows
*/

function populate_team($manager_id, $team, $Db) {
	$query = sprintf("SELECT user.team_id FROM user WHERE user.user_id = %d", $manager_id);
	$Db->query($query);
	while($Db->nextRow()) {
		$team_id = $Db->get_column(0);
	}
	$query = sprintf("INSERT INTO team(team_id, user_id,name) VALUES('%d', '%d', '%s')", $team_id, $team[0]["id"], $team[0]["name"]);
	$query2 = sprintf("INSERT INTO user(user_id, team_id, score, active) VALUES('%d', NULL, '1', '0')", $team[0]["id"]);
	for ($i = 1; $i < count($team); $i++) {
		$query .= sprintf(",('%d', '%d', '%s')", $team_id, $team[$i]["id"], $team[$i]["name"]);
		$query2 .= sprintf(",('%d', NULL, '1', '0')", $team[$i]["id"]);
	}
	$Db->query($query);
	$Db->query($query2);
}

/*
*	A simple function to check the score of a certain user if they exist,
*	otherwise return 0
*/

function check_score($manager_id, $score) {
	$query = sprintf("SELECT user.score FROM user WHERE user.user_id = %d", $manager_id);
	$Db->query($query);
	if($Db->affected_rows() > 0) {
		if($Db->nextRow()) {
			return $Db->get_column(0);
		}
	}else{
		return 0;
	}
}

function is_user($manager_id, $Db) {
	$query = sprintf("SELECT count(*) FROM user WHERE user.user_id = %d", $manager_id);
	$Db->query($query);
	if($Db->nextRow()) {
		return !($Db->get_column(0) == 0);
	}
	return 0;
}


function get_team($manager_id, $Db) {
	$query = sprintf("SELECT team.user_id, team.name FROM team, user WHERE user.user_id = '%d' AND user.team_id = team.team_id", $manager_id);
	$Db->query($query);
	$team = array();
	while($Db->nextRow()) {
		$team[$Db->get_column(1)] = $Db->get_column(0);
	}
	return $team;
}

function get_team_formatted($team) {
	$body = "<table border =0 width='500px'><tbody><tr>";
	$i=1;
	foreach($team as $name => $id) {
		$body .= <<<CODE
		<td class='tcpitch'>
			<img class='pro_pic' src='https://graph.facebook.com/$id/picture' alt='manager photo'>
			</img><br/>
			<span class='title'> $i</span> <span class='name'>$name</span> 
		</td>
CODE;
		if(in_array($i, array(1, 5, 9)))
			$body .= "</tr><br/><tr>";

		$i++;

	}
	$body .= "</tr></tbody></table>";
	return $body;
}

function get_team_formatted_match($team1, $team2) {
	$body = "<table class='match'><tbody><tr>";
	foreach($team1 as $name => $id) {
		$body .= sprintf("<td class='tcpitch'>%s</td><td class='tcpitch pict'><img src='http://graph.facebook.com/%d/picture'></img></td><td class='score'><span id='score%d'></span></td><td class='gap'></td> XREPLACEX </tr><tr>", $name, $id, $id);
	}
	$body .= "</tr></tbody></table>";
	foreach($team2 as $name => $id) {
		$temp = sprintf("<td class='score'><span id='score%d'></span></td><td class='tcpitch'>%s</td><td class='tcpitch pict'><img src='http://graph.facebook.com/%d/picture'></img></td>", $id,$name,  $id);
		$body= preg_replace('/\bXREPLACEX\b/', $temp, $body, 1);
	}
	return $body;
}

function get_team_2($team1, $Db) {
	$query = sprintf("SELECT user.user_id FROM user WHERE user.user_id != '%d' AND user.active = 1 ORDER BY RAND() LIMIT 1", $team1);
	$Db->query($query);
	$team2 = null;
	while($Db->nextRow()) {
		$team2 = $Db->get_column(0);
	}
	return $team2;
}

?>
