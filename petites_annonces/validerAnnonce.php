<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
/*
	$Id: validerAnnonce.php,v 1.1 2013-09-30 09:42:17 raphael Exp $
	$Author: raphael $

	$Log: validerAnnonce.php,v $
	Revision 1.1  2013-09-30 09:42:17  raphael
	*** empty log message ***

	Revision 1.6  2013-03-01 10:28:18  pierre
	*** empty log message ***

	Revision 1.5  2012-07-31 14:24:50  pierre
	*** empty log message ***

	Revision 1.4  2009-02-16 16:24:18  pierre
	*** empty log message ***

	Revision 1.3  2009-02-16 15:33:37  pierre
	*** empty log message ***

	Revision 1.2  2009-02-16 15:28:05  pierre
	*** empty log message ***

	Revision 1.1  2009-02-16 14:56:09  pierre
	*** empty log message ***

	Revision 1.2  2008/03/04 14:54:19  pierre
	*** empty log message ***
	
	Revision 1.1  2006/04/12 07:25:22  sylvie
	*** empty log message ***
	
	Revision 1.2  2004/06/04 12:35:30  ddinside
	fin petites annonces
	
	Revision 1.1  2004/06/01 14:25:19  ddinside
	ajout petites annonce dont gardes finies
	newslettrer
	
	Revision 1.1  2004/05/18 13:47:12  ddinside
	creation module petites annonces
	
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/PetitesAnnonces/include_pa.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/mail_lib.php');

activateMenu('gestionPA');  //permet de d�rouler le menu contextuellement

if (!( (strlen($_GET['id'])>0) && ($_GET['id']>0) )) {
	die("Appel incorrect � la fonctionnalit�.");
}

$status = '&nbsp;';

$annonce = new Annonce($_GET['id']);
$oCategorie = new Categorie($annonce->categorie);


if(!strlen($_GET['action'])>0) $_GET['action'] = 'valider';

if($_GET['action']=='valider') {
	$annonce->setValid(1);
	if($annonce->validate()) {
		$annonce->notify('validate');
		$status = "Validation enregistr�e.";
	}
} elseif($_GET['action']=='invalider') {
	$annonce->valide = 0;
	if($annonce->update()) $status = "Annonce invalid�.";
} elseif($_GET['action']=='supprimer') {
	if($annonce->delete()) $status = "Annonce supprim�.";
}

if($_GET['action']!='supprimer') {

?>
<div align="center"><b><?php echo $status; ?></b></div>
<br />
<br />
<table align="center" border="1" cellpadding="0" cellspacing="0">
 <tr>
 	<td nowrap="nowrap" align="center">&nbsp;<u><b>N� Id</b></u>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<u><b>Type d'annonce</b></u>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<u><b>Date soumission</b></u>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<u><b>Date p�remption</b></u>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<u><b>Cat�gorie</b></u>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;---&nbsp;</td>
 </tr>
 <tr>
	<td nowrap="nowrap" align="center">&nbsp;<?php echo $annonce->id; ?>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<?php echo ($annonce->isGarde) ? "Garde" : "classique" ; ?>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<?php echo $annonce->getDt_debut() ?>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<?php echo $annonce->getDt_perim(); ?>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<?php echo $oCategorie->getLibelle(); ?>&nbsp;</td>
	<td nowrap="nowrap" align="center">&nbsp;<?php echo ($annonce->valide) ? "Valid�" : "non valid�" ; ?>&nbsp;</td>
 </tr>
<?php

?>
</table>
<?php
} else {
?>
<div align="center"><b><?php echo $status; ?></b></div>
<?php 
}
?>
<br />
<br />
Retour � la <a href="nouvellesAnnonces.php">liste des annonces</a>
