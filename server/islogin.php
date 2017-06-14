<?php
session_start();

function islogin(){
	$now = time();
	if ( isset($_SESSION['expire']) && ($_SESSION['expire'] > $now) ) {
		return true;
	}else{
		return false;
	}
}


if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])){
	if (islogin()){
		echo '{"login": 1}';
	}else{
		echo '{"login": 0}';
	}
}else{
	if (islogin()){
		return true;
	}else{
		return false;
	}
}

?>
