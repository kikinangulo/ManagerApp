<?php

require_once("Database.php");
require_once("DBConn.php");
require_once("helper.php");

$res = json_decode(stripslashes($_POST['data']), true);

$manager_id = $res["manager_id"];
$team = $res["team"];

create_team($manager_id, $Db);
populate_team($manager_id,$team,$Db);

error_log("Richy: manager". $manager_id, 0);
error_log("Richy: team". count($team), 0);

echo "Success";
?>
