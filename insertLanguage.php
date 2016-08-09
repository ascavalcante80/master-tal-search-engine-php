<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- titre de l'onglet -->
	    <title>Coogl∃</title>

        <!-- Déclaration des éléments meta -->
        <meta name="author" content="Alexandre Cavalcante" />
        <meta name="description" content="search about movie titles"/>    
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body> 
		<div id="headerForm">		
		<!-- 	Menu dropdown -->		          
  			<div class="dropdown">		
				<img src="buttonMenu.png" type="button" data-toggle="dropdown">
				<ul class="dropdown-menu">
					<li><a href="insertMovie.php">Rajouter film</a></li>
					<li><a href="#">Qui sommes nous</a></li>
				</ul>
			</div>		
	   	</div>
	  
        <div id="insertMovie">
		<div class="container">
		  <h2 style = "text-align:center;">Rajouter Langue</h2>
				<?php
					if (session_status() == PHP_SESSION_NONE) {
					   session_start();
					}

					echo "<form role=\"form\" action=\"saveLanguage.php\" method=\"post\">
				  
					<div class=\"form-group\">
					  <label for=\"languageName\">Langue:</label>";
					  
					  if(!isset($_SESSION['languageName'])){
					  	echo "<input type=\"text\" class=\"form-control\" name=\"languageName\" placeholder=\"Insérez le nom de la langue\">";	
					  } else {
					  	echo "<input type=\"text\" class=\"form-control\" name=\"languageName\" value=\"".$_SESSION['languageName']."\">";
					  }
					echo "</div>
			
					<div class=\"form-group\">
					  <label for=\"languageCode\">Code de la Langue:</label>";
					 
					 if(!isset($_SESSION['languageCode'])){					 
						echo "<input type=\"text\" class=\"form-control\" name=\"languageCode\" placeholder=\"Insérez le code de la langue en deux caractères\">";
					 } else {
					 	echo "<input type=\"text\" class=\"form-control\" name=\"languageCode\" value=\"".$_SESSION['languageCode']."\">";
					 }
					 
					echo "</div>
								
					<div class=\"form-group\">
					  <label for=\"language\">Pays / Région:</label>";
			
			
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
							
						if(!isset($_SESSION['selectRegion'])){
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
				
					echo "<button type=\"submit\" class=\"btn btn-default btn-sm\" name=\"action\" value=\"insertRegion\" title=\"Cliquez ici pour rajouter un nouveau pays ou région. Les informations déjà insérées seront conservées.\"><span class=\"glyphicon glyphicon-plus\"></span></button>";
											
				?>
			
			
			</div>
			</div>
			<div class="form-group">

			</div>				
			<div class="submitButton">
				<button type="submit" name="action" class="btn btn-default" value="cancel" >Annuler</button>
				<button type="submit" name="action" class="btn btn-default" value="save" >Enregistrer</button>			
			</div>
		  </form>
		</div>
        </div>
    </body>
</html>
