<?php
	session_start();
	
	$previsousPage;
	if(isset($_SESSION['previousPageTrans'])){
		$previsousPage = $_SESSION['previousPageTrans'];
	}
	
	
	$_SESSION["titleTranslated"] = $_POST["titleTranslated"];
	$_SESSION["literalEnglish"] = $_POST["literalEnglish"];				
		
	$titleTrans =  trim(str_replace("'", "\\'",  $_POST["titleTranslated"]), " \t\n");
	$literalEnglish = trim(str_replace("'", "\\'",  $_POST["literalEnglish"]), " \t\n");
	
	
		if ($_POST['action'] == 'insertTranslation') {		
		
			if(empty($titleTrans) || empty($literalEnglish)){
				echo "<script>
					alert('Tous les champs doivent être remplis. Ressayez, svp!');
					window.location.href='insertTranslation.php';
					</script>";	 
			} else {
		
				// INCLUIR CODIGO PARA INSERIR TRADUCAAAAOOO AQUI
						
				require_once("query.php");

				$idmovie = $_SESSION['newmovieId'];
				$langId = $_POST["selectLanguages"];
				$dist = '0';
		
				// Préparation de la requête
				$sql= "INSERT INTO `coogle`.`translations` (`movie_idmovie`, `titleTranslation`, `literalENTranslation`, `languages_idlanguages`, `distanceTranslation`) VALUES ('".$idmovie."', '".$titleTrans."', '".$literalEnglish."', '".$langId."', '".$dist."')";
	
				if ($conn->query($sql) === TRUE) {
			
					unset($_SESSION["titleTranslated"]);
					unset($_SESSION["literalEnglish"]);
					unset($_SESSION["selectLanguages"]);
							
					$conn->close();
		
					// afficher message traduction a ete prise en compte			
					echo "<script>
					alert('La nouvelle traduction a été rajoutée. Merci!');
					window.location.href='insertTranslation.php';
					</script>";		
					include 'insertTranslation.php';
			
				} else {
		
					$conn->close();
					// afficher message traduction a ete prise en compte			
					echo "<script>
					alert('\"Houston we have a problem\". Ressayez, svp!');
					window.location.href='insertTranslation.php';
					</script>";	
			
					include 'insertTranslation.php';
				}
			}		
		} elseif($_POST['action'] == 'insertLangue'){
					
			$_SESSION['previousPage'] = 'insertTranslation.php';		
			include 'insertLanguage.php';	
	
		}else {
		

			if(!empty($previsousPage)){

				$_SESSION['movieId'] = $previsousPage;			
				include 'buildMoviePage.php';			
			
			} else{
		
				session_destroy();
				include 'index.php';
			}
		}
	
?>
