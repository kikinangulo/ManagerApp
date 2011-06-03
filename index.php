<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */


require_once 'facebook-php-sdk/src/facebook.php';
require_once("php/Database.php");
require_once("php/DBConn.php");
require_once("php/helper.php");
// Create our Application instance.
$facebook = new Facebook(array(
  'appId' => '125752644172351',
  'secret' => 'bafb9fae32e08e9fd396119486575057',
  'cookie' => true,
));
// Get User ID
$user = $facebook->getUser();
// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.
session_start();
if ($user) {
  try {
    
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    if(is_user($user, $Db)) {
    	$_SESSION["manager_id"] = $user;
    	$_SESSION["manager_name"] = $user_profile["name"];
	header("location: home.php");
    }
    $friends = $facebook->api('/me/friends');
    //$friends_box = make_select_box($friends);
  } catch (FacebookApiException $e) {
    $friends = null;
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <script src='js/jquery.js'></script>
    <script>
    	var manager_id = 0;
	$(document).ready(function(){
		manager_id = $("#user_pic").attr("src");
		manager_id = manager_id.slice(manager_id.indexOf("https://graph.facebook.com/")+27);
		manager_id = manager_id.split("/")[0];
		$("#friends").change(selectedPlayer);
		$("#save").click(saveTeam);
	});
    </script>
    <script src='js/util.js'></script>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
      .tcpitch {
		width: 25%;
		height: 60;
	}
    </style>
  </head>
  <body>
    <h1>php-sdk</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <?php if ($user): ?>
      <h3>You</h3>
      <img id='user_pic' src="https://graph.facebook.com/<?php echo $user; ?>/picture">

      <h3>Welcome <?php echo $user_profile['name'];?></h3>
      <span id='messagebox'>Please select your friends </span>
      <?php
      
      if($friends){
		foreach ($friends as $key=>$value) {
		    echo count($value) . ' Friends';
		    echo '<hr />';
		    echo '<select id="friends" >';
		    foreach ($value as $fkey=>$fvalue) {
				echo sprintf ("<option value='%d'>%s</option>", $fvalue["id"], $fvalue["name"]);
		    }
		    echo '</select>';
		}
      }
      ?>
	<div id='pitch'>
	<table border=0 width='500px'>
		<!---
			Goalkeeper
		-->
		<tr>
			<td class='tcpitch'></td>
			<td class='tcpitch'></td>
			<td class='tcpitch'><img class='pic' id='pic1'></img><br><span id='tag1'></span></td>
			<td class='tcpitch'></td>
			<td class='tcpitch'></td>
		</tr>
		<!---
			Defenders	
		-->
		<tr>
			<td class='tcpitch'><img class='pic' id='pic2'></img><br><span id='tag2'></span></td>
			<td class='tcpitch'><img class='pic' id='pic3'></img><br><span id='tag3'></span></td>
			<td class='tcpitch'></td>
			<td class='tcpitch'><img class='pic' id='pic4'></img><br><span id='tag4'></span></td>
			<td class='tcpitch'><img class='pic' id='pic5'></img><br><span id='tag5'></span></td>
		</tr>
		<!---
			Midfielders	
		-->
		<tr>
			<td class='tcpitch'><img class='pic' id='pic6'></img><br><span id='tag6'></span></td>
			<td class='tcpitch'><img class='pic' id='pic7'></img><br><span id='tag7'></span></td>
			<td class='tcpitch'></td>
			<td class='tcpitch'><img class='pic' id='pic8'></img><br><span id='tag8'></span></td>
			<td class='tcpitch'><img class='pic' id='pic9'></img><br><span id='tag9'></span></td>
		</tr>
		<!---
			Forwards	
		-->
		<tr>
			<td class='tcpitch'></td>
			<td class='tcpitch'><img class='pic' id='pic10'></img><br><span id='tag10'></span></td>
			<td class='tcpitch'></td>
			<td class='tcpitch'><img class='pic' id='pic11'></img><br><span id='tag11'></span></td>
			<td class='tcpitch'></td>
		</tr>

	</table>
	<button id='save' style='display:none;'>Save</button>
	</div>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>
	
  </body>
</html>
