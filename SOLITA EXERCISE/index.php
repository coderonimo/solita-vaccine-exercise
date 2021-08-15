<?php
/*
Tämä THL ROKOTUSTIETOKANTA ohjelma koostuu kahdesta sivusta: index.php ja dashboard.php

Index.php sivulla käyttäjä kirjoittaa käyttäjätunnuksen (KRISTA) ja kirjautuu sisään. 
Nimi tallennetaan sessiomuuttujalle nimeltä 'tunnus'. Tämän jälkeen käyttäjä ohjataan dashboard.php sivulle. 

Dashboard.php sivulla tarkastetaan sessiomuuttujasta, onko sivun lataaja tullut ekasivun kautta
 ja onko hän antanut käyttäjätunnukseksi KRISTA vai jotain muuta.

Jos molemmat ehdot täyttyvät, toivotetaan käyttäjä tervetulleeksi. Sessio on oletuksena voimassa niin kauan, 
kunnes selain suljetaan tai käyttäjä irjautuu palvelusta ulos. 
*/

// PHP SESION aloitus. 
 session_start(); 
?> 

<!DOCTYPE html>
<html>
<head>
<title>PHP - pohja</title>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS & JS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- Boostrap JS stuff: jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap" rel="stylesheet">
<!-- custom CSS -->
<link rel="stylesheet" type="text/css" href="styles2.css?v=3" title="tyylit" />

</head>
<body>

	<div class="col-md-5 pt-5 pb-5 align-self-center boxi">

	<h1 class="text-center display-3"><span class="text-success">T</span><span class="text-warning">H</span><span class="text-danger">L</span></h1>
	<h2 class="text-center text-uppercase">covid-19 rokotustietokanta</h2>
	<br>
	<h4 class="text-center">SISÄÄNKIRJAUTUMINEN</h4>
	<br>

		<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">

			<div class="form-group">
				<label for="tunnus" class="text-uppercase">Käyttäjätunnus:</label>
				<input type="text" name="tunnus" placeholder="Kirjoita käyttäjätunnus" class="form-control">
			</div>
			<button type="submit" name="nappula" class="btn btn-primary btn-block text-uppercase" value="Jatka">Kirjaudu sisään</button>

			<h6 class="text-center mt-5">ainoastaan <code>&#91;lowercase&#93;</code> <span class="badge badge-danger align-top">KRISTA</span> pääsee sisään</h6>

		</form>	
	</div>
	
<?php
//Jos nappia on painettu, niin ajetaan ohjelmalohko (aaltosulkujen väliset lauseet)
if(isset($_REQUEST["nappula"])) { 

		if ($_SESSION['tunnus'] = $_REQUEST['tunnus']) { // Asetetaan nimi session-muuttujalle. Tässä nimenä on 'tunnus'
		 header("location:dashboard.php"); // Ohjataan dashboard sivulle
		}
		else
		{
			header("location:index.php"); // Jos väärä tunnus, pysytään index.php sivulla
		} 
}
?>

</body>
</html>





