<?php
		
	if (session_status() == PHP_SESSION_NONE) {
		   session_start();
	}
	require_once("query.php");
	
	$movieId = $_SESSION['idMovie'];
	
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
	
	// valider champs 
	if(!empty($englishTitle) && !empty($releaseDate) && !empty($director) && !empty($region) && !empty($originalTitle) && $_POST['action'] == 'editMovie'){
		
		if(!empty($_FILES["fileToUpload"]["name"])){				
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
		
				$sql = '';		
			
				// choisir la requete selon le succes de l'envoye du fichier
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			
			
					// Préparation de la requête
					$sql = "UPDATE `coogle`.`movie` SET `enTitle`='".$englishTitle."', `releaseDate`='".$releaseDate."', `director`='".$director."', `photoAddress`='".$fileNameBase."', `originalTitle`='".$originalTitle."', `region_idregion`='".$region."' WHERE `idmovie`='".$movieId."'";	
				
				}
			
				if ($conn->query($sql) === TRUE) {
			
					// libere variables 
					unset($_SESSION["englishTitle"]);
					unset($_SESSION["releaseDate"]);
					unset($_SESSION["director"]);
					unset($_SESSION["originalTitle"]);
					unset($_SESSION["regionName"]);
					unset($_SESSION["previousPage"]);

					$conn->close();
					echo "<script>
					alert('Changements enregistrés!');
					window.location.href='http://localhost/projet_final_php/buildMoviePage.php?movieId=".$movieId."';
					</script>";
					
				}
				
			} else {
				echo "<script>
				alert('".$msgErro."');
				window.location.href='http://localhost/projet_final_php/buildMoviePage.php?movieId=".$movieId."';
				</script>";
			
			}

		} else {
		
			// enregistrer changements sans modifications d'affiche		
			// Préparation de la requête
				$sql = "UPDATE `coogle`.`movie` SET `enTitle`='".$englishTitle."', `releaseDate`='".$releaseDate."', `director`='".$director."', `originalTitle`='".$originalTitle."', `region_idregion`='".$region."' WHERE `idmovie`='".$movieId."'";	
						
			if ($conn->query($sql) === TRUE) {
		
				// libere variables 
				unset($_SESSION["englishTitle"]);
				unset($_SESSION["releaseDate"]);
				unset($_SESSION["director"]);
				unset($_SESSION["originalTitle"]);
				unset($_SESSION["regionName"]);
				unset($_SESSION["previousPage"]);

				$conn->close();
				echo "<script>
				alert('Changements enregistrés!');
				window.location.href='http://localhost/projet_final_php/buildMoviePage.php?movieId=".$movieId."';
				</script>";
				
			}
		}
	} elseif($_POST['action'] == 'insertRegion'){
	
		$_SESSION['idMovie'] = $movieId;

		$_SESSION["previousPage"] = "displayEditMovie.php";
		include 'insertRegion.php';

	} elseif($_POST['action'] == 'cancel') {
		$_SESSION['idMovie'] = $movieId;

		// libere variables 
		unset($_SESSION["englishTitle"]);
		unset($_SESSION["releaseDate"]);
		unset($_SESSION["director"]);
		unset($_SESSION["originalTitle"]);
		unset($_SESSION["regionName"]);
		unset($_SESSION["previousPage"]);
		
		echo "<script>
		alert('Aucune information sera enregistrée!');
		window.location.href='buildMoviePage.php?movieId=".$movieId."';
		</script>";
		
	} else {
		$_SESSION['idMovie'] = $movieId;
		echo "<script>
		alert('Tous les champs doivent être remplis!');
		window.location.href='displayEditMovie.php?idMovie=".$movieId."';
		</script>";
	
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
