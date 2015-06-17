<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
///////////////////////////////////////////////
// sponthus 16/12/2005
//
// export d'enregistrements : 
//	- liste d'envois des newsletter 
//	- liste des inscrits envoy�s par newsletter
///////////////////////////////////////////////

/*


*/




//=====================================================
// liste des inscrits envoy�s d'un envoi de newsletter
//=====================================================

function get_list_inscrits_envoi($id) {

	$sSql = "SELECT news_inscrit.* FROM news_inscrit, news_select ";
	$sSql.= "WHERE slc_newsletter=".$id." AND slc_inscrit=ins_id ";
	$sSql.= "ORDER BY ins_mail ASC";

	$aResult = dbGetObjectsFromRequete("news_inscrit", $sSql);

//print("<br>".$sSql);

	return ($aResult);
}


//=====================================================
// liste des envois des newsletter
//=====================================================

function get_list_envois() {

	$sSql = "SELECT newsletter.* FROM newsletter ";
	$sSql.= "ORDER BY news_id DESC";

	$aResult = dbGetObjectsFromRequete("newsletter", $sSql);

//print("<br>".$sSql);

	return ($aResult);
}


//=====================================================
// export des envois des newsletter
//=====================================================

function export_envoi_newsletter($sRep)
{
	// liste des envois des newsletter
	$aResult = get_list_envois();

	// fichier output
		
	// export des enregistrements par lot de 300
	// sinon les requetes ne s'executent pas ...

	// indice des fichiers
	if (sizeof($aResult) == 0) $j=0;
	else $j=1;
		
	$sFilename = $sRep."export_envoi_newsletter_".$j.".txt";

	if (!$handle = fopen($sFilename, 'w+')) {
	   echo "Impossible d'ouvrir le fichier ($filename)";
	   exit;
	}
		
	// Assurons nous que le fichier est accessible en �criture
	if (is_writable($sFilename)) {
		// ok tout va bien le fichier est accessible en �criture
	} else {
	   echo "Le fichier $sFilename n'est pas accessible en �criture.";
	}

	// requete d'insertion pour la nouvelle BDD
	for ($i=0; $i<sizeof($aResult); $i++)
	{
		$bChangeFile = false;
	
		if ($i%300 == 0 && $i != 0) {
	
			// fichier output
			
			// export des enregistrements par lot de 300
			// sinon les requetes ne s'executent pas ...

			// ferme l'ancien fichier
			if ($i != 0) {
				fclose($handle);
				//print("<br><div class='arbo'>Export r�ussi :: $sFilename</div>");
			}
	
			$j++;
			$sFilename = $sRep."export_envoi_newsletter_".$j.".txt";

			if (!$handle = fopen($sFilename, 'w+')) {
				   echo "Impossible d'ouvrir le fichier ($sFilename)";
				   exit;
			}
			
			// Assurons nous que le fichier est accessible en �criture
			if (is_writable($sFilename)) {
				// ok tout va bien le fichier est accessible en �criture
			} else {
			   echo "Le fichier $sFilename n'est pas accessible en �criture.";
			}
	
			$bChangeFile = true;
		}
	
		// envoi
		$oEnv = $aResult[$i];

		// newsletter		
		$oNews = new Newsletter($oEnv->getEnv_news_id());
	
		// liste de diffusion
		$oInt = new Interet($oNews->getNews_int_id());

		$sContent = "".$oEnv->getEnv_id().";";
		$sContent.= "".$oNews->getNews_titre().";";
		$sContent.= "".$oInt->getInt_libelle().";";
		$sContent.= "".$oEnv->getEnv_date().";";
		$sContent.= "".$oEnv->getEnv_nbmail().";";
		$sContent.= ""."\n";
	
	   // �criture dans le fichier
	
	   if (fwrite($handle, $sContent) === FALSE) {
		   echo "Impossible d'�crire dans le fichier ($sFilename)";
		   exit;
	   }
	
	}

	// fermeture des fichiers
	fclose($handle);
	//print("<br><div class='arbo'>Export r�ussi :: $sFilename</div>");

	// on renvoie le nombre de fichiers d'export cr��s
	return $j;
}


//=====================================================
// export des listes des inscrits envoy�s par newsletter
//=====================================================

function export_list_inscrits_envoi($sRep, $id)
{
	

	// liste
	$aResult = get_list_inscrits_envoi($id);
	// fichier output
	
	// export des enregistrements par lot de 300
	// sinon les requetes ne s'executent pas ...

	// indice des fichiers
	if (sizeof($aResult) == 0) $j=0;
	else $j=1;
		
	$sFilename = $sRep."export_envoi_newsletter_".$id.".csv";

	if (!$handle = fopen($sFilename, 'a+')) {
	   echo "Impossible d'ouvrir le fichier ($filename)";
	   exit;
	}
		
	// Assurons nous que le fichier est accessible en �criture
	if (is_writable($sFilename)) {
		// ok tout va bien le fichier est accessible en �criture
	} else {
	   echo "Le fichier $sFilename n'est pas accessible en �criture.";
	}
	$sContent ="";
	$sContent.= "Id;";
	$sContent.= "E-mail;";
	$sContent.= "Mail ouvert;";
	$sContent.= "Nom;";
	$sContent.= "Pr�nom;";
	$$sContent.= "Sexe;";
	$sContent.= "CP;";
	$sContent.= "Ville;";
	$sContent.= "Pays;";
	$sContent.= "Statut;";
	$sContent.= ""."\n";
	// requete d'insertion pour la nouvelle BDD
	for ($i=0; $i<sizeof($aResult); $i++)
	{
		
		// envoi
		$oIns = $aResult[$i];
		$sql = "select * from news_select ";
		$sql.= " WHERE slc_newsletter=".$id." AND slc_inscrit=".$oIns->get_id();

		$aNewselect = dbGetObjectsFromRequete("news_select", $sql);
		$oNewselect = $aNewselect[0];
	
		$sContent.= "".$oIns->get_id().";";
		$sContent.= "".$oIns->get_mail().";";
		//$sContent.= "".$oIns->get_recu().";";
		if ($oNewselect->get_recu() == 1) $recu = "oui";
		else if ($oNewselect->get_recu() == 0) $recu = "non";
		$sContent.=$recu.";";
		//$oTheme = new news_theme ($oIns->get_theme());
		//$sContent.= "".$oTheme->get_libelle().";";
		$sContent.= "".$oIns->get_nom().";";
		$sContent.= "".$oIns->get_prenom().";";
		$sContent.= "".$oIns->get_sexe().";";
		$sContent.= "".$oIns->get_codepostal().";";
		$sContent.= "".$oIns->get_ville().";";
		$oPays = new Pays ($oIns->get_pays());
		$sContent.= "".$oPays->get_libelle().";";
		if ($oIns->get_statut() == 1) $statut = "en attente";
		else if ($oIns->get_statut() == 4) $statut = "abonn�";
		else if ($oIns->get_statut() == 5) $statut = "desabonn�";
		$sContent.="".$statut.";";
		$sContent.= ""."\n";
	
	   // �criture dans le fichier
	
	   
	
	}
	if (fwrite($handle, $sContent) == FALSE) {
		   echo "Impossible d'�crire dans le fichier (".$sFilename.")";
		   exit;
	 }
	// fermeture des fichiers
	fclose($handle);
	//print("<br><div class='arbo'>Export r�ussi :: $sFilename</div>");
	//echo $sContent;
	// on renvoie le nombre de fichiers d'export cr��s
	return $j;
}


?>