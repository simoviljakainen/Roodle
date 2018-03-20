<?php

if($_SESSION['rights']==3){
?>

<?php

print <<<PANEL
<div class="form" ><br />
	<center><h2>Luo opettaja (täytyy olla rekisteröity oppilaaksi)</h2>
	<form method="post" action="datahandler.php">
	<input type="text" name="userM" placeholder="Sähköposti"><br />
	<input type="text" name="email" placeholder="Uusi @koulu sähköposti"><br />
	<input type="text" name="puh" placeholder="Puhelinnumero"><br />
	<input type="submit" value="Luo" />
	</form></center></div>
	<br />
<div class="form" ><br />
	<center><h2>Poista käyttäjä</h2>
	<form method="post" action="datahandler.php">
	<input type="text" name="userD" placeholder="Sähköposti"><br />
	<input type="submit" value="Poista" />
	</form></center></div>
PANEL;

}else{
	header("Location: index.php?page=home");
}


?>
