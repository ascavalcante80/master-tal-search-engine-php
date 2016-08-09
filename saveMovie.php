<?php
	session_start();
	require_once("query.php");
							
	if ($_POST['action'] == 'save') {
	
	
		$_SESSION["englishTitle"] = $_POST["englishTitle"];
		$_SESSION["releaseDate"] = $_POST["releaseDate"];
		$_SESSION["director"] = $_POST["director"];
		$_SESSION["originalTitle"] = $_POST["originalTitle"];
		
		$_SESSION["previousPage"] = 'insertMovie.php';
		
		$englishTitle = cleanString($_POST["englishTitle"]);
		$releaseDate = trim(str_replace("'", "\\'",  $_POST["releaseDate"]), " \t\n");
		$director = trim(str_replace("'", "\\'",  $_POST["director"]), " \t\n");
		$region =  trim(str_replace("'", "\\'",  $_POST["selectRegion"]), " \t\n");
		$originalTitle = trim(str_replace("'", "\\'",  $_POST["originalTitle"]), " \t\n");
		
		
		$sql= "INSERT INTO `movie` (`enTitle`, `releaseDate`, `director`, `originalTitle`, `region_idregion`) VALUES ('".$englishTitle."', '".$releaseDate."', '".$director."', '".$originalTitle."', '".$region."')";
		
		// valider champs 
		if(!empty($englishTitle) && !empty($releaseDate) && !empty($director) && !empty($region) && !empty($originalTitle)){
						
			// envoyer fichier	
			$target_dir = "./pic/";
		
			$fileName = basename($_FILES["fileToUpload"]["name"]);
			
			$fileNameBase = date("Y-m-d-H:i:s")."jpg";
			
			$target_file = $target_dir.$fileNameBase;
			$uploadOk = TRUE;
			$msgErro = "Erreur lors de l'envoie du fichier";
			$imageFileType = substr(pathinfo($fileName, PATHINFO_EXTENSION), -3);
			
			// Check if image file is a actual image or fake image		
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		
			if($check !== false) {
				$uploadOk = TRUE;
			} else {
				$uploadOk = FALSE;
			}
				
			// Check if file already exists
			if (file_exists($target_file)) {
				$uploadOk = FALSE;
			}
		
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 5000000) {
				$msgErro = "La taille du fichier ne peut pas dépasser 5M!";
				$uploadOk = FALSE;
			}
		
	
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$msgErro = "Seulement les fichiers JPG, JPEG, PNG & GIF sont autorisés!";
				$uploadOk = FALSE;
			}
		
			// s
			if ($uploadOk) {
				
				// choisir la requete selon le succes de l'envoye du fichier
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					// Préparation de la requête
					$sql= "INSERT INTO `movie` (`enTitle`, `releaseDate`, `director`, `originalTitle`, `photoAddress`, `region_idregion`) VALUES ('".$englishTitle."', '".$releaseDate."', '".$director."', '".$originalTitle."','".$fileNameBase."', '".$region."')";
					
				}
				
				if ($conn->query($sql) === TRUE) {
		
					// stocker l`id du film qu`on vient de rajouter
					$_SESSION['newmovieId'] = $conn->insert_id;
			
					// libere variables 
					unset($_SESSION["englishTitle"]);
					unset($_SESSION["releaseDate"]);
					unset($_SESSION["director"]);
					unset($_SESSION["originalTitle"]);
					unset($_SESSION["regionName"]);
					unset($_SESSION["previousPage"]);

					$conn->close();
			
					// appeler le nouveau formulaire
					include 'insertTranslation.php';
				
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
					$conn->close();
				}
				
			// afficher message d'erreur liee 'a l'envoie du fichier
			} else {
				echo "<script>
				alert('".$msgErro."');
				window.location.href='insertMovie.php';
				</script>";	
				
			}
			
		} else {
			echo "<script>
			alert('Tous les champs doivent être remplis. Ressayez, svp!');
			window.location.href='insertMovie.php';
			</script>";	 
		}	

	} elseif($_POST['action'] == 'insertRegion'){
		
		$_SESSION["englishTitle"] = $_POST["englishTitle"];
		$_SESSION["releaseDate"] = $_POST["releaseDate"];
		$_SESSION["director"] = $_POST["director"];
		$_SESSION["originalTitle"] = $_POST["originalTitle"];
		$_SESSION["regionName"] = '';
		$_SESSION["previousPage"] = 'insertMovie.php';
		
		// afficher formularie rajouter region
		include 'insertRegion1.php';
				
	}else{
	
		// retourner `a la page d`accueil
		session_destroy();
		include 'index.php';	
	}	
	
	function cleanString($char){
		
			$char = str_replace("'", "\\'",  $_POST["englishTitle"]);
			$char = str_replace("\t", '', $char);
			$char = str_replace("\r", '', $char);
			$char = str_replace("\n", '', $char);
			$char = trim($char, " ");
			return $char;
	}
?>
