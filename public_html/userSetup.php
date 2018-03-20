<?php
require_once('site.php');

userContent();

if(isset($_SESSION['error'])){
		echo"<center><p style=".'color:red;'.">". $_SESSION['error']."</p></center>";
		unset($_SESSION['error']);
	}
?>