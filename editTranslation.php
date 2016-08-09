<?php
		
	if (session_status() == PHP_SESSION_NONE) {
		   session_start();
	}
	
	$movieId = $_SESSION['idmovie'];
	$idTrans = $_SESSION['idTrans'];
	$titleTranslated = $_POST['titleTranslated'];
	$literalEnglish = $_POST['literalEnglish'];
	$dist = '0';

	if ($_POST['action'] == 'editTranslation') {
		
		require_once("query.php");
		
		// Préparation de la requête
		$sql= "UPDATE `coogle`.`translations` SET `titleTranslation`='".$titleTranslated."', `literalENTranslation`='".$literalEnglish."', `distanceTranslation`='".$dist."' WHERE `idtranslations`='".$idTrans."' and`movie_idmovie`='".$movieId."'";
	
		if ($conn->query($sql) === TRUE) {
			
			unset($_SESSION["idmovie"]);
			unset($_SESSION["idTrans"]);
							
			$conn->close();		
			// afficher message traduction a ete prise en compte			
			echo "<script>
			alert('Nouvelle traduction enregistrée!');
			window.location.href='http://localhost/projet_final_php/buildMoviePage.php?movieId=".$movieId."';
			</script>";			
			
		} else {
		
			$conn->close();
			// afficher message traduction a ete prise en compte			
			echo "<script>
			alert('\"Houston we have a problem\". Ressayez, svp!');
			window.location.href='insertTranslation.php';
			</script>";	
			$_SESSION['idmovie'] = $movieId;
			include 'insertTranslation.php';
		}
	
		echo "<script>
		alert('Nouvelle traduction enregistrée!');
		window.location.href='buildMoviePage.php?movieId=".$movieId."';
		</script>";		
				
	} else {
		
		echo "<script>
		alert('Aucun changement sera enregistré!');
		window.location.href='buildMoviePage.php?movieId=".$movieId."';
		</script>";
	}

?>
