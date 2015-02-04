<?php
if ( ! defined( 'SYSTEM_RUNNING' ) ) {
	header( "location: " . $_SERVER['HTTP_HOST'] . "" ); // Header locate til ...
	exit();
}
define( '_DBHOST', 'localhost' ); // Vi laver en define command der hedder _DBHOST - navnet er "lige meget" så længe det bliver kaldt længere nede i koden
define( '_DBUSER', 'root' ); // Vi laver en define command der hedder _DBUSER - navnet er "lige meget" så længe det bliver kaldt længere nede i koden
define( '_DBPASS', '' ); // Vi laver en define command der hedder _DBPASS - navnet er "lige meget" så længe det bliver kaldt længere nede i koden
define( '_DBNAME', 'soog' ); // Vi opretter forbindelse til databasen

class MySystem { // Her laver vi en class med navnet MySystem
	protected $DB; // Her

	// I denne fuktion har vi defineret 4 varibalrere da vi skal bruge det til at kunne oprette forbindelse til databasen
	function __construct( $dbHost = _DBHOST, $dbUser = _DBUSER, $dbPass = _DBPASS, $dbName = _DBNAME ) {
		if ( ! $this->DB = new mysqli( $dbHost, $dbUser, $dbPass, $dbName ) ) {
			return false; // Retuner flask hvis ikke datbase findes
		}
	}

}

?>