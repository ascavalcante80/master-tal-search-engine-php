<?php


	function insertMovieInfo($movieId, $englishTitle, $originalTitle, $director, $region, $year, $photo){
	
		echo "<div id=\"movieInfo\">

	  			<img class=\"poster\" src=\"./pic/".$photo."\" alt=\"Affiche du film non disponible\" title=\"Affiche du film non disponible\" height=\"339px\" width=\"220px\">	  			
	  			<div class=\"details\">
	  				<table>
			  			<tr><td   style=\"text-align:center\" colspan=\"2\"><b> Fiche Technique </b></td></tr>
		  				<tr><td style=\"padding:2px\"><b> Titre Original: </b></td><td>  ".$originalTitle."</td></tr>
			  			<tr><td style=\"padding:2px\"><b> Réalisateur: </b></td><td> ".$director."</td></tr>
			  			<tr><td style=\"padding:2px\"><b> Sortie: </b></td><td> ".$year."</td></tr>
			  			<tr><td style=\"padding:2px\"><b> Pays/Région: </b></td><td> ".$region."</td><td><a href=\"displayEditMovie.php?idMovie=".$movieId."\"><span class=\"glyphicon glyphicon-pencil\"></td></tr>			  			
		  			</table>		  			
	  			</div>
	  		</div>";
	
	}
	
	function insertTranslation($idTranslations, $englishTitle, $langue, $region, $translateTitle, $littTransl){
		
		echo	"<tr>
					<td class=\"cellMovieInfo\">".$langue." / ".$region."</td>
					<td class=\"cellMovieInfo\">".$translateTitle."</td> 
					<td class=\"cellMovieInfo\">".$littTransl."</td>";
		$score = evaluteTranslation($littTransl, $englishTitle);			
					
		echo	"	<td class=\"cellMovieInfo\" style=\"font-size: 20px;\">".$score."</td>
					<td class=\"cellMovieInfo\"><a href=\"displayEditTranslation.php?idTrans=".$idTranslations."\"><span class=\"glyphicon glyphicon-pencil\"></span></a></td>
				</tr>";	
	}
	
	function evaluteTranslation($litteralEnglish, $englishTitle){
	
		// match parfait
		if($litteralEnglish == $englishTitle){
			
			return "♕";
		}
			
		$littTitle = explode(" ", cleanString(strtolower($litteralEnglish)));		
		$enTitle = explode(" ", cleanString(strtolower($englishTitle)));
		
		$totalLetters = strlen(cleanString($englishTitle));
		$letterValue = 0;
		// poid par lettre
		if($totalLetters > 0){		
			$letterValue = 100 / $totalLetters;
		}		
		
		$sizeLittTitle = sizeof($littTitle);
		$sizeEnTitle = sizeof($enTitle);
		
		$scores = array(0);
				
		// chercher les match incomplets
		if($sizeEnTitle > $sizeLittTitle){
			
			$index = 0;
			$score1 = 0;
			
			foreach($littTitle as $word){
				
				if($index < $sizeEnTitle){
					
					if($word == $enTitle[$index]){
						
						$score1 = $score1 + (strlen($word) * $letterValue);
					} 
				}
				$index++;
			}
			
			array_push($scores, $score1);
			
			// verfier l'ordre reseverse'
			$indexReverse = $sizeEnTitle - 1;
			$score2 = 0;
			foreach(array_reverse($littTitle) as $word){
				
				if($indexReverse > 0){
					if($word == $enTitle[$indexReverse]){
						
						$score2 = $score2 + (strlen($word) * $letterValue);
					}
				}
				$indexReverse--;
			}
			
			array_push($scores, $score2);
			array_push($scores, $score2 + $score1);
			
			// cherche substring dans le titre
			$littTitleSub = cleanString(strtolower($litteralEnglish));		
			$enTitleSub = cleanString(strtolower($englishTitle));
			
			$score3 = 0;
			if (strpos($enTitleSub, $littTitleSub) !== false) {
		    	$score3 = strlen($littTitleSub) * $letterValue;
			}
			array_push($scores, $score3);
			
			// retourner le score maximal
			$scoreFinal = max($scores);
					
		} else {
		
// *******************************************************************************************************************************
			// si le titre traduit est plus long que le titre original en anglais
			// on doit décompter les tokens en exces			
			
			$sizeLittTitle = sizeof($littTitle);
			$sizeEnTitle = sizeof($enTitle);
			$letterValueDecompte = $letterValue / 4;					
			
			// cherche substring dans le titre
			$littTitleSub = cleanString(strtolower($litteralEnglish));		
			$enTitleSub = cleanString(strtolower($englishTitle));			
			
			$score3 = 0;
			if (strpos($littTitleSub, $enTitleSub) !== false) {
				
				$decompte = (strlen($littTitleSub) - strlen($enTitleSub)) * $letterValueDecompte; 
		    	$score3 = (strlen($enTitleSub) * $letterValue) - $decompte;
		    	
			}
			
			array_push($scores, $score3);
															
			$index = 0;
			$score1 = 0;
			$decompte1 = 0;
			foreach($littTitle as $word){
				
				if($index < $sizeEnTitle){
					
					if($word == $enTitle[$index]){
						
						$score1 = $score1 + (strlen($word) * $letterValue);
					} 
				} else {
					$decompte1 = $decompte1 + (strlen($word) * $letterValueDecompte);
				
				}
				$index++;
			}

			array_push($scores, $score1 - $decompte1);
			
			// verfier l'ordre reseverse'
			$indexReverse = $sizeEnTitle - 1;
			$score2 = 0;
			$decompte2 = 0;
			foreach(array_reverse($littTitle) as $word){
				
				if($indexReverse > 0){
					if($word == $enTitle[$indexReverse]){
						
						$score2 = $score2 + (strlen($word) * $letterValue);
					} 
				} else {
					$decompte2 = $decompte2 + (strlen($word) * $letterValueDecompte);
				
				}$indexReverse--;
			}
			
			array_push($scores, $score2 - $decompte2);
			
			// retourner le score maximal
			$scoreFinal = max($scores);
			
		}	
		
		if($scoreFinal < 99 and $scoreFinal > 89){
			$symbol = "<span class=\"glyphicon glyphicon-star\"></span><span class=\"glyphicon glyphicon-star\"></span><span class=\"glyphicon glyphicon-star\"></span>";
		} elseif($scoreFinal < 90 and $scoreFinal > 65){
			$symbol = "</span><span class=\"glyphicon glyphicon-star\"></span><span class=\"glyphicon glyphicon-star\"></span>";
		} elseif($scoreFinal < 66 and $scoreFinal > 45){
			$symbol = "</span><span class=\"glyphicon glyphicon-star\"></span>";
		} elseif($scoreFinal < 46 and $scoreFinal > 15){
			$symbol = "☹";
		} elseif($scoreFinal < 16 and $scoreFinal > 0){
			$symbol = "☹☹";
		} else {
			$symbol = "☠";
		}
		
		return $symbol;

	}
	
	function cleanString($cleanTitle){
	
		$cleanTitle = str_replace(",", "", $cleanTitle);
		$cleanTitle = str_replace("'", "", $cleanTitle);
		$cleanTitle = str_replace(";", "", $cleanTitle);
		$cleanTitle = str_replace(":", "", $cleanTitle);
		$cleanTitle = str_replace("&", "", $cleanTitle);
		$cleanTitle = str_replace("!", "", $cleanTitle);
		$cleanTitle = str_replace(".", "", $cleanTitle);
		$cleanTitle = str_replace("?", "", $cleanTitle);
		$cleanTitle = str_replace("-", "", $cleanTitle);
		$cleanTitle = str_replace("+", "", $cleanTitle);
		
		return $cleanTitle;
	
	}

?>
