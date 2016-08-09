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
					<li><a href="insertMovie.php">Rajouter Pays/Région</a></li>
					<li><a href="aboutUs.php">Qui sommes-nous</a></li>
				</ul>
			</div>		
	   	</div>
	   		  
        <div id="insertRegion">
			<div class="container">
			  <h2>Rajouter Nouveau Pays / Région</h2>
			  <form role="form" action="saveRegion1.php" method="post">
			  
				<div class="form-group">
				  <label for="regionName">Nom pays / région:</label>
				  <input type="text" class="form-control" name="regionName" placeholder="Insérez le nom du pays ou de la région">
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
