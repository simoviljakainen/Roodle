<?php
/************************CONTROLLER******************************/

//getting the view html
require_once("site.php");

//printing navigation bar
navBar();

//handling navigation through server (not showing the user direct php files.)

if($_SERVER['REQUEST_URI']=='/'){
	header("Location: index.php?page=home");
}
if(isset($_GET["page"])&&$_GET["page"]==="login"&&!isset($_SESSION['user'])){
	require("login.php");
	
}elseif(isset($_GET["page"])&&$_GET["page"]==="register"){
	require("register.php");
	
}elseif(isset($_GET["page"])&&$_GET["page"]==="ilmoittautumiset"&&isset($_SESSION['user'])){
	require("enroll.php");
	
}elseif(isset($_GET["page"])&&$_GET["page"]==="logout"&&isset($_SESSION['user'])){
	require("logout.php");
	
}elseif(isset($_GET["page"])&&isset($_SESSION['user'])&&$_GET["page"]===$_SESSION['user']){
	require("userSetup.php");
	
}elseif(isset($_GET["page"])&&isset($_SESSION['rights'])&&$_GET["page"]==="admin"){
	require("adminpanel.php");
	
}elseif(isset($_GET["page"])&&$_GET["page"]==="kurssit"&&isset($_SESSION["user"])){
	require("course.php");
	
}elseif(isset($_GET["page"])&&$_GET["page"]==="suoritukset"&&isset($_SESSION["user"])){
	require("passedCourses.php");
	
}else{
	require("home.php");
	
}





?>