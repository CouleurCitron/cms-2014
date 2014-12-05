<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
/*
fichier priv� : non accessible par le menu.
sert � abonner des inscrit � la newsletter $outTheme si leur date d'ajout est post�rieure � $inDate

*/

$inDate = '2012-10-08';
$outTheme=2;

if ($outTheme){   

	
	// newsletter inscrit	
	$sql = " SELECT * FROM `news_inscrit` WHERE `ins_dt_crea` > '".$inDate."'; ";	
	 
 	$aInscrit = dbGetObjectsFromRequete("news_inscrit", $sql);	

	foreach($aInscrit as $k => $oInscrit){

		$sqlValide = "select count(*) from news_assoinscrittheme where xit_id ='".$oInscrit->get_id()."' and xit_news_theme=".$outTheme.";";

		$eCountValide = dbGetUniqueValueFromRequete($sqlValide);

		if($eCountValide==0){ // on abonne
			$oX = new news_assoinscrittheme();
			$oX->set_news_inscrit($oInscrit->get_id());
			$oX->set_news_theme($outTheme);
			$oX->set_statut(DEF_ID_STATUT_LIGNE);
			dbSauve($oX);
		}
		else{
			$sqlValide = "select * from news_assoinscrittheme where xit_id ='".$oInscrit->get_id()."' and xit_news_theme=".$outTheme.";";
			$aX = dbGetObjectsFromRequete("news_assoinscrittheme", $sql);
			if ($aX){
				$oX = $aX[0];
				if ($oX->get_statut() == DEF_ID_STATUT_LIGNE){// deja abonn�
					/// ras
				}
				elseif ($oX->get_statut() == DEF_ID_STATUT_ARCHI){ /// archiv� == desabonne, on ne touche � rien
					/// ras
				}
				elseif ($oX->get_statut() == DEF_ID_STATUT_ATTEN){ // en attente on abonne
					$oX->set_statut(DEF_ID_STATUT_LIGNE);
					dbSauve($oX);
				}
				else{ // ne devrait JAMAIS se produire 
					$oX->set_statut(DEF_ID_STATUT_LIGNE);
					dbSauve($oX);
				}
			}	
		}

	}
}
else{
	echo "La newsletter n'a pas �t� trouv�";
}
?>