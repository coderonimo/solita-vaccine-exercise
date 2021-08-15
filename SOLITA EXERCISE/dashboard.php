<?php
// Ohjelma toivottaa KRISTA käyttäjätunnuksella operoivat tervetulleiksi. 
// Jos käyttäjä yrittää avata sivun suoraan tulematta index.php:n kautta, niin häntä ei toivoteta tervetulleeksi
// Session aloitus. 
 session_start(); 
?> 

<!DOCTYPE html>
<html>
<head>
<title>ROKOTUSTIETOKANTA</title>
<meta charset="utf-8">
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
<link rel="stylesheet" type="text/css" href="styles.css?v=8" title="tyylit"/>
</head>

<body>
								
<main> <!-- MASTER CONTTI -->

<div class="container"> <!-- JUMBOTRON -->

	<div class="jumbotron jumbotron-fluid bg-primary text-white">

		<!-- TERVE ja LOGOUT -->
		<?php
		//Jos on saavuttu index.php sivun kautta ja annettu käyttäjätunnukseksi KRISTA
		if(isset($_SESSION['tunnus']) && $_SESSION['tunnus'] == "krista") {
			echo "<h6 class='text-uppercase text-primary ml-3'><span class='text-danger'>T</span><span class='text-warning'>E</span><span class='text-primary'>R</span><span class='text-dark'>V</span><span class='text-success'>E&nbsp;</span><span class='badge badge-danger align-top'>". $_SESSION['tunnus'] . "</span></h6>"; 
		}
		else {
			header("location: index.php"); // ajaa index.php:n
		}
		// Poistaa session
		if(isset($_REQUEST["poistaSessio"])) {
			session_unset();
			session_destroy();
			header("location: index.php"); // ajaa index.php:n
		}
		?>

		<!-- kirjaudu ulos nappula -->
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 			
			<input type="submit" class="btn btn-primary ml-2 mt-2" name="poistaSessio" value="Kirjaudu Ulos"/>			
		</form>	

		<!-- otsikot ja navigaatio -->
		<h1 class="text-center display-2"><span class="text-success">T</span><span class="text-warning">H</span><span class="text-danger">L</span></h1>
		<h3 class="text-center text-uppercase">COVID-19 Rokotustietokanta</h3>
		<br>
		<div class="wrapper text-center text-uppercase">
		<div class="btn-group btn-group-lg">
		<a class="btn btn-primary" href="#tilanne" role="button">Rokotustilanne</a>	
		<a class="btn btn-primary" href="#tilaukset" role="button">Rokotetilaukset</a>  
		</div>	   
		</div>
	</div>
</div> <!-- jumbo header end -->

<?php 
	// YHTEYS TIETOKANTAAN
	include("tietokantayhteys.php"); 
?> 

<!-- **************************
			ROKOTUSTILANNE
	 ************************** -->

<div class="container">

	<h2 class="text-center text-uppercase" id="tilanne">rokotustilanne</h2>
	<br>

	<?php 

	// Haetaan ROKOTETUT YHTEENSÄ LUKU vacdone tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacdone"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$yhteensa = $kysely->fetch();
	
	///////

	// Haetaan ROKOTETUT NAISET YHTEENSÄ LUKU vacdone tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacdone WHERE gender='female'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$naisetyhteensa = $kysely->fetch();

	///////

	// Haetaan ROKOTETUT MIEHET YHTEENSÄ LUKU vacdone tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacdone WHERE gender='male'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$miehetyhteensa = $kysely->fetch();

	///////

	// Haetaan ROKOTETUT MUUT YHTEENSÄ LUKU vacdone tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacdone WHERE gender='nonbinary'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$muutyhteensa = $kysely->fetch();

	/////// ALARIVI  ///////

	// Haetaan 2021 AIKANA ROKOTETUT vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacdone WHERE injected BETWEEN '2021-01-01' AND '2021-08-15'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$tamanvuodenaikana = $kysely->fetch();

	//////////

	// Haetaan 2021 TAMMI - MAALISKUUN AIKANA ROKOTETUT vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacdone WHERE injected BETWEEN '2021-01-01' AND '2021-03-31'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$tammimaalis = $kysely->fetch();

	/////////

	// Haetaan 2021 HUHTIKUUN - ELOKUUN AIKANA ROKOTETUT vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacdone WHERE injected BETWEEN '2021-04-01' AND '2021-08-15'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$huhtielo = $kysely->fetch();
	
	?> <!-- PHP END -->

	<!-- Tietokannasta KORTTEIHIN revittyä perusinfoa rokotustilanteesta --> 
	<div class="card-group">

		<div class="card text-white bg-primary mb-3">
		<h4 class="card-header text-uppercase text-center">rokotettu</h4>
		<div class="card-body">
			<h1 class="card-title text-center mt-3"><?php echo $yhteensa[0];?></h1>
		</div>
		</div>
	
		<div class="card text-white bg-warning mb-3">
		<h4 class="card-header text-uppercase text-center">naiset</h4>
		<div class="card-body">
			<h1 class="card-title text-center mt-3"><?php echo $naisetyhteensa[0];?></h1>
		</div>
		</div>

		<div class="card text-white bg-success mb-3">
		<h4 class="card-header text-uppercase text-center">miehet</h4>
		<div class="card-body">
			<h1 class="card-title text-center mt-3"><?php echo $miehetyhteensa[0];?></h1>
		</div>
		</div>

		<div class="card text-white bg-danger mb-3">
		<h4 class="card-header text-uppercase text-center">MUUT</h4>
		<div class="card-body">
			<h1 class="card-title text-center mt-3"><?php echo $muutyhteensa[0];?></h1>
		</div>
		</div>
	</div>
	<br>

	<!-- Lisää tietokannasta KORTTEIHIN revittyä infoa rokotustilanteesta --> 
	<div class="row">
		<div class="col-md-4">
		<div class="card border-danger mb-3">
		<h4 class="card-header text-uppercase text-center text-white bg-danger">2021 ROKOTETUT</h4>
		<div class="card-body text-danger text-uppercase">
			<h1 class="card-title text-center mt-3"><?php echo $tamanvuodenaikana[0];?></h1>
		</div>
		</div>
		</div>

		<div class="col-md-4">
		<div class="card border-success mb-3">
		<h4 class="card-header text-uppercase text-center text-white bg-success">TAMMIKUU - MAALISKUU</h4>
		<div class="card-body text-success text-uppercase">
			<h1 class="card-title text-center mt-3"><?php echo $tammimaalis[0];?></h1>
		</div>
		</div>
		</div>

		<div class="col-md-4">
		<div class="card border-primary mb-3">
		<h4 class="card-header text-uppercase text-center text-white bg-primary">HUHTIKUU - ELOKUU</h4>
		<div class="card-body text-primary text-uppercase">
			<h1 class="card-title text-center mt-3"><?php echo $huhtielo[0];?></h1>
		</div>
		</div>
		</div>
	</div>

	<!-- ALERT --> 
	<br>
	<div class="alert alert-info text-center w-50 mx-auto">
	rullaa rokotustilanne taulukkoa alaspäin
	</div>
	<br>

	<!-- TAULUKON HEAD --> 
	<div class="tablestyle">
	<table class="table table-striped table-hover table-light">
	<thead class="bg-primary text-uppercase text-center text-white">
		<tr>
		<th class="thead" scope="col">NR</th>
		<th class="thead" scope="col">VACCINATION ID</th>
		<th class="thead" scope="col">SOURCE BOTTLE</th>
		<th class="thead" scope="col">GENDER</th>
		<th class="thead" scope="col">INJECTION DATE</th>
		</tr>
	</thead>
	<tbody class="text-center">

	<?php // PHP START

	// Haetaan koko tietokanta
	$kysely = $yhteys->prepare("SELECT nr, vaccination_id, sourcebottle, gender, injected FROM vacdone");  
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta.  

	// Tulostus
	while ($rivi = $kysely->fetch()) { // käydään kaikki tulosjoukon rivit läpi. 

	// tulostetaan rivien kentät taulukkoon
		echo '<tr>';
		echo '<td>'. $rivi['nr'] . '</td>';
		echo '<td>'. $rivi['vaccination_id'] . '</td>';
		echo '<td>'. $rivi['sourcebottle'] . '</td>'; 
		echo '<td>'. $rivi['gender'] . '</td>';
		echo '<td>'. $rivi['injected'] . '</td>';
		echo '</tr>';
	}

	?> <!-- PHP END -->
		
	</tbody>
	</table>
	</div>
	</div>
</div> <!--  rokotustilanne container end -->
<br>
<br>

<!-- **************************
			ROKOTETILAUKSET
	 ************************** -->

	 <div class="container">
	<div class=col-md-12>

	<h2 class="text-center text-uppercase" id="tilaukset">rokotetilaukset</h2>
	<br>

	<?php 

	// Haetaan ROKOTETILAUKSET YHTEENSÄ LUKU vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacorders"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$tilauksetyhteensa = $kysely->fetch();
	
	///////

	// Haetaan ANTIQUA TILAUKSET YHTEENSÄ LUKU vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacorders WHERE vaccine='antiqua'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$antiquayhteensa = $kysely->fetch();

	///////

	// Haetaan ZERPFY TILAUKSET YHTEENSÄ LUKU vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacorders WHERE vaccine='zerpfy'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$zerpfyyhteensa = $kysely->fetch();

	///////

	// Haetaan SOLARBUDDHICA TILAUKSET YHTEENSÄ LUKU vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacorders WHERE vaccine='solarbuddhica'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$solarbuddhicayhteensa = $kysely->fetch();

	///////    ALARIVI   ///////

	// Haetaan ROKOTE ANNOSTEN KESKIARVO vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT AVG(injections) FROM vacorders"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$annoskeskiarvo = $kysely->fetch();

	/////////

	// Haetaan ROKOTE ANNOSTEN MÄÄRÄ vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT SUM(injections) FROM vacorders"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$annoksiayhteensa = $kysely->fetch();

	/////////

	// Haetaan MAALISKUU 2021 rokotetilaukset vacorders tietokannasta
	$kysely = $yhteys->prepare("SELECT COUNT(*) FROM vacorders WHERE arrived BETWEEN '2021-03-01' AND '2021-03-31'"); 
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta

	// Tulos talteen tulostus varten
	$kuukaudenaikana = $kysely->fetch();

	?> <!-- PHP END -->

	<!-- Tietokannasta KORTTEIHIN revittyä perusinfoa rokotustilanteesta --> 
	<div class="card-group">

		<div class="card text-white bg-primary mb-3">
		<h4 class="card-header text-uppercase text-center">tilauksia</h4>
		<div class="card-body">
			<h1 class="card-title text-center mt-3"><?php echo $tilauksetyhteensa[0];?></h1>
		</div>
		</div>
	
		<div class="card text-white bg-warning mb-3">
		<h4 class="card-header text-uppercase text-center">antiqua</h4>
		<div class="card-body">
			<h1 class="card-title text-center mt-3"><?php echo $antiquayhteensa[0];?></h1>
		</div>
		</div>

		<div class="card text-white bg-success mb-3">
		<h4 class="card-header text-uppercase text-center">zerpfy</h4>
		<div class="card-body">
			<h1 class="card-title text-center mt-3"><?php echo $zerpfyyhteensa[0];?></h1>
		</div>
		</div>

		<div class="card text-white bg-danger mb-3">
		<h4 class="card-header text-uppercase text-center">solarbuddhica</h4>
		<div class="card-body">
		<h1 class="card-title text-center mt-3"><?php echo $solarbuddhicayhteensa[0];?></h1>
		</div>
		</div>
	</div>
	<br>

	<!-- Lisää tietokannasta KORTTEIHIN revittyä infoa rokotetilaus tilanteesta --> 
	<div class="row">
		<div class="col-md-4">
		<div class="card border-danger mb-3">
		<h4 class="card-header text-uppercase text-center text-white bg-danger">ANNOSKESKIARVO</h4>
		<div class="card-body text-danger text-uppercase">
			<h1 class="card-title text-center mt-3"><?php echo $annoskeskiarvo[0];?></h1>
		</div>
		</div>
		</div>

		<div class="col-md-4">
		<div class="card border-success mb-3">
		<h4 class="card-header text-uppercase text-center text-white bg-success">ANNOKSIA YHTEENSÄ</h4>
		<div class="card-body text-success text-uppercase">
			<h1 class="card-title text-center mt-3"><?php echo $annoksiayhteensa[0];?></h1>
		</div>
		</div>
		</div>

		<div class="col-md-4">
		<div class="card border-primary mb-3">
		<h4 class="card-header text-uppercase text-center text-white bg-primary">MAALISKUU</h4>
		<div class="card-body text-primary text-uppercase">
			<h1 class="card-title text-center mt-3"><?php echo $kuukaudenaikana[0];?></h1>
		</div>
		</div>
		</div>
	</div>

	<!-- ALERT --> 
	<br>
	<div class="alert alert-info text-center w-50 mx-auto">
	rullaa rokotustilaus taulukkoa alaspäin
	</div>
	<br>

	<!-- TAULUKON HEAD --> 
	<div class="tablestyle">
	<table class="table table-striped table-hover table-light">
	<thead class="bg-primary text-uppercase text-center text-white">
		<tr>
		<th class="thead" scope="col">NR</th>
		<th class="thead" scope="col">ID</th>
		<th class="thead" scope="col">ORDER NUMBER</th>
		<th class="thead" scope="col">RESPONSIBLE PERSON</th>
		<th class="thead" scope="col">HEALTHCARE DISTRICT</th>
		<th class="thead" scope="col">VACCINE</th>
		<th class="thead" scope="col">INJECTIONS</th>
		<th class="thead" scope="col">ARRIVED</th>
		</tr>
	</thead>
	<tbody class="text-center">

	<?php // PHP START

	// Haetaan koko tietokanta
	$kysely = $yhteys->prepare("SELECT nr, id, ordernumber, responsibleperson, healthcaredistrict, vaccine, injections, arrived FROM vacorders");  
	$kysely->execute(); // suoritetaan sql-lause eli haku kannasta  

	// Tulostus
	while ($rivi = $kysely->fetch()) { // käydään kaikki tulosjoukon rivit läpi 

	// tulostetaan rivien kentät taulukkoon
		echo '<tr>'; 
		echo '<td>'. $rivi['nr'] . '</td>';
		echo '<td>'. $rivi['id'] . '</td>';
		echo '<td>'. $rivi['ordernumber'] . '</td>'; 
		echo '<td>'. $rivi['responsibleperson'] . '</td>';
		echo '<td>'. $rivi['healthcaredistrict'] . '</td>';
		echo '<td>'. $rivi['vaccine'] . '</td>';
		echo '<td>'. $rivi['injections'] . '</td>';
		echo '<td>'. $rivi['arrived'] . '</td>';
		echo '</tr>';
	}

	?> <!-- PHP END -->
		
	</tbody>
	</table>
	</div>
	</div>
</div> <!--  rokotustilaukset container end -->
<br>
<br>

<div class="container"> <!-- jumbo footer -->

	<div class="jumbotron jumbotron-fluid bg-primary text-white">
	
	<div class="wrapper text-center text-uppercase">
		<div class="btn-group btn-group-lg">
		<a class="btn btn-primary" href="#tilanne" role="button">Rokotustilanne</a>	
		<a class="btn btn-primary" href="#tilaukset" role="button">Rokotetilaukset</a>  
		</div>	   
		</div>
	</div>
</div> <!-- jumbo header end -->

</main> <!-- MASTER CONTTI end -->

</body>
</html>


















