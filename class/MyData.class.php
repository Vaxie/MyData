<?php
if ( ! defined( 'SYSTEM_RUNNING' ) ) {
	header( "location: " . $_SERVER['HTTP_HOST'] . "" );
	exit();
}

/**
 * Definer MyData som snakker sammen med MySystem ligesom en form for core.php(databse connecnt)
 */
class MyData extends MySystem {
	private function beregnDato( $input ) { // Her laver vi en privat fuktion
		$dato = date( "d-m-Y", (int) $input ); // Sørger for at datoen vises korreket

		return $dato;
	}

	/**
	 * Definer public function
	 */
	public function getData() {
		if ( $stmt = $this->DB->prepare( "SELECT `id`, `navn`, `brugernavn`, `password`, `stamp` FROM `bruger`" ) ) {
			// $stmt->bind_param(); // Skal ikke med når der ikke er tale om parameteroverførsel
			// Henter jo blot alle felter fra database!
			$stmt->execute();
			$stmt->bind_result( $id, $navn, $brugernavn, $password, $stamp );
			while ( $stmt->fetch() ) {
				$navneArray[] = "
				<form action=\"\" method=\"post\">
					id: <input type=\"hidden\" readonly=\"readonly\" value=\"" . $id . "\" name=\"brugerId\" />
					Navn: <input type=\"text\" name=\"navn\" value=\"" . $navn . "\" />
					Brugernavn: <span class=\"displayUsrName\">" . $brugernavn . "</span>
					Password: <input type=\"text\" name=\"password\" value=\"" . $password . "\" />
					Oprettet: <span class=\"displayUsrName\">" . $this->beregnDato( $stamp ) . "</span>
					<input type=\"submit\" value=\"Ret bruger\" name=\"updateUsr\" />
					<input type=\"submit\" value=\"Slet bruger\" name=\"deleteUsr\" onClick=\"return confirm('Er du sikker?');\"/>
				</form>";
			}
			$stmt->close();
		}

		return $navneArray;
	}

	/**
	 * Definer public function
	 */
	public function updateData( $id, $navn, $password ) {
		if ( $stmt = $this->DB->prepare( 'UPDATE `bruger` SET `navn`=?, `password`=?  WHERE `id`=?' ) ) {
			$stmt->bind_param( 'ssi', $navn, $password, $id );
			$stmt->execute();
			$stmt->close();

			return true;
		}
	}

	/**
	 * Definer public function
	 */
	public function deleteUsr( $id ) {
		if ( $stmt = $this->DB->prepare( 'DELETE FROM `bruger` WHERE `id`=?' ) ) {
			$stmt->bind_param( 'i', $id );
			$stmt->execute();
			$stmt->close();
		}
	}

	/**
	 * Definer public function
	 */
	public function displayInsertForm() {
		$form = "
			<fieldset class=\"padding10 margin10\">
				<legend>Indsæt ny bruger</legend>
				<form action=\"\" method=\"post\">
					Navn: <input type=\"text\" name=\"navn\" />
					Brugernavn: <input type=\"text\" name=\"brugernavn\" />
					Password: <input type=\"text\" name=\"password\" />
					<input type=\"submit\" value=\"Indsæt bruger\" name=\"insertUsr\" />
				</form>
			</fieldset>";

		return $form;
	}

	/**
	 * Definer public function
	 */
	public function insertData( $navn, $brugernavn, $password ) {
		if ( $stmt = $this->DB->prepare( 'INSERT INTO `bruger` (`navn`, `brugernavn`, `password`, `stamp`) VALUES (?, ?, ?, ?)' ) ) {
			$stmt->bind_param( 'sssi', $navn, $brugernavn, $password, $stamp_now );
			$stamp_now = time();
			$stmt->execute();
			$stmt->close();

			return true;
		}
	}

	/**
	 * Definer public function
	 */
	public function displaySearch() {
		$form = "
			<fieldset class=\"padding10 margin10\">
				<legend>Søg efter data</legend>
				<form action=\"\" method=\"post\">
					<input type=\"text\" name=\"soegefelt\" />
					<input type=\"submit\" value=\"Søg\" name=\"Search\" />
				</form>
			</fieldset>";

		return $form;
	}

	/**
	 * Definer public function
	 */
	public function mySearch( $soegestreng ) {
		// Vedr. IN NATURAL LANGUAGE MODE
		// Hvis ovenstående udtryk ikke giver forventede resultater, så brug IN BOLEAN MODE
		// Tabel skal være sat til MyISAM ( ALTER TABLE tabelnavn ENGINE=MyISAM; )
		// Desuden skal de kolonner der skal søges i være FULLTEXT-indexerede ( ALTER TABLE tabelnavn ADD FULLTEXT (kolonnenavn, kolonnenavn, ...); )
		if ( $stmt = $this->DB->prepare( "
										SELECT `id`, `navn`, `brugernavn`, `password`, `stamp`, `historie` FROM `bruger`
										WHERE MATCH (`historie`) AGAINST (? IN NATURAL LANGUAGE MODE) 
										" )
		) {
			$stmt->bind_param( 's', $soegestreng );
			$stmt->execute();
			$stmt->bind_result( $id, $navn, $brugernavn, $password, $stamp, $historie );
			while ( $stmt->fetch() ) {
				$navneArray[] = "
				<div class=\"result\">
					id: <input type=\"hidden\" readonly=\"readonly\" value=\"" . $id . "\" name=\"brugerId\" />
					Navn: <input type=\"text\" name=\"navn\" value=\"" . $navn . "\" />
					Brugernavn: <span class=\"displayUsrName\">" . $brugernavn . "</span>
					Password: <input type=\"text\" name=\"password\" value=\"" . $password . "\" />
					Oprettet: <span class=\"displayUsrName\">" . $this->beregnDato( $stamp ) . "</span>
					<p>" . $historie . "</p>
				</div>";
			}
			if ( empty( $navneArray ) ) {
				$navneArray[] = "<p>Desværre. <span class=\"displaySearchResult\">" . $soegestreng . "</span> resulterede ikke i nogen resultater.</p>";
			}
			$stmt->close();
		}

		return $navneArray;
	}
}

?>