<?php

/********************DATABASEHANDLER********************/

//define these to match your database
	define("DATABASE","id5132811_opisto");
	define("HOST","localhost");
	define("USERNAME","id5132811_lordoftherings929");
	define("PASSWORD","demoWebsiteRoodle99");
	
	
//Handles all the database queries, actions
class DbHandler{

	
	private static $Db = null;

	private function construct__() {}

	//singleton model, gives the DbHandler instance
	public static function getInstance() {
			static $Db = null;
			if ($Db === null) {
				$Db = new DbHandler();
			}
			return ($Db);
		}
		
	//deletes from database with given tablename and statement (if($where = $param))
	function dbDelete($table,$where,$param){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$query = "DELETE FROM ".$table." WHERE ".$where." = ?";
		$sQuery = $db->prepare($query);
		$sQuery->bindParam(1,$param);
		$sQuery->execute();
	}
	function changePass($email,$pass,$table){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$query = "UPDATE ".$table." SET phash = ? WHERE email = ?";
		$sQuery = $db->prepare($query);
		$sQuery->bindParam(2,$email);
		$sQuery->bindParam(1,$pass);
		$sQuery->execute();
	}
	//Makes a teacher from a student
	function makeTeacher($email,$tEmail,$puh){
		$rows = $this->readDb('opiskelija','nimi,phash,salt','email=',$email);
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$query = "INSERT INTO opettaja(nimi,phash,salt,email,puh) values('".$rows[0]['nimi']."','".$rows[0]['phash']."','".$rows[0]['salt']."',?,?)";
		$sQuery = $db->prepare($query);
		$sQuery->bindParam(1,$tEmail);
		$sQuery->bindParam(2,$puh);
		$sQuery->execute();
	}
	function valuateCourse($id,$grade){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$rows = $this->readDb('ilmottautuminen','ktunnus,opiskelijanumero','itunnus=',$id);
		$query = "INSERT INTO suoritus(arvosana,ktunnus,opiskelijanumero) values(?,?,?)";
		$sQuery = $db->prepare($query);
		$sQuery->bindParam(1,$grade);
		$sQuery->bindParam(2,$rows[0]['ktunnus']);
		$sQuery->bindParam(3,$rows[0]['opiskelijanumero']);
		$sQuery->execute();
		
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$query = "UPDATE ilmottautuminen SET status = 2 WHERE itunnus = ?";
		$sQuery = $db->prepare($query);
		$sQuery->bindParam(1,$id);
		$sQuery->execute();

	}
	
	function joinCourse($course){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$rows = $this->readDb('opiskelija','opiskelijanumero','email=',$_SESSION['user']);
		
		$exists = $this->readDb('ilmottautuminen','ktunnus','opiskelijanumero='.$rows[0]['opiskelijanumero'].
		" AND ktunnus=",$course);
		$exists1 = $this->readDb('kurssi','ktunnus','ktunnus=',$course); 
		$exists2 = $this->readDb('avoinkurssi','atunnus','atunnus=',$course);
		
		if(!$exists[0]['ktunnus']==$course&&(count($exists1)==1||count($exists2)==1)){
			$query = "INSERT INTO ilmottautuminen(ktunnus,opiskelijanumero,status) values(?,?,1)";
			$sQuery = $db->prepare($query);
			$sQuery->bindParam(1,$course);
			$sQuery->bindParam(2,$rows[0]['opiskelijanumero']);
			$sQuery->execute();
		}
	}
	//Database reading function, reads the rows that fit with given parameters
	function readDb($table, $column, $where, $stmt){
		
	try{
		$columns = explode(",",$column);
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		
		//constructing the query
		$query = "SELECT ".$columns[0];
		for($i=1; $i<sizeof($columns); $i++){
			$query = $query.",".$columns[$i];
		}
		$query = $query." FROM " .$table;

		if($where != ''){
			$query = $query." WHERE ".$where.':term';
			$sQuery = $db->prepare($query);
			$sQuery->bindValue(':term',$stmt,PDO::PARAM_STR);
		}else{
			$sQuery = $db->prepare($query);
		}
		//getting the data
		$sQuery->execute();
		$rows = $sQuery->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}catch (PDOException $exRead) {
			   return($exRead->getMessage());
			}
	}
	//gets all the enrolls
	function getEnrolls(){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		if($_SESSION['rights']==1){
			
			$result= $db->query("SELECT ilmottautuminen.ktunnus,ilmottautuminen.pvm,ilmottautuminen.status, kurssi.knimi, ". 
			"avoinkurssi.animi FROM ilmottautuminen LEFT OUTER JOIN opiskelija ON ilmottautuminen.opiskelijanumero = opiskelija.opiskelijanumero".
			" LEFT OUTER JOIN kurssi ON ilmottautuminen.ktunnus = kurssi.ktunnus LEFT OUTER JOIN avoinkurssi ON ilmottautuminen.ktunnus = ".
			"avoinkurssi.atunnus WHERE opiskelija.email = '".$_SESSION['user']."'");
			
		}elseif($_SESSION['rights']==2){
			
			$result= $db->query("SELECT kurssi.ktunnus, kurssi.knimi, opiskelija.opiskelijanumero, opiskelija.nimi, ilmottautuminen.pvm, ".
			" ilmottautuminen.status, ilmottautuminen.itunnus ". 
			" FROM opettaja LEFT OUTER JOIN kurssivastaava ON opettaja.opettajaid = kurssivastaava.opettajaid".
			" LEFT OUTER JOIN kurssi ON kurssivastaava.ktunnus = kurssi.ktunnus LEFT OUTER JOIN ilmottautuminen".
			" ON ilmottautuminen.ktunnus = kurssi.ktunnus LEFT OUTER JOIN opiskelija ON ilmottautuminen.opiskelijanumero = ".
			"opiskelija.opiskelijanumero WHERE opettaja.email = '".$_SESSION['user']."' AND ilmottautuminen.status = 1");
		}
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}
	function getPassed(){
		
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		
		if($_SESSION['rights']==1){
			
			$result= $db->query("SELECT suoritus.arvosana, suoritus.ktunnus, suoritus.pvm, kurssi.knimi ".
			"FROM suoritus JOIN kurssi ON suoritus.ktunnus = kurssi.ktunnus JOIN opiskelija ".
			"ON suoritus.opiskelijanumero = opiskelija.opiskelijanumero WHERE opiskelija.email = '".$_SESSION['user']."'");
			
		}elseif($_SESSION['rights']==2){
			
			$result= $db->query("SELECT opettaja.opettajaid, opiskelija.nimi, opiskelija.opiskelijanumero, ".
			"suoritus.arvosana, suoritus.ktunnus, suoritus.pvm, kurssi.knimi FROM suoritus JOIN kurssi ON ".
			"suoritus.ktunnus = kurssi.ktunnus JOIN kurssivastaava ON kurssivastaava.ktunnus = suoritus.ktunnus ".
			"JOIN opettaja ON kurssivastaava.opettajaid = opettaja.opettajaid".
			" JOIN opiskelija ON suoritus.opiskelijanumero = opiskelija.opiskelijanumero WHERE ".
			"opettaja.email = '".$_SESSION['user']."'");
		}
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}
	function getMeanNpoints(){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$result= $db->query("SELECT SUM(kurssi.kopintopisteet) AS kurssiM, AVG(suoritus.arvosana) AS keskiarvo FROM suoritus JOIN opiskelija ON".
        " suoritus.opiskelijanumero = opiskelija.opiskelijanumero JOIN kurssi ON suoritus.ktunnus = kurssi.ktunnus WHERE opiskelija.email = '".$_SESSION['user']."'");
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}
	//creates a new table for a new thread
	function createThreadTable($table){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$query =  "CREATE TABLE "."thread_".$table. " (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, posts LONGBLOB, user VARCHAR(30), rights INT(2), created TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
		$stmt = $db->prepare($query);
		$stmt->execute();
	}

	//counts posts from threads (made for the chart)
	function getPostC(){
		$threads = array();
		$threads =$this->getThreadA();
		$postCount = array();
		for($i=0; $i<count($threads); $i++){
			$postCount[] = count($this->readDb('thread_'.$threads[$i],'*','',''));
		}
		return $postCount;
	}
	//gets all the threads' names from the database
	function getThreadA(){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$result= $db->query("show tables");
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		$threads = array();
		for($i=0; $i<count($rows); $i++){
			
			if(substr($rows[$i]['Tables_in_'.DATABASE],0,7)=='thread_'){
				
				$threads[] = substr($rows[$i]['Tables_in_'.DATABASE],7);
			}
			
		}
		return $threads;
	}

	//write into database, inserts given data to given table
	function writeDb($table, $column, $value){
		$db = new PDO('mysql:host='.HOST.'; dbname='.DATABASE.'; charset=utf8',USERNAME,PASSWORD);
		$query =  "INSERT INTO ".$table." (".$column;
		$values = explode(",",$value);
		
		$query = $query.") VALUES(?";
		 for($i = 0; $i<sizeof($values)-1; $i++) {
					$query = $query . ", ?";
				}
		$query = $query.")";
		$sQuery = $db->prepare($query);
		
		 for ($i = 0; $i < sizeof($values); $i++) {
					$sQuery->bindParam($i+1, $values[$i]);
				}

		$sQuery->execute();

	}
}

?>