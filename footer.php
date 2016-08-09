		</form>
			<?php
					if (isset($_GET['buildPage']))
					{
						echo "goooooo";
						include 'buildMoviePage.php';
						buildPage($_GET['buildPage']);	
					}
			?>	
	
	 	</div>
	    <div id="footer">
	    			<span class="alphaIndex" ><a href="searchAlphaIndex.php?letter=a" >A</a><b> . </b><a href="searchAlphaIndex.php?letter=b">B</a><b> . </b><a href="searchAlphaIndex.php?letter=c">C</a><b> . </b><a href="searchAlphaIndex.php?letter=d">D</a><b> . </b><a href="searchAlphaIndex.php?letter=e">E</a><b> . </b><a href="searchAlphaIndex.php?letter=f">F</a><b> . </b><a href="searchAlphaIndex.php?letter=g">G</a><b> . </b><a href="searchAlphaIndex.php?letter=h">H</a><b> . </b><a href="searchAlphaIndex.php?letter=i">I</a><b> . </b><a href="searchAlphaIndex.php?letter=j">J</a><b> . </b><a href="searchAlphaIndex.php?letter=k">K</a><b> . </b><a href="searchAlphaIndex.php?letter=l">L</a><b> . </b><a href="searchAlphaIndex.php?letter=m">M</a><b> . </b><a href="searchAlphaIndex.php?letter=n">N</a><b> . </b><a href="searchAlphaIndex.php?letter=o">O</a><b> . </b><a href="searchAlphaIndex.php?letter=p">P</a><b> . </b><a href="searchAlphaIndex.php?letter=q">Q</a><b> . </b><a href="searchAlphaIndex.php?letter=r">R</a><b> . </b><a href="searchAlphaIndex.php?letter=s">S</a><b> . </b><a href="searchAlphaIndex.php?letter=t">T</a><b> . </b><a href="searchAlphaIndex.php?letter=u">U</a><b> . </b><a href="searchAlphaIndex.php?letter=v">V</a><b> . </b><a href="searchAlphaIndex.php?letter=w">W</a><b> . </b><a href="searchAlphaIndex.php?letter=x">X</a><b> . </b><a href="searchAlphaIndex.php?letter=y">Y</a><b> . </b><a href="searchAlphaIndex.php?letter=z">Z</a><b> . </b><a href="searchAlphaIndex.php?letter=num">0-9</a><b> . </b><a href="searchAlphaIndex.php?letter=others">本-ש</a>
			</span>		
		</div>
		</body>
	</html>
