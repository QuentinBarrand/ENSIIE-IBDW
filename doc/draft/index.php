<?php
$bdd = new PDO('mysql:host=localhost;dbname=ensiie-ibdw-2', 'root', '');
$connected = 1;
$idChoriste = 1;
/*
2.1.1 Procédure d’affichage : statistique des présences

Un utilisateur authentifié doit pouvoir afficher la liste des différents choristes, avec pour chaque cho-
riste : ses nom et prénom, le nombre de répétitions auxquelles il a assisté dans l’année, et le nombre de
répétitions qu’il a manquées, ainsi que le taux de présence (nombre de répétitions où présent / nombre
de répétitions où absent). 
Les choristes sont classés par voix. Chaque voix (avec son libellé) est clairement indiquée au début de 
la liste. À la fin de chaque voix, la présence moyenne des choristes de cette voix est indiquée
*/
try
{	
	$choristes = $bdd->query('SELECT nom, prenom, typeVoix, sum(participe.confirmation) as participations
							FROM Choriste
							NATURAL JOIN participe
							NATURAL JOIN Voix
							GROUP BY idChoriste, nom, prenom, typeVoix
							ORDER BY typeVoix;');
							
	$Totalrepetitions = $bdd->query('SELECT count(idEvenement) as TotalRepetitions
							FROM evenement
							WHERE idType=2;'); // idType = 2 : Répétition
							
	$nbRepetitions = $Totalrepetitions->fetch();
	$Totalrepetitions->closeCursor();
	unset($Totalrepetitions);
	$sum = 0; // somme des taux de présence des choristes d'une voix
	$count = 1; // nombre de choristes d'une voix
	$tmpVoix = ''; // variable utilisée pour contrôler le changement de type de voix
				
	while ($choriste = $choristes->fetch())
	{
	?>
		<?php 
		if($tmpVoix!=$choriste['typeVoix']){
			if(!($sum==0 && $count==1)){
				?>
				Présence moyenne des choristes : <?php echo round($sum/$count,1); ?>%<br /><br />
				<?php
			}
			$sum = 0;
			$count = 0;
			$tmpVoix=$choriste['typeVoix'];
			?>
			<h3><?php echo $tmpVoix; ?></h3>
			<?php
		}
		?>
		<p>
		Nom : <?php echo $choriste['nom']; ?> <br /> 
		Prénom : <?php echo $choriste['prenom']; ?> <br />
		Nombre de présences : <?php echo $choriste['participations']; ?> <br />
		Nombre d'absences : <?php echo $nbRepetitions[0]-$choriste['participations']; ?> <br />
		Taux de présence : <?php echo round((($choriste['participations']/$nbRepetitions[0])*100),1).'%'; ?> <br /><br />
	   </p>
		<?php
		$count++;
		$sum += ($choriste['participations']/$nbRepetitions[0])*100;
	}
	?>
	Présence moyenne des choristes : <?php echo round($sum/$count,1); ?>%<br /><br />
	<?php
	$choristes->closeCursor();
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>



<hr size="2">
<?php
/*
2.2.1 Procédure d’affichage : affichage des concerts passés et à venir

Les concerts doivent être listés par ordre chronologique, en séparant les concerts passés et à venir.
Les informations suivantes doivent être affichées : date et heure du concert, lieu et carte éventuelle,
carte.
Si l’utilisateur est authentifié, un voyant doit également s’afficher pour les concerts à venir, vert s’il y a
suffisamment de choristes pour le concert (au moins 2 par voix), et rouge sinon.
*/
try
{
	// On recupere d'abord l'id du type 'concert'
	$typeConcert = $bdd->query("SELECT idType 
							FROM typeevt 
							WHERE typeEvt='Concert';");
	$idConcert = $typeConcert->fetchColumn();
	$typeConcert->closeCursor();
	unset($typeConcert);

	// On recupere tous les concerts ordonnes par date
	$concerts = $bdd->query('SELECT idEvenement, heureDate, lieu, nom 
							FROM evenement
							WHERE idType='.$idConcert.' 
							ORDER BY heureDate DESC;');

	// On recupere la date actuelle pour la comparer avec la date du concert 
	$dateNow = date('Y-m-d H:i:s');
	
	($connected) ? $voyant = true : $voyant = false;
	if($connected)
	{
		// requete qui compte le nombre de voix differentes
		$nbVoix = $bdd->query('SELECT count(idVoix) FROM voix;');
		$countVoix = $nbVoix->fetch();
		$nbVoix->closeCursor();
		unset($nbVoix);
	}
	
	// On affiche les concerts
	echo '<ul>';
	while ($concert = $concerts->fetch())
	{
		if($voyant==true && ($dateNow>$concert['heureDate']))
		{
			$voyant = false;
			echo '<br />Concerts passés : <br /><br />'; // separation concert a venir
		}
		echo '<li>'.$concert['nom'].' le '.date(/*'d/m/Y  h\hi', */$concert['heureDate']).' à '.$concert['lieu'];	
		if($voyant)
		{
			// Si c'est un concert à venir et qu'un utilisateur est connecte, 
			// on affiche un voyent qui indique s'il y a suffisement de choristes
			
			// requete qui recupere le nombre de choristes par voix quand celui-ci > 1 pour un concert donne
			$checkVoix = $bdd->query('SELECT count(participe.idChoriste) as nbChoristes 
									FROM participe 
									NATURAL JOIN choriste 
									WHERE idEvenement = '.$concert['idEvenement'].' AND confirmation = 1 
									GROUP BY idVoix 
									HAVING nbChoristes > 1;');
			
			// on verifie que countVoix == nb lignes requete ci-dessus
			if($countVoix[0]==$checkVoix->rowCount())
			{
				echo ' (<i style="color:green;">il y a suffisamment de choristes pour le concert</i>)';
			}
			else echo ' (<i style="color:red;">il n\'y a pas suffisamment de choristes pour le concert</i>)';
			$checkVoix->closeCursor();
		}
		echo '</li>';
	}
	echo '</ul>';
	unset($voyant);
	unset($concert);
	$concerts->closeCursor();
	unset($concerts);
	unset($countVoix);
	unset($checkVoix);
	unset($dateNow);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>



<hr size="2">
<?php
/*
2.3.1 Procédure d’affichage : affichage des choristes

Le site web doit afficher la liste des choristes triés par voix, ainsi que leurs responsabilités éventuelles.
Si l’utilisateur est authentifié, s’affichent aussi le taux de présence aux répétitions du choriste, ainsi que ses
coordonnées.
*/
try
{	
	$choristes = $bdd->query('SELECT nom, prenom, typeVoix, ville, telephone, titre as responsabilite, SUM(participe.confirmation) as participations
						FROM Choriste
						LEFT JOIN participe ON Choriste.idChoriste = participe.idChoriste
						NATURAL JOIN Voix 
						NATURAL JOIN Utilisateur 
						LEFT JOIN Endosse ON Utilisateur.login = Endosse.login
						LEFT JOIN Responsabilite ON Endosse.id = Responsabilite.id 
						GROUP BY Choriste.idChoriste, nom, prenom, typeVoix, ville, telephone, responsabilite
						ORDER BY typeVoix;');
							
	$Totalrepetitions = $bdd->query('SELECT count(idEvenement) as TotalRepetitions
							FROM evenement
							WHERE idType=2;'); // idType = 2 : Répétition
							
	$nbRepetitions = $Totalrepetitions->fetch();
	$Totalrepetitions->closeCursor();
	unset($Totalrepetitions);
	$tmpVoix = ''; // variable utilisée pour contrôler le changement de type de voix
				
	while ($choriste = $choristes->fetch())
	{
	?>
		<?php 
		if($tmpVoix!=$choriste['typeVoix']){
			$tmpVoix=$choriste['typeVoix'];
			?>
			<h3><?php echo $tmpVoix; ?></h3>
			<?php
		}
		?>
		<p>
		Nom : <?php echo $choriste['nom']; ?> <br /> 
		Prénom : <?php echo $choriste['prenom']; ?> <br />
		<?php if($choriste['responsabilite']!='') echo 'Responsabilité : '.$choriste['responsabilite'].'<br />'; ?> 
		<?php
		if($connected){
			?>
			Taux de présence : <?php echo round((($choriste['participations']/$nbRepetitions[0])*100)).'%'; ?> <br />
			Ville : <?php echo $choriste['ville']; ?> <br />
			Téléphone : <?php echo $choriste['telephone']; ?> <br /><br />
			<?php
		}
		?>
	   </p>
		<?php
	}
	$choristes->closeCursor();
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>



<hr size="2">
<?php
/*
2.4.1 Procédure d’affichage : affichage du programme

L’ensemble des œuvres étudiées dans l’année doit pouvoir être affiché. Cet affichage doit pouvoir se
faire par style, et la durée du programme par style doit pouvoir être calculée. Pour cela, le chef de
chœur aura défini un événement particulier, la saison (“Saison 2014-2015” par exemple) à laquelle il
aura associé un ensemble d’œuvres.
Si l’utilisateur est authentifié, un voyant Rouge, Jaune ou Vert s’affiche
à côté de chaque œuvre pour indiquer si l’œuvre n’a pas encore été étudiée, est en cours d’apprentissage, ou peut
être chantée en concert.
*/
try
{	
	// On recupere d'abord l'id du type 'saison'
	$typeSaison = $bdd->query("SELECT idType 
							FROM typeevt 
							WHERE typeEvt='Saison';");
	$idSaison = $typeSaison->fetchColumn();
	$typeSaison->closeCursor();
	unset($typeSaison);

	// On recupere ensuite l'id de l'evenement correspondant a la saison actuelle
	$saison = $bdd->query('SELECT idEvenement
					FROM Evenement
					WHERE idType = '.$idSaison.' 
					AND YEAR(heureDate) = YEAR(now())');
	$saisonActuelle = $saison->fetchColumn();
	$saison->closeCursor();
	unset($saison);

	// Puis on recupere toutes les oeuvres de la saison 
	$oeuvres = $bdd->query('SELECT Oeuvre.*, nom as nomSaison
					FROM Oeuvre
					NATURAL JOIN est_au_programme
					NATURAL JOIN Evenement
					NATURAL JOIN TypeEvt
					WHERE idType = '.$idSaison.' AND idEvenement = '.$saisonActuelle.';');
	
	$i = 0;
	while ($oeuvre = $oeuvres->fetch())
	{
	?>
		<?php 
		if($i<1){
			?>
			<h3><?php echo $oeuvre['nomSaison']; ?></h3>
			<ul>
			<?php
			$i++;
		}
		?>
		<li>Oeuvre n°<?php echo $i; ?> : "<?php echo $oeuvre['titre']; ?>" 
		de <?php echo $oeuvre['auteur']; ?> (durée - <?php echo $oeuvre['duree']; ?>s)
		(sytle = <?php echo $oeuvre['style']; ?>)</li>
		<?php
		$i++;
	}
	echo "</ul>";
	$oeuvres->closeCursor();
	
	// On recupere les informations des oeuvres de la saison par style
	$oeuvres = $bdd->query('SELECT Oeuvre.*, nom, style 
					FROM Oeuvre
					NATURAL JOIN est_au_programme
					NATURAL JOIN Evenement
					NATURAL JOIN TypeEvt
					WHERE idType = '.$idSaison.' AND idEvenement = '.$saisonActuelle.'
					GROUP BY style, idOeuvre, titre, auteur, partition1, duree;');
					
	if($connected)
	{
		// Si l'utilisateur est connecte, on affiche sa progression
		$count = $bdd->query('SELECT idOeuvre, Count( est_au_programme.idEvenement ) AS nbEvenements
					FROM est_au_programme
					NATURAL JOIN evenement
					NATURAL JOIN participe
					WHERE idType = 2 AND idChoriste = '.$idChoriste.' AND confirmation = 1 
					GROUP BY idOeuvre');
					
		$nbEvenements = array();
		while ($oeuvreCount = $count->fetch())
		{
				$nbEvenements[$oeuvreCount['idOeuvre']] = $oeuvreCount['nbEvenements'];
		}
		$count->closeCursor();
		unset($oeuvreCount);
		unset($count);
	}				
	
	// On recupere la duree par style
	$styles = $bdd->query('SELECT style, SUM(duree) AS dureeStyle
					FROM Oeuvre
					NATURAL JOIN est_au_programme
					NATURAL JOIN Evenement
					WHERE idType = '.$idSaison.' AND idEvenement = '.$saisonActuelle.'
					GROUP BY style, nom');
					
	$lesStyles = array();
	while ($style = $styles->fetch())
	{
			$lesStyles[$style['style']] = $style['dureeStyle'];
	}
	$styles->closeCursor();
	unset($sytle);
	unset($styles);
	
	$i = 0;
	$tmpStyle = ''; // variable utilisée pour contrôler le changement de style d'oeuvre
	while ($oeuvre = $oeuvres->fetch())
	{
		if($i<1){
			?>
			<h2><?php echo $oeuvre['nom']; ?></h2>
			<?php
			$i++;
		}
		if($tmpStyle!=$oeuvre['style']){
			$tmpStyle=$oeuvre['style'];
			if($i>1) echo "</ul>";
			?>
			<h3><?php echo $tmpStyle; ?> (durée : <?php echo $lesStyles[$tmpStyle]; ?>s)</h3>
			<ul>
			<?php
		}
		?>
		<li>
		Oeuvre n°<?php echo $i; ?> : "<?php echo $oeuvre['titre']; ?>" 
		de <?php echo $oeuvre['auteur']; ?> 
		<?php
		if($connected)
		{
			// On affiche le voyant de progression
			if(isset($nbEvenements[$oeuvre['idOeuvre']]))
			{
				if($nbEvenements[$oeuvre['idOeuvre']]==0)
				echo '(<i style="color:red;">l\'œuvre n\'a pas encore été étudiée</i>)';
				
				else if($nbEvenements[$oeuvre['idOeuvre']]<4)
				echo '(<i style="color:#BDC645;">l\'œuvre est en cours d’apprentissage</i>)';
				
				else 	echo '(<i style="color:green;">l\'œuvre peut être chantée en concert</i>)';
			}
			else	echo '(<i style="color:red;">l\'œuvre n\'a pas encore été étudiée</i>)';
		}
		?>
		</li>
		<?php
		$i++;
	}
	echo "</ul>";
	$oeuvres->closeCursor();
	unset($oeuvre);
	unset($oeuvres);
	if(isset($nbEvenements)) unset($nbEvenements);
	unset($idSaison);
	unset($saisonActuelle);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
?>


<hr size="2">
<?php
/*
FUSION DES QUESTIONS : 2.1.1 et 2.3.1

-> utilisateur non connecte, on affiche : 
	- nom
	- prenom
	- responsabilite 
	-> ordonne par type de voix	
	-> avec la presence moyenne des choristes par voix 
	  (on peut le mettre que si l'utilisateur est connecte)
	 
-> utilisateur connecte, on affiche : 
	- les informations ci-dessus, plus :
		- ville
		- telephone
		- nombre de présences aux répétitions
		- nombre d'absences aux répétitions
		- taux de présence du choriste
*/
try
{	
	$choristes = $bdd->query('SELECT nom, prenom, typeVoix, ville, telephone, titre as responsabilite, SUM(participe.confirmation) as participations
						FROM Choriste
						LEFT JOIN participe ON Choriste.idChoriste = participe.idChoriste
						NATURAL JOIN Voix 
						NATURAL JOIN Utilisateur 
						LEFT JOIN Endosse ON Utilisateur.login = Endosse.login
						LEFT JOIN Responsabilite ON Endosse.id = Responsabilite.id 
						GROUP BY Choriste.idChoriste, nom, prenom, typeVoix, ville, telephone, responsabilite
						ORDER BY typeVoix;');
							
	$Totalrepetitions = $bdd->query('SELECT count(idEvenement) as TotalRepetitions
							FROM evenement
							WHERE idType=2;'); // idType = 2 : Répétition
							
	$nbRepetitions = $Totalrepetitions->fetch();
	$Totalrepetitions->closeCursor();
	unset($Totalrepetitions);
	$sum = 0; // somme des taux de présence des choristes d'une voix
	$count = 1; // nombre de choristes d'une voix
	$tmpVoix = ''; // variable utilisée pour contrôler le changement de type de voix
				
	while ($choriste = $choristes->fetch())
	{
	?>
		<?php 
		if($tmpVoix!=$choriste['typeVoix']){
			if(!($sum==0 && $count==1)){
				?>
				<br />
				Présence moyenne des choristes : <?php echo round($sum/$count,1); ?>%<br /><br />
				<?php
			}
			$sum = 0;
			$count = 0;
			$tmpVoix=$choriste['typeVoix'];
			?>
			<h3><?php echo $tmpVoix; ?></h3>
			<?php
		}
		?>
		<p>
		Nom : <?php echo $choriste['nom']; ?> <br /> 
		Prénom : <?php echo $choriste['prenom']; ?> <br />
		<?php if($choriste['responsabilite']!='') echo 'Responsabilité : '.$choriste['responsabilite'].'<br />'; ?> 
		<?php
		if($connected){
			?>
			Ville : <?php echo $choriste['ville']; ?> <br />
			Téléphone : <?php echo $choriste['telephone']; ?> <br />
			Nombre de présences : <?php echo $choriste['participations']; ?> <br />
			Nombre d'absences : <?php echo $nbRepetitions[0]-$choriste['participations']; ?> <br />
			Taux de présence : <?php echo round((($choriste['participations']/$nbRepetitions[0])*100)).'%'; ?> <br />
			<?php
		}
		$count++;
		$sum += ($choriste['participations']/$nbRepetitions[0])*100;
	}
	?>
	<br />
	Présence moyenne des choristes : <?php echo round($sum/$count,1); ?>%<br /><br />
	<?php
	$choristes->closeCursor();
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>




