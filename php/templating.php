<?php

function get_navbar() {
	return <<<CODE
				<ul id='navbar'>
					<li class='heading'><a class='highlighted nav' href='index.php'>Your Team </a></li>
					<li class='heading'><a class='nav' href='next.php'> Next Match </a></li>
					<li class='heading'><a class='nav' href='about.htm'> About Us </a></li>
				</ul>
CODE;
}

?>
