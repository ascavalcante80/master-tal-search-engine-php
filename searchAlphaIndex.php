<?php
 	 	 	 	
	require_once("connexion.php");

	$letter = $_GET['letter'];
	
	//construire page de resultats
	
 	include 'displayResults.php';
 	insertHeader($letter);
	echo "<div id=\"mainResults\">";
 	echo "<form action=\"buildMoviePage.php\" method=\"post\">";
	
	//---------------------------------------- mecanisme de recherche -------------------------------------------------------------//
	
	// premiere requete simples	
	$resultMovieId = array();
	
	$result = simpleSearch($letter);	
	if($result->rowCount() > 0){
		displayResults($result);
	}
	
	//---------------------------------------- Declaration de fonctions -------------------------------------------------------------//
		
	
	
	// fonction de recherche simples
	function simpleSearch($letter){
	
		global $sql;

		// Préparation de la requête
		$teste = $sql->prepare("SET NAMES 'utf8'");
		$teste ->execute();
		
		if($letter == 'others'){
			$result = $sql->prepare("SELECT * FROM coogle.movie inner join coogle.region on movie.region_idregion=region.idregion order by coogle.movie.originalTitle desc limit 100");			
		} elseif($letter == 'num'){
			$result = $sql->prepare("SELECT * FROM coogle.movie inner join coogle.region on movie.region_idregion=region.idregion WHERE coogle.movie.enTitle REGEXP '^[0-9]'");
		} else {		
			$result = $sql->prepare("SELECT * FROM coogle.movie inner join coogle.region on movie.region_idregion=region.idregion where coogle.movie.originalTitle like ('".$letter."%')") ;
		}
		
		// Envoi de la requête
		$result->execute();

		return $result;	
	}
		
		
// -------------------------------------------- Fonction pour afficher le resultat --------------------------------------------------		
		
	function displayResults($result){
	
		// Récupération des résultats
		global $resultMovieId;
		
		$rows = $result->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($rows as $row) {		
	
			if(!in_array($row['idmovie'], $resultMovieId)){
			
				$movieId = $row['idmovie'];
				$englishTitle = $row['enTitle'];
				$originalTitle = $row['originalTitle'];
				$director = $row['director'];
				$region = $row['regionName'];			
				$year = $row['releaseDate'];	
					
				insertResult('<***>',$movieId, $originalTitle, $englishTitle, $director, $region, $year);
			
				array_push($resultMovieId, $movieId);
				
			}
		}
		
		$nb_lignes = $result->rowCount();
		$result->closeCursor();	
		return $nb_lignes;
	
	}
	
	// inclure le footer de la page 	
	include 'footer.php';
	
?>

