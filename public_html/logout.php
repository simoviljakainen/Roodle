<?php
	//simply just deletes the session. "logs out"
	define("WEBSITE","https://roodledemo.000webhostapp.com/");
	session_start();
	session_destroy();
	header('Location: '.WEBSITE.'index.php?page=login');

?>