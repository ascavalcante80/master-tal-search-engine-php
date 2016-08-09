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
		<div id="header">		
		<!-- 	Menu dropdown -->		          
  			<div class="dropdown">		
				<img src="buttonMenu.png" type="button" data-toggle="dropdown">
				<ul class="dropdown-menu">
					<li><a href="insertMovie.php">Rajouter Film</a></li>
					<li><a href="#">Qui sommes-nous</a></li>
				</ul>
			</div>		
	   	</div>
	   	<?php
	   		session_start();
	   		require_once('connexion.php');
	   		$_SESSION['idTrans'] = $_GET['idTrans'];
	   		$teste = $sql->prepare("SET NAMES 'utf8'");
			$teste ->execute();
			
			$result = $sql->prepare("SELECT * FROM coogle.translations where coogle.translations.idtranslations='".$_GET['idTrans']."'") ;
			$result->execute();
	
			$row = $result->fetch(PDO::FETCH_OBJ);
	
			$titleTranslation = $row->titleTranslation;
			$literalENTranslation = $row->literalENTranslation;
			$_SESSION['idmovie'] = $row->movie_idmovie;
				  
		   	echo "<div id=\"insertMovie\">
			<div class=\"container\">
			  <h2 style = \"text-align:center\">Éditer Traduction</h2>
			  <form role=\"form\" action=\"editTranslation.php\" method=\"post\">
			  
				<div class=\"form-group\">
				  <label for=\"originalTitle\">Tradution du titre:</label>
				  <input type=\"text\" class=\"form-control\" name=\"titleTranslated\" value=\"".$titleTranslation."\">
				</div>
			
				<div class=\"form-group\">
				  <label for=\"englishTitle\">Traduction littérale en anglais:</label>
				  <input type=\"text\" class=\"form-control\" name=\"literalEnglish\" value=\"".$literalENTranslation."\">
				</div>";
			
	   	?>
			</div>		
			<div class="submitButton">		
				<button type="submit" name="action" class="btn btn-default" value="cancel">Annuler</button>	
				<button type="submit" name="action" class="btn btn-default" value="editTranslation">Enregistrer</button>
			</div>
		  </form>
		</div>
        </div>
    </body>
</html>
