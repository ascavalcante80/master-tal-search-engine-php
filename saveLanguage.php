<?php
	session_start();
	
	$_SESSION["languageName"] = $_POST["languageName"];		
	$_SESSION["languageCode"] = $_POST["languageCode"];		
	$_SESSION["selectRegion"] = $_POST["selectRegion"];	
		
	$languageName =  trim(str_replace("'", "\\'",  $_POST["languageName"]), " \t\n");
	$langCode = trim(str_replace("'", "\\'",  $_POST["languageCode"]), " \t\n");		
		
	if ($_POST['action'] == 'save') {
		
		if(empty($languageName) || empty($langCode)){
					
			echo "<script>
				alert('Tous les champs doivent être remplis. Ressayez, svp!');
				window.location.href='insertLanguage.php';
				</script>";	 
		} else {

			require_once("query.php");

			$region = $_POST["selectRegion"];
	
			if( !empty($languageName) && !empty($langCode)){
				// Préparation de la requête
				$sql= "INSERT INTO `coogle`.`languages` (`languageName`, `code`, `region_idregion`) VALUES ('".$languageName."', '".$langCode."', '".$region."')";
	
				if ($conn->query($sql) === TRUE) {
		
					// stocker l`id du film qu`on vient de rajouter
					$_SESSION['newlangId'] = $conn->insert_id;
			
					$conn->close();
			
					unset($_SESSION['languageName']);
					unset($_SESSION['languageCode']);
					unset($_SESSION['selectRegion']);
			
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
					$conn->close();
				}
			
				include 'insertTranslation.php';
			} else {
				echo "<script>
				alert('Tous les champs doivent être remplis. Ressayez, svp!');
				window.location.href='insertLanguage.php';
				</script>";	
		
			}
		}
	} elseif($_POST['action'] == 'insertRegion'){
		$_SESSION['previousPage'] = 'insertLanguage.php';	
		include 'insertRegion.php';
	} else {
		include 'insertTranslation.php';
	}

?>
