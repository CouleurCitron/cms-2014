<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
// inclus le bon fichier de donn�es suivant l'ID pass� en param�tre
// ID est celui de la brique Graphique cr��e

/* new archi
"/modules/graphiques/xmldata/

"/custom/graphiques/".$_SESSION['rep_travail']."/
*/

if (!isset($_SESSION['rep_travail'])){
	$oSite = detectSite();
	$idSite = $oSite->get_id();
	sitePropsToSession($oSite);
}

//readfile($_SERVER['DOCUMENT_ROOT']."/custom/graphiques/".$_SESSION['rep_travail']."/graphic_preview_".$_GET['id'].".php");

if (is_file($_SERVER['DOCUMENT_ROOT'].'/tmp/graphic_preview_'.$_GET['id'].'.php')){
	readfile($_SERVER['DOCUMENT_ROOT'].'/tmp/graphic_preview_'.$_GET['id'].'.php');
}
if (is_file($_SERVER['DOCUMENT_ROOT'].'/custom/graphiques/'.$_SESSION['rep_travail'].'/graphic_preview_'.$_GET['id'].'.php')){
	readfile($_SERVER['DOCUMENT_ROOT'].'/custom/graphiques/'.$_SESSION['rep_travail'].'/graphic_preview_'.$_GET['id'].'.php');
}
else{ // patch de recherche de fichers dans les autres minisites (� cause du bug des sessions qui d�geulent
	$aSite = dbGetObjectsFromRequete("cms_site", "select * from cms_site ");
	if ($aSite){
		foreach($aSite as $sK => $oSite){
			if (is_file($_SERVER['DOCUMENT_ROOT'].'/custom/graphiques/'.$oSite->get_rep().'/graphic_preview_'.$_GET['id'].'.php')){
				readfile($_SERVER['DOCUMENT_ROOT'].'/custom/graphiques/'.$oSite->get_rep().'/graphic_preview_'.$_GET['id'].'.php');
				break;
			}		
		}	
	}
}
?>