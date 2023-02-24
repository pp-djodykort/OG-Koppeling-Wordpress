<?php
// ========= Imports =========

// ============ Functions ============
//


// HTML Functions
function htmlHeader($title) {
	echo("
	<div class='wrap text'>
		<img src='".plugins_url('img/pixelplus-logo.jpg', dirname(__DIR__, 1))."' alt='Pixelplus Logo' style='float: left; width: 75px;'>
		<h1 style='font-size: 2rem; float: right;'><b>".$title."</b></h1>
	</div>
		
		
	
	");
}

function htmlFooter($title) {
	echo("
	</div>
	");
}