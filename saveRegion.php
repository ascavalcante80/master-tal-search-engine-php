<?php
	session_start();
	require_once("query.php");
				
	if ($_POST['action'] == 'save') {
	
		$regionName = trim(str_replace("'", "\\'",  $_POST["regionName"]), " \t\n");
				
		if(empty($regionName) || !isset($regionName)){
	
			echo "<script>
			alert('Tous les champs doivent être remplis. Ressayez, svp!');
			window.location.href='insertRegion.php';
			</script>";	 
		
		}else{
		
			// Préparation de la requête
			$sql= "INSERT INTO `region` (`regionName`) VALUES ('".$regionName."')";
	
			if ($conn->query($sql) === TRUE) {
				
				$_SESSION['selectRegion'] = $conn->insert_id;
				$conn->close();
			
				// retourne `a page qui a appelle la fonction
				include $_SESSION['previousPage'];
			
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
				$conn->close();
			}			
		}
					

	} else{

		// retourne `a page qui a appelle la fonction
		include $_SESSION['previousPage'];	
	}

?>
