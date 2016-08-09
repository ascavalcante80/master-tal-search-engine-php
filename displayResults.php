<?php

function insertHeader($arg){
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
	<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		    <!-- titre de l'onglet -->
			<title>Coogl∃</title>
		    <!-- Déclaration des éléments meta -->
		    <meta name=\"author\" content=\"Alexandre Cavalcante\" />
		    <meta name=\"description\" content=\"search about movie titles\"/>    
		    <meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\"/>
			<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />
			<link rel=\"stylesheet\" href=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\">
			<link rel=\"stylesheet\" href=\"http://bootstrap-fugue.azurewebsites.net/css/bootstrap-fugue-min.css\"/>
	  		<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js\"></script>
	  		<script src=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js\"></script>
		</head>
		<body> 
		
		<div id=\"headerResults\">
			<div id=\"headerResultsSub1\">		          
	  			<div id=\"dropdownResults\" class=\"dropdown\">		
					<img src=\"buttonMenu2.png\" type=\"button\" data-toggle=\"dropdown\">
					<ul class=\"dropdown-menu\">
						<li><a href=\"insertMovie.php\">Rajouter film</a></li>
						<li><a href=\"aboutUs.php\">Qui sommes-nous</a></li>
					</ul>
				</div>
				<form action=\"searchData.php\" method=\"post\">				
					<a href=\"index.php\"> <img  src=\"small_logo.png\"> </a>
						<input type=\"text\" class=\"searchField\" name=\"searchField\"/>					
						 <button type=\"button\" value=\"Recherche Coogle\" name=\"search\>
	  						<span class=\"glyphicon glyphicon-search\"></span> Rechercher
						</button>					
				</form>					
			</div>		
		</div>
		

	    ";
    
	}	


	function insertResult($search, $movieId, $originalTitle, $englishTitle, $director, $region, $year){
		
		// verifier quelle variable contient le motif pour afficher le resultat en gras
		if (strpos(strtolower($originalTitle), strtolower($search)) !== false) {
			echo "<div><a href=\"buildMoviePage.php?movieId=".$movieId."\"><h4 class=\"titleResult\">".$englishTitle."</h4></a>
				<span>Titre original: <i><b>".$originalTitle."</b></i> réalisé par ".$director. ", ".$year." - ".$region."<span></div><br>";
		}	elseif (strpos(strtolower($director), strtolower($search)) !== false) {
			echo "<div><a href=\"buildMoviePage.php?movieId=".$movieId."\"><h4 class=\"titleResult\">".$englishTitle."</h4></a>
				<span>Titre original: <i>".$originalTitle."</i> réalisé par <b>".$director. "</b>, ".$year." - ".$region."<span></div><br>";
		} else {
			echo "<div><a href=\"buildMoviePage.php?movieId=".$movieId."\"><h4 class=\"titleResult\">".$englishTitle."</h4></a>
					<span>Titre original: <i>".$originalTitle."</i> réalisé par ".$director. ", ".$year." - ".$region."<span></div><br>";
		}
	}

?>
