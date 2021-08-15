<?php
// Yhteys kantaan: tietokantamoottori, ip-osoite,tietokannan nimi
$yhteys = "mysql:host=localhost;dbname=vacdatabase"; 
$kayttajatunnus = "root"; // DEFAULT TUNNUS. 
$salasana = "root";  // MAMP PRO DEFAULT PASSWORD

// Virhetarkistus päälle
try {
	$yhteys = new PDO($yhteys, $kayttajatunnus, $salasana); // luodaan yhteys olio PDO-luokasta
	$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // jatkuva yhteys
	$yhteys->exec("SET CHARACTER SET utf8;"); // Varmistetaan merkistö
}
catch (PDOException $e) {
	die("Tietokantaan ei saada yhteyttä. Virhe: ".$e);
}
?>