<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- titre de l'onglet -->
	    <title>Coogl∃</title>

        <!-- Déclaration des éléments meta -->
        <meta name="author" content="Alexandre Cavalcante" />
        <meta name="description" content="search about movie titles"/> 
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<link rel="stylesheet" type="text/css" href="style.css"/>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body> 
		<div id="headerForm">		
		<!-- 	Menu dropdown -->		          
  			<div class="dropdown">		
				<img src="buttonMenu.png" type="button" data-toggle="dropdown">
				<ul class="dropdown-menu">
					<li><a href="insertMovie.php">Rajouter Film</a></li>
					<li><a href="aboutUs.php">Qui sommes-nous</a></li>
				</ul>
			</div>		
	   	</div>
	  
        <div id="insertMovie">
		<div class="container">
		  <h2 class="formTitle">Rajouter Nouveau Film</h2>
		  
		  <!-- Debut Formulaire -->
		  
				<?php
					header('Content-Type: text/html; charset=utf-8');
					if (session_status() == PHP_SESSION_NONE) {
 					   session_start();
					}
					
				// recuperer l'id du film lorsque le script est appele' apartir de saveTranslation.php
				if(isset($_SESSION['movieId'])){
					$idmovie = $_SESSION['movieId'];
					session_destroy();
				}
		
				  echo "<form role=\"form\"action=\"saveMovie.php\" method=\"post\" enctype=\"multipart/form-data\">
					<div class=\"form-group\">
					  <label for=\"originalTitle\">Titre Original:</label>";
					  if(!isset($_SESSION['originalTitle'])){
					  	echo "<input type=\"text\" class=\"form-control\" name=\"originalTitle\" placeholder=\"Insérez le titre original du film\">";					  	
					  } else {
					  	echo "<input type=\"text\" class=\"form-control\" name=\"originalTitle\" value=\"".$_SESSION['originalTitle']."\">";
					  }
					echo "</div>
					<div class=\"form-group\">
					  <label for=\"englishTitle\">Titre en anglais:</label>";
					  
					  if(!isset($_SESSION['englishTitle'])){
						  echo "<input type=\"text\" class=\"form-control\" name=\"englishTitle\" placeholder=\"Insérez le titre en anglais\">";
					    	
					  } else {
						  echo "<input type=\"text\" class=\"form-control\" name=\"englishTitle\" value=\"".$_SESSION['englishTitle']."\">";				  
					  }
					  echo "				  
					</div>
					<div class=\"form-group\">
					  <label for=\"director\">Nom du réalisateur:</label>";
					  					  
					  if(!isset($_SESSION['director'])){
						  echo "<input type=\"text\" class=\"form-control\" name=\"director\" placeholder=\"Insérez le nom du réalisateur\">";							    	
					  } else {
						  echo "<input type=\"text\" class=\"form-control\" name=\"director\" value=\"".$_SESSION['director']."\">";	  
					  }
					  
					  echo "
					</div>
					<div class=\"form-group\">
					  <label for=\"releaseDate\">Année de sortie:</label>";					  
					  
					  if(!isset($_SESSION['releaseDate'])){
						  echo "<input type=\"number\" min=\"1890\" max=\"".date("Y")."\" class=\"form-control\" name=\"releaseDate\" placeholder=\"Année où le film est sorti\">";							    	
					  } else {
						  echo "<input type=\"number\" min=\"1890\" max=\"".date("Y")."\" class=\"form-control\" name=\"releaseDate\" value=\"".$_SESSION['releaseDate']."\">";	  
					  }
					  
					  echo "
					</div>
					<div class=\"form-group\">
					  <label for=\"region\">Pays / Région:</label>";			

					require_once("connexion.php");
					
					// regler l'encodage pour utf8 ---> si ce code est enleve, la fonction utf8_encode() doit etre utilisee
					$teste = $sql->prepare("SET NAMES 'utf8'");
					$teste ->execute();
										
					// Préparation de la requête
					$result = $sql->prepare("select idregion, regionName from coogle.region order by coogle.region.regionName;") ;

					// Envoi de la requête
					$result->execute();
				
					$buildSelect = "<select name=\"selectRegion\">";
				
					// Récupération des résultats
					
					$rows = $result->fetchAll(PDO::FETCH_ASSOC);

					foreach ($rows as $row) {		

						$idregion = $row['idregion'];
						$regionName = $row['regionName'];	
							
						if(!isset($_SESSION['regionName'])){
							$buildSelect = $buildSelect."<option value=\"".$idregion."\">".$regionName."</option>";
						} elseif ($_SESSION['selectRegion'] == $idregion) {
							$buildSelect = $buildSelect."<option value=\"".$idregion."\" selected>".$regionName."</option>";
						} else {
							$buildSelect = $buildSelect."<option value=\"".$idregion."\">".$regionName."</option>";
						}
					}

					$buildSelect = $buildSelect."</select>";
											
					echo $buildSelect;
					$result->closeCursor();

					echo "<button type=\"submit\" class=\"btn btn-default btn-sm\" name=\"action\" value=\"insertRegion\" title=\"Cliquer ici pour rajouter un nouveau pays ou région. Les informations déjà insérées seront conservées.\"><span class=\"glyphicon glyphicon-plus\"></span></button>";
					
				?>
			</br>
			</br>
			<div>
			  	<label>Affiche du film:</label>
				<span class="btn btn-default btn-file"><span>Choisir fichier</span>
				<input type="file" name="fileToUpload" id="fileToUpload"></span>
				
				<span class="fileinput-filename"></span>
				
			</div>		
			<div class="submitButton">
				<button type="submit" name="action" class="btn btn-default" value="cancel" >Annuler</button>				
				<button type="submit" name="action" class="btn btn-default" value="save">Enregistrer & Continuer</button>
			</div>
		  </form>
		</div>
        </div>
    </body>
</html>
