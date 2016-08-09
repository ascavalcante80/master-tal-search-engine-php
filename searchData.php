<?php
 	 	 	 	
	require_once("connexion.php");
	
	$noResults = TRUE;

	$search = $_POST['searchField'];
	
	//construire page de resultats
 	include 'displayResults.php';
 	insertHeader($search);
	echo "<div id=\"mainResults\">";
 	echo "<form action=\"buildMoviePage.php\" method=\"post\">";
 	
 	
 	// nettoyer requete
 	$search = str_replace("'", "''", $search);
 	
 	
	
	//---------------------------------------- mecanisme de recherche -------------------------------------------------------------//
	
	//  PREMIERE SERIE --------------- RECHERCHE MATCH PARFAIT --------------------------------
	$resultMovieId = array();
	
	$result = simpleSearch("movie", "enTitle", $search);	
	if($result->rowCount() > 0){
		displayResults($result, $search);		
	}
		
	$result = simpleSearch("movie", "originalTitle", $search);
	if($result->rowCount() > 0){
		displayResults($result, $search);		
	}
	
	$result = simpleSearchTranslation($search);
	if($result->rowCount() > 0){
		displayTranslationResults($result, $search);		
	}
	
	$result = simpleSearch("movie", "director", $search);
	if($result->rowCount() > 0){
		displayResults($result, $search);		
	}
	
	
	//  DEUXIEME SERIE --------------- RECHERCHE DE MOTS --------------------------------
	$result = searchWordOnMovieTable("enTitle", $search);
	$nb_lignes = displayResults($result, $search);	

	if($nb_lignes < 10){
			
			// deuxieme recherche
			$result = searchWordOnMovieTable("originalTitle", $search);
			$nb_lignes = displayResults($result, $search);
			
			if($nb_lignes < 10){								
			
					// troisieme recherche
					$result = searchWordInTranslationTable($search);
					$nb_lignes = displayTranslationResults($result, $search);
					
					if($nb_lignes < 10){

						// quatrieme recherche
						$result = searchWordOnMovieTable("director", $search);
						$nb_lignes = displayResults($result, $search);
						
						
						//  TROISIEME SERIE --------------- RECHERCHE DE SUBSTRINGS --------------------------------
						if($nb_lignes < 10){
									
							// septieme recherche
							$result = searchSubStringOnMovieTable("enTitle", $search);
							$nb_lignes = displayResults($result, $search); 
							
							if($nb_lignes < 10){

								// cinquieme recherche
								$result = searchSubStringOnMovieTable("originalTitle", $search);
								$nb_lignes = displayResults($result, $search); 
							
								if($nb_lignes < 10){

									// sixieme recherche
									$result = searchSubStringInTranslationTable($search);
									$nb_lignes = displayTranslationResults($result, $search);
								
									if($nb_lignes < 10){
									
										// septieme recherche
										$result = searchSubStringOnMovieTable("director", $search);
										displayResults($result, $search);
									
										if($noResults){
											echo "<h3> Désolé, mais le super moteur de recherche Coogle n'a trouvé aucun résultat à la recherche \"<i><b>".$search."</i></b>\" :-( </h3>";
										}
									}								
								}						
							}					
						}
					}
				}
			}
	
	
	
	//---------------------------------------- Declaration de fonctions -------------------------------------------------------------//
		
	
	
	// fonction de recherche simples
	function simpleSearch($table, $champ, $arg){
	
		global $sql;

		// Préparation de la requête
		$teste = $sql->prepare("SET NAMES 'utf8'");
		$teste ->execute();
		$result = $sql->prepare("SELECT * FROM ".$table." inner join coogle.region on movie.region_idregion=region.idregion WHERE ".$champ." ='".$arg."'") ;

		// Envoi de la requête
		$result->execute();

		return $result;	
	}
	
	function simpleSearchTranslation($arg){
	
		global $sql;

		// Préparation de la requête
		$teste = $sql->prepare("SET NAMES 'utf8'");
		$teste ->execute();
		$result = $sql->prepare("SELECT * FROM coogle.movie inner join coogle.translations on movie.idmovie=translations.movie_idmovie inner join coogle.region on movie.region_idregion=region.idregion WHERE titleTranslation='".$arg."'") ;

		// Envoi de la requête
		$result->execute();

		return $result;	
	}
	
		
	
	// Chercher une string dans la table m
	function searchWordOnMovieTable($champ, $arg){
	
		global $sql;

		// Préparation de la requête
		$teste = $sql->prepare("SET NAMES 'utf8'");
		$teste ->execute();
		
		// eliminer doubles espaces a l'interieur du string
		$arg = preg_replace("/\s\s+/", ' ', $arg);
		$arg = preg_replace("/(-|,|:|!|\?|\)|\(|\.)+/", ' ', $arg);
		
		$args = explode(" ", $arg);		
		$size = sizeof($args);
		
		// vérifier si nombre de mots est plus grand que zero
		if($size > 0) {
			
			// construire requete avec plusieurs items - concatenation d'items
			$requete = str_replace(" ", "%' AND ".$champ." LIKE '%", $arg);
			$requete =  $champ." LIKE '%".$requete."%'";
			$query = "SELECT * FROM movie inner join coogle.region on movie.region_idregion=region.idregion WHERE (".$requete.")";
		
			$result = $sql->prepare($query);

			// Envoi de la requête
			$result->execute();
			return $result;
		
		} else {

			$result = $sql->prepare("SELECT * FROM movie inner join coogle.region on movie.region_idregion=region.idregion WHERE ".$champ." LIKE CONCAT('".$arg." ', '%') or ".$champ." LIKE CONCAT('%', ' ".$arg." ', '%') or ".$champ." LIKE CONCAT('%', ' ".$arg."')") ;

			// Envoi de la requête
			$result->execute();
			return $result;
		
		}		
	}
	
	
	function searchSubStringOnMovieTable($champ, $arg){
	
		global $sql;
		
		// Préparation de la requête
		$teste = $sql->prepare("SET NAMES 'utf8'");
		$teste ->execute();
		$result = $sql->prepare("SELECT * FROM movie WHERE ".$champ." LIKE CONCAT('%','".$arg."', '%') inner join coogle.region on movie.region_idregion=region.idregion");

		// Envoi de la requête
		$result->execute();

		return $result;	
	}
	
	
	function searchWordInTranslationTable($arg){
		
		global $sql;

		// Préparation de la requête
		$teste = $sql->prepare("SET NAMES 'utf8'");
		$teste ->execute();
		
		// eliminer doubles espaces a l'interieur du string
		$arg = preg_replace("/\s\s+/", ' ', $arg);
		$arg = preg_replace("/(-|,|:|!|\?|\)|\(|\.)+/", ' ', $arg);
		
		$args = explode(" ", $arg);		
		$size = sizeof($args);
		
		// vérifier si nombre de mots est plus grand que zero
		if($size > 0) {
			
			// construire requete avec plusieurs items - concatenation d'items
			$requete = str_replace(" ", "%' AND titleTranslation LIKE '%", $arg);
			$requete =  "titleTranslation LIKE '%".$requete."%'";
			
			$query = "SELECT * FROM coogle.movie inner join coogle.translations on movie.idmovie=translations.movie_idmovie inner join coogle.region on movie.region_idregion=region.idregion WHERE (".$requete.")";
			
			$result = $sql->prepare($query) ;

			// Envoi de la requête
			$result->execute();
			return $result;
		
		} else {

			$result = $sql->prepare("SELECT * FROM coogle.movie inner join coogle.translations on movie.idmovie=translations.movie_idmovie inner join coogle.region on movie.region_idregion=region.idregion WHERE titleTranslation LIKE CONCAT('".$arg." ', '%') or titleTranslation LIKE CONCAT('%', ' ".$arg." ', '%') or titleTranslation LIKE CONCAT('%', ' ".$arg."')") ;

			// Envoi de la requête
			$result->execute();

			return $result;	
		
		}

	}
	
	
	function searchSubStringInTranslationTable($arg){
	
		global $sql;
		
		// régler la requete pour utf8
		$teste = $sql->prepare("SET NAMES 'utf8'");
		$teste ->execute();
		
		// Préparation de la requête
		$result = $sql->prepare("SELECT * FROM coogle.movie inner join coogle.translations on movie.idmovie=translations.movie_idmovie inner join coogle.region on movie.region_idregion=region.idregion WHERE titleTranslation LIKE CONCAT('%', '".$arg."', '%')") ;
		
		// Envoi de la requête
		$result->execute();

		return $result;	
	}
		
		
// -------------------------------------------- Fonction pour afficher le resultat --------------------------------------------------		
		
	function displayResults($result, $search){
			
		// Récupération des résultats
		global $resultMovieId;
		global 	$noResults;

		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
	
		foreach ($rows as $row) {		
		
			if(!in_array($row['idmovie'], $resultMovieId)){
				$noResults = FALSE;
				
				$movieId = $row['idmovie'];
				$englishTitle = $row['enTitle'];
				$originalTitle = $row['originalTitle'];
				$director = $row['director'];
				$region = $row['regionName'];
				$year = $row['releaseDate'];
				
				insertResult($search, $movieId, $originalTitle, $englishTitle, $director, $region, $year);
				
				array_push($resultMovieId, $movieId);				
			}							
		}
		
		$nb_lignes = $result->rowCount();
		$result->closeCursor();	
		return $nb_lignes;	
	}
		
	
	function displayTranslationResults($result, $search){
	
		// Récupération des résultats
		global $resultMovieId;
		global 	$noResults;
	
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
	
		foreach ($rows as $row) {		
		
			if(!in_array($row['idmovie'], $resultMovieId)){
				
				$noResults = FALSE;
				
				$movieId = $row['idmovie'];
				$originalTitle = $row['originalTitle'];
				$titleTranslation = $row['titleTranslation'];
				$director = $row['director'];
				$region = $row['regionName'];
				$year = $row['releaseDate'];
				
				insertResult($search, $movieId, $originalTitle, $titleTranslation, $director, $region, $year);
				
				array_push($resultMovieId, $movieId);				
			}							
		}
		

		$nb_lignes = $result->rowCount();
		$result->closeCursor();	
		return $nb_lignes;	
	}
	
	include 'footer.php';
?>

