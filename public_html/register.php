<?php
require_once('site.php');


if(isset($_SESSION['set'])){
	register(0);
	unset($_SESSION['set']);
}else{
	register(1);
	if(isset($_SESSION['error'])){
		echo"<center><p style=".'color:red;'.">". $_SESSION['error']."</p></center>";
		unset($_SESSION['error']);
	}
	
}
?>