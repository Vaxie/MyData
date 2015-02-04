<?php
include_once( "includes/core.php" );// Denne fil inkluderes fra core.php, så der er allerede hul igennem
$dataAgent = new MyData(); // Her definer vi vores fuktinon som er nævnt i MyData ellers så vil der ikke være hul igennem til vores fuktion

if ( isset( $_POST['insertUsr'] ) ) { // Hvis der er trykket på $_POST 'insertUsr'
	$navn = htmlspecialchars( $_POST['navn'] );
	   // Betydning af htmlspecialchars //
	// Visse "koder" har en særlig betydning i HTML, og bør derfor blevet skrevet i ren html-kode, hvis det skal blive set ordenlig.
	// Denne funktion returnerer en streng med disse konverteringer lavet.
	$brugernavn = htmlspecialchars( $_POST['brugernavn'] );
	$password   = htmlspecialchars( $_POST['password'] );

	if ( $dataAgent->insertData( $navn, $brugernavn, $password ) ) {
		$msg = "Bruger <span class=\"displayUsrName\">" . $brugernavn . "</span> er indsat";
	}
}
if ( isset( $_POST['updateUsr'] ) ) {
	$id         = (int) $_POST['brugerId'];
	$navn       = htmlspecialchars( $_POST['navn'] );
	$brugernavn = htmlspecialchars( $_POST['brugernavn'] );
	$password   = htmlspecialchars( $_POST['password'] );

	if ( $dataAgent->updateData( $id, $navn, $password ) ) {
		$msg = "Bruger med id <span class=\"displayUsrName\">" . $id . "</span> er opdateret";
	}
}
if ( isset( $_POST['deleteUsr'] ) ) { //Hvis der er trykket på $_POST 'deleteUsr'
	$id = (int) $_POST['brugerId']; // Hent brugerId
	$dataAgent->deleteUsr( $id ); // Sletter tabel brugerId
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="style/stylesheet.css"/>
	<script type="text/javascript" language="javascript">
		function go2Get(id) {
			document.location = "index.php?" + id;
		}
	</script>
</head>

<body>
<?php
if ( $msg ) {
	echo "<h3>Besked: " . $msg . "</h3>";
}
?>
<p>&nbsp;</p>
<?php
if ( isset( $_GET['showAll'] ) ) {
	$arr = $dataAgent->getData();
	echo "<div id=\"showLink\">";
	foreach ( $arr AS $key => $value ) {
		echo $value;
	}
	?>
        
            <p><input type="button" value="Skjul alle" onClick="go2Get('')" /></p>
        </div>
    <?php
} else {
	?>
	<div id="showLink">
		<p><input type="button" value="Vis alle" onClick="go2Get('showAll')"/></p>
	</div>
<?php
}

if ( isset( $_GET['showForm'] ) ) {
	// Vis formular til indsættelse
	echo $dataAgent->displayInsertForm();
} else {
	?>
	<div id="showForm">
		<p><input type="button" value="Indsæt bruger" onClick="go2Get('showForm')"/></p>
	</div>
<?php
}
echo $dataAgent->displaySearch();
if ( isset( $_POST['soegefelt'] ) ) {
	$arr = $dataAgent->mySearch( htmlspecialchars( $_POST['soegefelt'] ) );
	if ( $arr ) {
		foreach ( $arr AS $key => $value ) {
			echo "<p>" . $value . "</p>";
		}
	}
}
?>
</body>
</html>