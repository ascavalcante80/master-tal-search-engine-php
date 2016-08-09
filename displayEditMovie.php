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
		  <h2 class="formTitle">Éditer Film</h2>
		  
		  <!-- Debut Formulaire -->
		  
				<?php
					$idmovie;
					header('Content-Type: text/html; charset=utf-8');
					if (session_status() == PHP_SESSION_NONE) {
 						session_start();
						$_SESSION['idMovie'] = $_GET['idMovie'];;
						$idmovie = $_GET['idMovie'];
					} else {				
						$idmovie = $_SESSION['idMovie'];					
						echo $idmovie;
					}
					
					
					// Préparation de la requête
					require_once("connexion.php");
					$teste = $sql->prepare("SET NAMES 'utf8'");
					$teste ->execute();
					$result = $sql->prepare("SELECT * FROM movie inner join coogle.region on movie.region_idregion=region.idregion where idmovie=".$idmovie);
					$result->execute();
					$row = $result->fetch(PDO::FETCH_OBJ);
					$englishTitle = $row->enTitle;
					$originalTitle = $row->originalTitle;
					$director = $row->director;
					$region = $row->regionName;
					$year = $row->releaseDate;
					$photo = $row->photoAddress;
							
				  	echo "<form role=\"form\"action=\"editMovie.php\" method=\"post\" enctype=\"multipart/form-data\">
					<div class=\"form-group\">
					  <label for=\"originalTitle\">Titre Original:</label>";
					echo "<input type=\"text\" class=\"form-control\" name=\"originalTitle\" value=\"".$originalTitle ."\">";					
					echo "</div>
					<div class=\"form-group\">
					  <label for=\"englishTitle\">Titre en anglais:</label>";
					  echo "<input type=\"text\" class=\"form-control\" name=\"englishTitle\" value=\"".$englishTitle."\">";				  
					  echo "				  
					</div>
					<div class=\"form-group\">
					  <label for=\"director\">Nom du réalisateur:</label>";
					  echo "<input type=\"text\" class=\"form-control\" name=\"director\" value=\"".$director."\">";	  
					  					  
					  echo "
					</div>
					<div class=\"form-group\">
					  <label for=\"releaseDate\">Année de sortie:</label>";					  
					 echo "<input type=\"number\" min=\"1890\" max=\"".date("Y")."\" class=\"form-control\" name=\"releaseDate\" value=\"".	$year."\">";
					 echo "
					</div>
					<div class=\"form-group\">
					  <label for=\"region\">Pays / Région:</label>";			
					
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
				<button type="submit" name="action" class="btn btn-default" value="editMovie">Enregistrer</button>
			</div>
		  </form>
		</div>
        </div>
    </body>
</html>
