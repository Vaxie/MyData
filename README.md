MyData
=========

A simpl system with PHP, MySQL using Bootstrap 3 for the form design.

### Creating the Database

Create database "MyData" and create table "bruger" :

```sql

```

### Setup the `core.php` file :

```php
<?php
if ( ! defined( 'SYSTEM_RUNNING' ) ) {
	header( "location: " . $_SERVER['HTTP_HOST'] . "" ); // Header locate til ...
	exit();
}
define( '_DBHOST', 'localhost' ); // 
define( '_DBUSER', 'root' ); // 
define( '_DBPASS', '' ); //
define( '_DBNAME', '' ); //

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
```

