<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <link rel="stylesheet" href="Resources/css/main.css" type="text/css" />
    <link rel="stylesheet" href="Resources/style.css" type="text/css" />
	<link rel="stylesheet" href="Resources/print.css" type="text/css" media="print" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="JS/js.js"></script>


	<title>Roodle</title>
</head>
<body>
<div id="sitecontent">
<?php

/****************************VIEW**********************************/

session_start();

//error_reporting(0);


//menu bar

function navBar(){
	
	?>
<ul id="bar">
	<li><a href="index.php?page=home">Roodle</a></li>
	<li><a href="index.php?page=register">Rekisteröidy</a></li>	
	<?php if(isset($_SESSION['user'])){print '<li><a href="index.php?page='.$_SESSION['user'].'">'.$_SESSION['user'].'</a></li>'; }
	if(isset($_SESSION['user'])){print '<li><a href="index.php?page=kurssit" style="text-decoration:none">Kurssit</a></li>'; }
	if(isset($_SESSION['user'])&&$_SESSION['rights']<3){print '<li><a href="index.php?page=suoritukset">Suoritukset</a></li>'; }
	if(isset($_SESSION['user'])&&$_SESSION['rights']<3){print '<li><a href="index.php?page=ilmoittautumiset">Ilmoittautumiset</a></li>'; }
	if(!isset($_SESSION['user'])){print '<li><a href="index.php?page=login">Kirjaudu</a></li>';}
	if(isset($_SESSION['user'])&&$_SESSION['rights']==3){print '<li><a href="index.php?page=admin">Ylläpito</a></li>';}?>
		


<?php  

//showing a link to logout if logged in.
if(isset($_SESSION['user'])){print '<li><a href="index.php?page=logout">Kirjaudu ulos</a></li>'; } ?>
<img id= "tor" src="Resources/2000px-Tor-logo-2011-flat.svg.png" width=100 height=50 />
</ul>
		

<?php
}

//display home view
function homeContent(){
?>
<br /><h1>Roodle</h1>
	   <p>Eeppinen opiskelija platformi.</p>
	   <p>
Where does it come from?

Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
</p>
<p>
Where does it come from?

Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
Where can I get some?

There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>

<?php }	
//display usersetup
function userContent(){
?>
<h1 class="infotext" align="center">Vaihda salasana</h1>
<div class="form">
		<form action="/DataHandling/datahandler.php" method="post"> <br />

		<input class = "textbox" name = "passwrd" type="password" placeholder="Salasana" /><br />

		<input class = "textbox" name = "passwrd2" type="password" placeholder="Uusi salasana" /><br />
				
		<center><input id = "changePw" type = "submit"  value = "Vaihda" /></center>
		
		</form>
</div>
<?php
}
//displays thread view when user is in thread -menu
function courses(){
	if($_SESSION['rights']==3){
	?>
	<script>
	function deleteCourse(course){
			
			$.ajax({
			url: "/DataHandling/datahandler.php",
			type: "POST",
			data:{
				"course": "delete",
				"id":course
			},
			dataType: "html",
			success: function(data){
				getCourses();
			}
		
	});
		
	}
</script>
	
	<?php
	}
?>
<script>	
function enroll(course){

			$.ajax({
			url: "/DataHandling/datahandler.php",
			type: "POST",
			data:{
				"course": "join",
				"id":course
			},
			dataType: "html",
			success: function(data){
				
				alert("Ilmoittauduttu!")
			}
		
	});
		
	}	
</script>
	
	<div id="courses">
	    
	<script>$(document).ready(function(){getCourses();});</script>	
</div>
<script>

	function getCourses(){
	
	$.ajax({
			url: "/DataHandling/datahandler.php",
			type: "GET",
			data:{
				"thrd": "kissa",
				"posts": 'getPosts'
			},
			dataType: "html",
			success: function(data){
				$("#courses").html(data);
				
			}
		
	});
}
	</script>

<?php
}
function enrolls(){
	if($_SESSION['rights']==2){
?>
<script>	

function valuateCourse(id){
	var grade = $("#".concat(id)).val();
			$.ajax({
			url: "/DataHandling/datahandler.php",
			type: "POST",
			data:{
				"course": "valuate",
				"id":id,
				"grade":grade
			},
			dataType: "html",
			success: function(data){
				getEnrolls();
			}
		
	});
		
	}	
</script>


<?php
	}
?>
<div id="enCourses">
	<script>$(document).ready(function(){getEnrolls();});</script>	
</div>
<script>

	function getEnrolls(){
	
	$.ajax({
			url: "/DataHandling/datahandler.php",
			type: "GET",
			data:{
				"course": "enrolls"
			},
			dataType: "html",
			success: function(data){
				$("#enCourses").html(data);
				
			}
		
	});
}
	</script>

<?php
}
?>

<?php	

//displays the selected thread (posts and post form)
function passedCourses(){
?>

<div id="pCourses">
	<script>$(document).ready(function(){getPassed();});</script>	
</div>
<script>

	function getPassed(){
	
	$.ajax({
			url: "/DataHandling/datahandler.php",
			type: "GET",
			data:{
				"course": "passed"
			},
			dataType: "html",
			success: function(data){
				$("#pCourses").html(data);
				
			}
		
	});
}
	</script>

<?php 
}

//displays the login view
function login(){
?>				
<h1 class="infotext" align="center">Kirjaudu</h1>
<script type="text/javascript" src="/fblogin/fb.js"></script>
<?php  //if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}  ?>
<div id="login" class="form"><form id = "form" action="/DataHandling/datahandler.php" method="post">
<br />
		<input class = "textbox" name = "login" type="text" placeholder="Sähköposti"/>
<br />
		<input class = "textbox" name = "pword" type="password" placeholder="Salasana"/>
<br />	
		<center>
		
		<input id = "loginButton" type = "submit"  value = "Kirjaudu" /></center>
		
		</form>
</div>
<?php	
}

//displays register form, $set parameter selects which form gets displayed, the register or validation
function register($set){
	if($set){
		
//register form
?>
<h1 class="infotext" align="center">Rekisteröidy</h1>
<div class="form">
		<form action="/DataHandling/datahandler.php" method="post">
<br />
		<input class = "textbox" name = "username" type="text" placeholder="Nimi"/><br />

		<input class = "textbox" name = "email" type="text" placeholder="Sähköposti" /><br />

		<input class = "textbox" name = "passwrd" type="password" placeholder="Salasana"/><br />

		<input class = "textbox" name = "passwrd2" type="password" placeholder="Salasana uudestaan" /><br />
				
		<center><input id = "registerButton" type = "submit"  value = "Rekisteröidy" /></center>
		
		</form>
</div>

<?php
	}


	}
?>

</div>
</body>
</html>