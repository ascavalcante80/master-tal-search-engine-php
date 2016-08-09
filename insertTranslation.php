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
					<li><a href="aboutUs.php">Qui sommes-nous</a></li>
				</ul>
			</div>		
	   	</div>
	  
        <div id="insertMovie">
		<div class="container">
		  <h2 style="text-align:center;">Rajouter Traduction</h2>
			<?php
	
			if (session_status() == PHP_SESSION_NONE) {
			   session_start();
			}

			  echo "<form role=\"form\" action=\"saveTranslation.php\" method=\"post\">
			  
				<div class=\"form-group\">
				  <label for=\"originalTitle\">Titre traduit:</label>";
				  
				  
				  if(!isset($_SESSION['titleTranslated'])){
						  echo "<input type=\"text\" class=\"form-control\" name=\"titleTranslated\" placeholder=\"Insérez la traduction du titre original\">";		    	
					  } else {
						  echo "<input type=\"text\" class=\"form-control\" name=\"titleTranslated\" value=\"".$_SESSION['titleTranslated']."\">";	  
					  }
					  
				  echo "</div>
			
				<div class=\"form-group\">
				  <label for=\"englishTitle\">Traduction littérale en anglais:</label>";
				  
				  
				   if(!isset($_SESSION['literalEnglish'])){
						  echo "<input type=\"text\" class=\"form-control\" name=\"literalEnglish\" placeholder=\"Insérez la traduction littérale du titre en anglais\">";		    	
					  } else {
						  echo "<input type=\"text\" class=\"form-control\" name=\"literalEnglish\" value=\"".$_SESSION['literalEnglish']."\">";	  
					  }
				
				  echo "</div>
			
				<div class=\"form-group\">
				  <label for=\"language\">Langue / Région :</label>";
				  				
				require_once("connexion.php");
				
				// regler l'encodage pour utf8 ---> si ce code est enleve, la fonction utf8_encode() doit etre utilisee
				$teste = $sql->prepare("SET NAMES 'utf8'");
				$teste ->execute();				
				
				// Préparation de la requête
				$result = $sql->prepare("select languages.idlanguages, languages.languageName, region.regionName from languages inner join region on languages.region_idregion=region.idregion;" ) ;

				// Envoi de la requête
				$result->execute();
				
				//echo "<select name=\"country\"";
				$buildSelect = "<select name=\"selectLanguages\">";
				
				// Récupération des résultats				
				$rows = $result->fetchAll(PDO::FETCH_ASSOC);
	
				foreach ($rows as $row) {		
	
					$idlanguages = $row['idlanguages'];
					$languageName = $row['languageName'];	
					$regionName = $row['regionName'];	
		
					if(!isset($_SESSION['newlangId'])){
							$buildSelect = $buildSelect."<option value=\"".$idlanguages."\">".$languageName." / ".$regionName."</option>";				
						} elseif ($_SESSION['newlangId'] == $idlanguages) {
							$buildSelect = $buildSelect."<option value=\"".$idlanguages."\" selected>".$languageName." / ".$regionName."</option>";
						} else {
							$buildSelect = $buildSelect."<option value=\"".$idlanguages."\">".$languageName." / ".$regionName."</option>";				
						}
				}
								
				$buildSelect = $buildSelect."</select>";
				
				echo $buildSelect;
				$result->closeCursor();
				echo "<button type=\"submit\" class=\"btn btn-default btn-sm\" name=\"action\" value=\"insertLangue\" title=\"Cliquez ici pour rajouter une nouvelle langue. Les informations déjà insérées seront conservées.\"><span class=\"glyphicon glyphicon-plus\"></span></button>";
				
			?>
			</div>		
			<div class="submitButton">		
				<button type="submit" name="action" class="btn btn-default" value="cancel">Annuler</button>	
				<button type="submit" name="action" class="btn btn-default" value="insertTranslation">Rajouter traduction</button>
			</div>
		  </form>
		</div>
        </div>
    </body>
</html>
