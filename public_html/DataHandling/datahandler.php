<?php
//Handles all the database actions and information (model)

require_once('../utils.php');
require_once("databaseHandler.php");
session_start();

//define this to match your website (eg. localhost)
define("WEBSITE","https://roodledemo.000webhostapp.com/");
/******************GET and POST request handler, calls the data functions and actions that are requested*********************/

//login checker
if($_SERVER['HTTP_REFERER']===WEBSITE.'index.php?page=login'&&!isset($_SESSION['user'])){
	 if(isset($_POST['login'])&&!empty($_POST['login'])&&isset($_POST['pword'])&&!empty($_POST['pword'])){
		if(1){
			
			//gets needed information from the db
			$db = db();
			//$hash = $db->readDb('users','phash , rights', ' username= ',$_POST['login']);
			if(fnmatch('*@koulu.com', $_POST['login'])){
				$hash = $db->readDb('opettaja','phash , rights', ' email= ',$_POST['login']);
			}elseif(fnmatch('*@admin.com', $_POST['login'])){
				$hash = $db->readDb('yllapito','phash , rights', ' email= ',$_POST['login']);
			}else{
				$hash = $db->readDb('opiskelija','phash , rights', ' email= ',$_POST['login']);
			}

			//check if the given password is correct
			if(password_verify($_POST['pword'],$hash[0]['phash'])) {
				
				//defining the login session variables
				$_SESSION['user'] = $_POST['login'];
				$_SESSION['rights'] = $hash[0]['rights'];
				header('Location: '.WEBSITE.'index.php?page=home');
			}else{
				$_SESSION['error'] = "invalid username or password";
				header('Location: '.WEBSITE.'index.php?page=login');
			}
		}else{
			$_SESSION['error']="invalid captcha.";
			header('Location: '.WEBSITE.'index.php?page=login');
		}
	}else{
		$_SESSION['error'] = "invalid username or password";
		header('Location: '.WEBSITE.'index.php?page=login');
	}

	
//gets all courses
}elseif(isset($_GET['posts'])&&$_GET['posts']=='getPosts'&&isset($_GET['thrd'])&&!empty($_GET['thrd'])){
	

$db = db();
	$course = $db->readDb('kurssi','ktunnus,knimi,ksuoritusaika,kopintopisteet','','');
	$form = '';
	$callback = '';
	print "<br \><h1>Normaalit kurssit</h1><h3>(Klikkaa kurssia, jos haluat ilmoittautua.)";
	
	for($i=0; $i<count($course); $i++){
		if(isset($_SESSION['rights'])&&$_SESSION['rights']>2){
			
			//makes moderator/admin controls
			$form = "<form style= 'margin-bottom: 90px;'><input style= 'float:right;' type=button"." value="."delete"." onclick = "."deleteCourse('".$course[$i]['ktunnus']."')"." /></form>";
		}else{
			$callback = "onclick=enroll('".$course[$i]['ktunnus']."');";
		}
		print "<div ".$callback." id =".$course[$i]['ktunnus']." class="."courses"."><h4>".$course[$i]['ktunnus'].
		" ".$course[$i]['knimi']."&emsp;".$course[$i]['ksuoritusaika']."&emsp;".$course[$i]['kopintopisteet']." op</h4>".$form."</div>";

	}
	$course = $db->readDb('avoinkurssi','atunnus,animi,asuoritusaika,aopintopisteet,hinta','','');
	$form = '';
	$callback = '';
	print "<br \><h1>Avoimet kurssit</h1>";
	
	for($i=0; $i<count($course); $i++){
		if(isset($_SESSION['rights'])&&$_SESSION['rights']>2){
			
			//makes moderator/admin controls
			$form = "<form style= 'margin-bottom: 90px;'><input style= 'float:right;' type=button"." value="."delete"." onclick = "."deleteCourse('".$course[$i]['atunnus']."')"." /></form>";
		}else{
			$callback = "onclick=enroll('".$course[$i]['atunnus']."');";
		}
		print "<div ".$callback." id =".$course[$i]['atunnus']." class="."courses"."><h4>".$course[$i]['atunnus'].
		" ".$course[$i]['animi']."&emsp;".$course[$i]['asuoritusaika']."&emsp;".$course[$i]['aopintopisteet']." op "."&emsp;".$course[$i]['hinta']."€</h4>".$form."</div>";

	}

}elseif(isset($_GET['course'])&&$_GET['course']=='enrolls'&&isset($_SESSION['rights'])){
	$db = db();
	$post = $db->getEnrolls();
	$status = '<br />Kurssin status: Arvosteltu';
	if($_SESSION['rights']==1){
		print "<br/><h1>Ilmoittautumiset</h1>";
		for($i=0; $i<count($post); $i++){
			if($post[$i]['status']==1){
				$status = '<br \>Kurssin status: Käynnissä';
			}
			print "<div id =".$post[$i]['ktunnus']." class="."courses"."><h2>".$post[$i]['ktunnus']."&emsp;".$post[$i]['knimi']."".$post[$i]['animi']."</h2><h3>Ilmoittauduttu: ".$post[$i]['pvm']." ".$status." </h3></div>";

		}
	}elseif($_SESSION['rights']==2){
		
		print "<br/><h1>Ilmoittautumiset</h1>";
		for($i=0; $i<count($post); $i++){
			if($post[$i]['status']==1){
				$status = '<br \>Status: Ei arvosteltu';
			}
			print "<div id =".$post[$i]['ktunnus']." class="."courses"."><h2>".$post[$i]['ktunnus']." ".$post[$i]['knimi']."<br />".
			$post[$i]['opiskelijanumero']."&emsp;".$post[$i]['nimi']."</h2><h3>Ilmoittauduttu: ".$post[$i]['pvm']." ".$status." </h3>".
			"<form style= 'margin-bottom: 90px;'><input style= 'float:right;' type=button"." value="."arvostele"." onclick = "."valuateCourse('".$post[$i]['itunnus']."')"." />".
			"<input id = ".$post[$i]['itunnus']." style= 'margin-right: 20px; float:right;  height:45px;  width:100px;' type=text placeholder=Arvosana /></form></div>";

		}
	}
}elseif(isset($_POST['course'])&&$_POST['course']=='valuate'&&isset($_SESSION['rights'])&&$_SESSION['rights']==2&&isset($_POST['grade'])){
	if(is_numeric($_POST['id'])&&is_numeric($_POST['grade'])&&$_POST['grade']>0&&$_POST['grade']<6){
		$db = db();
		$post = $db->valuateCourse($_POST['id'],$_POST['grade']);
	}
	
}elseif(isset($_GET['course'])&&$_GET['course']=='passed'){
	$db = db();
	$meanNpoints = $db->getMeanNpoints();
	$str = '';
	$op = '';
	if($_SESSION['rights']==1){
		$op = "<h3>Opintopisteitä: ".$meanNpoints[0]['kurssiM']."  Keskiarvo: ".$meanNpoints[0]['keskiarvo']."</h3>";
	}
	$post = $db->getPassed();
	print "<br/><h1>Suoritukset</h1>".$op;
	for($i=0; $i<count($post); $i++){
		if($_SESSION['rights']==2){
			$str = "<h2>".$post[$i]['nimi'].'&emsp;'.$post[$i]['opiskelijanumero']."<h2>";
		}
		print "<div id =".$post[$i]['ktunnus']." class="."courses".
		">".$str."<h4>".$post[$i]['ktunnus']." ".$post[$i]['knimi']."&emsp;Arvosana: ".$post[$i]['arvosana']."&emsp;&emsp;".$post[$i]['pvm']." </h4></div>";

	}
	
//gets needed data for the chart
}elseif($_SERVER['HTTP_REFERER']===WEBSITE.'index.php?page=home'&&$_GET['chartT']=='joppa'){
	
	$list = getChartPosts();
	$string = $_SESSION['chart_posts'] = "[".implode(",",$list)."]";
	$threads = getChartThreads();
	$_SESSION['chart_threads'] =$threads;
	print "1";
	
//makes a teacher
}elseif(isset($_SESSION['rights'])&&$_SESSION['rights']==3&&isset($_POST['userM'])){
	$db = db();
	$db->makeTeacher($_POST['userM'],$_POST['email'],$_POST['puh']);
	header("Location: ".WEBSITE."index.php?page=admin");
	
//delete a user
}elseif(isset($_SESSION['rights'])&&$_SESSION['rights']==3&&isset($_POST['userD'])){
	deleteUser($_POST['userD']);
	header("Location: ".WEBSITE."index.php?page=admin");
	
//deletes a course
}elseif(isset($_SESSION['rights'])&&$_SESSION['rights']>2&&isset($_POST['id'])&&isset($_POST['course'])&&$_POST['course']=='delete'){
	$db = db();
	$db->dbDelete("kurssi","ktunnus",$_POST['id']);
	header("Location ".WEBSITE."index.php?page=kurssit");
	
//joins course
}elseif(isset($_POST['course'])&&$_POST['course']=='join'&&isset($_POST['id'])&&isset($_SESSION['rights'])&&$_SESSION['rights']==1){
	$db = db();
	$db->joinCourse($_POST['id']);
	header("Location: ".WEBSITE."index.php?page=kurssit");
	
//change password
}elseif(isset($_SESSION['user'])&&isset($_POST['passwrd'])&&isset($_POST['passwrd2'])&&isset($_SESSION['rights'])){
	$db = db();
	$table = '';
		//$hash = $db->readDb('users','phash , rights', ' username= ',$_POST['login']);
		if($_SESSION['rights']==1){
			$table = 'opiskelija';
		}elseif($_SESSION['rights']==2){
			$table = 'opettaja';
		}elseif($_SESSION['rights']==3){
			$table = 'yllapito';
		}
		$hash = $db->readDb($table,'phash', ' email= ',$_SESSION['user']);
		
		//check if the given password is correct
		if(password_verify($_POST['passwrd'],$hash[0]['phash'])){
			$pwHashnSalt = hashString($_POST['passwrd2']); 
			$db->changePass($_SESSION['user'],$pwHashnSalt['pwhash'],$table);
		}else{
			$_SESSION['error'] = 'Väärä salasana.';
		}
		header('Location: '.WEBSITE.'index.php?page='.$_SESSION['user']);
		
//register checker	
}elseif(isset($_POST['email'])&&isset($_POST['username'])&&isset($_POST['passwrd'])){
	if(!empty($_POST['email'])&&!empty($_POST['username'])&&!empty($_POST['passwrd'])){
		if(checkPw($_POST['passwrd'])){
			if(1){ 
				if(checkMatch($_POST['passwrd'],$_POST['passwrd2'])){
					if(checkEmail($_POST['email'])){
						if(checkUn($_POST['email'])){
							if(1){
							    $db = db();
								$pwHashnSalt = hashString($_POST['passwrd']); 
								
								$db->writeDb("opiskelija", "nimi,email,phash,salt",
									$_POST['username'].",".$_POST['email'].",".$pwHashnSalt['pwhash'] .",".$pwHashnSalt['salt']);
									
								$_SESSION['registered'] = "<center><p id="."message".">Rekisteröityminen on valmis! Voit kirjautua sisään.</p></center>";
								header('Location: '.WEBSITE.'index.php?page=login');
								
							}else{
								$_SESSION['error']="invalid captcha.";
								header('Location: '.WEBSITE.'index.php?page=register');
							}
						}else{
							$_SESSION['error']="Username is already in use.";
							header('Location: '.WEBSITE.'index.php?page=register');
						}
					}else{
						$_SESSION['error']="invalid email.";
						header('Location: '.WEBSITE.'index.php?page=register');
					}	
				  }else{
					  $_SESSION['error']="given passwords do not match.";
					  header('Location: '.WEBSITE.'index.php?page=register');
				  }	  
				}else{
					$_SESSION['error']="invalid input.";
					header('Location: '.WEBSITE.'index.php?page=register');
				}
		}else{
			$_SESSION['error']="password must be atleast 9 chars long, have numbers and lower and uppercase letters";
			header('Location: '.WEBSITE.'index.php?page=register');
		}
	}else{
		$_SESSION['error']="invalid input.";
		header('Location: '.WEBSITE.'index.php?page=register');
	}
}

/******************DATA FUNCTIONS*********************/


//gets an instance from dbhandler (singleton)
function db(){
	$db = DbHandler::getInstance();
	
	return $db;
}

//checks if username is already registered
function checkUn($username){
	$db = db();
	$post = $db->readDb('opiskelija','*','email=',$username);
	print count($post);
	
	if(count($post)>0){
		return 0;
	}else{
		return 1;
	}
		
}

//deletes a user
function deleteUser($username){
	$db = db();
	$db->dbDelete("opiskelija","email",$username);
	header("Location ".WEBSITE."index.php?page=admin");
}
//displays threads' names
function getThreads(){
	$db = db();
	$threads = $db->getThreads();
	print "<h3>Open threads: </h3><ul>";
	for($i=0; $i<count($threads); $i++){
		if(substr($threads[$i]['Tables_in_'.DATABASE],0,7)=='thread_'){
			
			print "<li class="."thread_list"." onclick="."goThread(event)".">".substr($threads[$i]['Tables_in_'.DATABASE],7)."</li><br />";
		}
	}
	print "</ul>";
}

//checks if the user or email is found from memcache
function checkMemcache($email,$username){
	/*$memcache = connectMemcache();
	if(getMemcache($email,$memcache)||getMemcache($username,$memcache)){
		return 0;
	}else{
		return 1;
	}
	*/
	return 1;
}


//parses the xml data (from api) for gamesearch 
function parseXML($game){
	$xml1=file_get_contents("http://thegamesdb.net/api/GetGamesList.php?name=".$game);
	$xml = simplexml_load_string($xml1);
	print "<tr><th>Game</th><th>Release date</th><th>Platform</th></tr>";
	$n=0;
	for($i=0;$i<$xml->count();$i++){
		if($n > 8){
			break;
		}
		echo "<tr class="."gamerows"."><td>".$xml->Game[$i]->GameTitle."</td><td>"
			 .$xml->Game[$i]->ReleaseDate."</td><td> "
			 .$xml->Game[$i]->Platform."</td></tr>";
		$n++;
	}
}


?>