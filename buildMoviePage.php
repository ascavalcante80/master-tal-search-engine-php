
<?php
	require_once("connexion.php");
	require_once("movieInfo.php");
	require_once("displayResults.php");
	
	insertHeader('');
	if (session_status() == PHP_SESSION_NONE) {
	   session_start();
	}
	
	// ---------------------------------------------- Recuper l'id du film 'a traiter -----------------------------------------------------------
	
	$idmovie ='';
	
	// recuperer l'id du film lorsque le script est appele' apartir de displayResults.php
	if(isset($_GET['movieId'])){
		$idmovie = $_GET['movieId'];
	}
	
	
	// recuperer l'id du film lorsque le script est appele' apartir de saveTranslation.php
	if(isset($_SESSION['movieId'])){
		$idmovie = $_SESSION['movieId'];
		session_destroy();
	}
	
	// ---------------------------------------------- Obtenir informations du film -----------------------------------------------------------

	
	// Préparation de la requête
	$teste = $sql->prepare("SET NAMES 'utf8'");
	$teste ->execute();
	$result = $sql->prepare("SELECT * FROM movie inner join coogle.region on movie.region_idregion=region.idregion where idmovie=".$idmovie) ;
	$result->execute();
	
	$row = $result->fetch(PDO::FETCH_OBJ);
	
	$movieId = $row->idmovie;
	$englishTitle = $row->enTitle;
	$originalTitle = $row->originalTitle;
	$director = $row->director;
	$region = $row->regionName;
	$year = $row->releaseDate;
	$photo = $row->photoAddress;
	
		
	
	// ----------------------------------------------- Afficher titre en anglais avant le tableau -------------------------------------------
	
	echo "<div id=\"displayMovie\">
	  		<div id=\"translations\">
		  		<div id=\"title\">

		  			<h1 class=\"englishTitle\">".$englishTitle."</h1>		  			
		  		</div>  
		  		
				<table style=\"width:90%\" id=\"t01\">
				<tr>
					<td class=\"titleCell\"><b>Langue</b></td>
					<td class=\"titleCell\"><b>Titre Traduit</b></td> 
					<td class=\"titleCell\"><b>Traduction Littérale en Anglais</b></td>
					<td class=\"titleCell\"><b>Évaluation</b></td>
					<td class=\"titleCell\"></td>
				</tr>";
	
	// ces variables sont utilisees si l'utilisateur utilise la fonctionalite pour rajouter traduction	
	
	$_SESSION['previousPageTrans'] = $movieId;
	$_SESSION['newmovieId'] = $movieId;
					
					
	// ---------------------------------------------- Obtenir informations des traductions----------------------------------------------------	

	$teste = $sql->prepare("SET NAMES 'utf8'");
	$teste ->execute();
	$result = $sql->prepare("select translations.idtranslations, translations.titleTranslation, translations.literalENTranslation, languages.languageName, region.regionName from coogle.translations inner join coogle.languages on languages.idlanguages=coogle.translations.languages_idlanguages inner join coogle.region on coogle.languages.region_idregion = coogle.region.idregion where coogle.translations.movie_idmovie =".$idmovie) ;
	
	$result->execute();	
	$rows = $result->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($rows as $row) {		
	
		$idTranslations = $row['idtranslations'];
		$titleTranslation = $row['titleTranslation'];
		$litteralEn = $row['literalENTranslation'];
		$languageName = $row['languageName'];
		$regionName = $row['regionName'];			
		
		// insere code hmtl pour chaque traduction
		insertTranslation($idTranslations, $englishTitle, $languageName, $regionName, $titleTranslation, $litteralEn);
	}
	

	echo 	"</table>
				<a href=\"insertTranslation.php\">Add translation <span class=\"glyphicon glyphicon-plus\"></span></a>					
	  		</div>";

// ------------------------------------------------- construire container avec les infos du film -------------------------------------------------

	// fonction du fichier displayResults.php
	insertMovieInfo($movieId, $englishTitle, $originalTitle, $director, $region, $year, $photo);
	

		
?>
</div>

        <div id="footer">
			<span class="alphaIndex" ><a href="searchAlphaIndex.php?letter=a" >A</a><b> . </b><a href="searchAlphaIndex.php?letter=b">B</a><b> . </b><a href="searchAlphaIndex.php?letter=c">C</a><b> . </b><a href="searchAlphaIndex.php?letter=d">D</a><b> . </b><a href="searchAlphaIndex.php?letter=e">E</a><b> . </b><a href="searchAlphaIndex.php?letter=f">F</a><b> . </b><a href="searchAlphaIndex.php?letter=g">G</a><b> . </b><a href="searchAlphaIndex.php?letter=h">H</a><b> . </b><a href="searchAlphaIndex.php?letter=i">I</a><b> . </b><a href="searchAlphaIndex.php?letter=j">J</a><b> . </b><a href="searchAlphaIndex.php?letter=k">K</a><b> . </b><a href="searchAlphaIndex.php?letter=l">L</a><b> . </b><a href="searchAlphaIndex.php?letter=m">M</a><b> . </b><a href="searchAlphaIndex.php?letter=n">N</a><b> . </b><a href="searchAlphaIndex.php?letter=o">O</a><b> . </b><a href="searchAlphaIndex.php?letter=p">P</a><b> . </b><a href="searchAlphaIndex.php?letter=q">Q</a><b> . </b><a href="searchAlphaIndex.php?letter=r">R</a><b> . </b><a href="searchAlphaIndex.php?letter=s">S</a><b> . </b><a href="searchAlphaIndex.php?letter=t">T</a><b> . </b><a href="searchAlphaIndex.php?letter=u">U</a><b> . </b><a href="searchAlphaIndex.php?letter=v">V</a><b> . </b><a href="searchAlphaIndex.php?letter=w">W</a><b> . </b><a href="searchAlphaIndex.php?letter=x">X</a><b> . </b><a href="searchAlphaIndex.php?letter=y">Y</a><b> . </b><a href="searchAlphaIndex.php?letter=z">Z</a><b> . </b><a href="searchAlphaIndex.php?letter=num">0-9</a><b> . </b><a href="searchAlphaIndex.php?letter=others">本-ש</a>
			</span>
	    </div>
    </body>
</html>
