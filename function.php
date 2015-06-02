<?php 

/*  MESSAGE FLASH  *********************/

function flash(){
	if (isset($_SESSION['flash'])) {
		extract($_SESSION['flash']);
		unset($_SESSION['flash']);
		return "<div class='alert alert-$type alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
		$message
		</div>";
	}
}

function setFlash($message, $type = 'success'){
	$_SESSION['flash']['message'] = $message;
	$_SESSION['flash']['type'] = $type;
}
?>


