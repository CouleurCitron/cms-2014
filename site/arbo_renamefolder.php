<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
 /* 

$Author: raphael $

$Revision: 1.1 $



$Log: arbo_renamefolder.php,v $
Revision 1.1  2013-09-30 09:43:12  raphael
*** empty log message ***

Revision 1.6  2013-03-01 10:28:20  pierre
*** empty log message ***

Revision 1.5  2012-07-31 14:24:50  pierre
*** empty log message ***

Revision 1.4  2012-04-03 12:27:40  thao
*** empty log message ***

Revision 1.3  2012-04-03 12:19:48  thao
*** empty log message ***

Revision 1.2  2012-04-03 10:34:32  thao
*** empty log message ***

Revision 1.1  2010-08-23 08:29:51  pierre
*** empty log message ***

Revision 1.7  2009-09-24 08:53:13  pierre
*** empty log message ***

Revision 1.6  2008-07-16 12:57:56  pierre
*** empty log message ***

Revision 1.5  2008/07/16 10:55:28  pierre
*** empty log message ***

Revision 1.4  2008/07/16 10:48:36  pierre
*** empty log message ***

Revision 1.3  2008/07/16 10:04:38  pierre
*** empty log message ***

Revision 1.2  2007/08/09 10:56:30  thao
*** empty log message ***

Revision 1.1  2007/08/08 14:26:26  thao
*** empty log message ***

Revision 1.4  2007/08/08 14:16:15  thao
*** empty log message ***

Revision 1.3  2007/08/08 13:56:04  thao
*** empty log message ***

Revision 1.2  2007/03/27 15:10:39  pierre
*** empty log message ***

Revision 1.1  2006/12/15 12:30:11  pierre
*** empty log message ***

Revision 1.1.1.1  2006/01/25 15:14:32  pierre
projet CCitron AWS 2006 Nouveau Website

Revision 1.4  2005/12/20 11:13:33  sylvie
*** empty log message ***

Revision 1.3  2005/11/04 10:27:42  pierre
NEW RENAME

Revision 1.2  2005/10/27 09:25:55  sylvie
*** empty log message ***

Revision 1.1.1.1  2005/10/20 13:10:53  pierre
Espace V2

Revision 1.3  2005/05/30 10:44:36  michael
R�paration de fonctions dans les briques et les pages
Renommer/ D�placer...
Gestion des caract�res sp�ciaux

Revision 1.2  2005/05/23 17:09:28  pierre
ajout option annuler


Revision 1.1.1.1  2005/04/18 13:53:29  pierre

again



Revision 1.1.1.1  2005/04/18 09:04:21  pierre

oremip new



Revision 1.1.1.1  2004/11/03 13:49:54  ddinside

lancement du projet - import de adequat



Revision 1.3  2004/06/16 15:23:19  ddinside

inclusion corrections



Revision 1.2  2004/04/26 08:07:09  melanie

*** empty log message ***



Revision 1.1.1.1  2004/04/01 09:20:27  ddinside

Cr�ation du projet CMS Couleur Citron nom de code : tipunch



Revision 1.2  2003/11/26 13:08:42  ddinside

nettoyage des fichiers temporaires commit�s par erreur

ajout config spaw

corrections bug menu et positionnement des divs



Revision 1.2  2003/10/07 08:53:28  ddinside

ajout gestionnaire de contenu



Revision 1.1  2003/10/07 08:15:53  ddinside

ajout gestion de l'arborescence des composants



Revision 1.1  2003/09/25 14:55:16  ddinside

gestion de l'arborescene des composants : ajout

*/

// sponthus 17/06/05
// arbo des mini sites


include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/arbominisite.lib.php');
include_once('backoffice/cms/site/minisite.inc.php');

activateMenu('gestioncontenu');  //permet de d�rouler le menu contextuellement


// site connect�
if ($idSite == "") $idSite = $_SESSION['idSite_travail'];

// pas de site
if ($idSite == "") die ("Appel incorrect de la fonctionnalit�");



$id=0;

$virtualPath = 0;

$nodeInfos=array();

if(!strlen($_POST['foldername'])) {

	if (strlen($_GET['v_comp_path']) > 0)

		$virtualPath = $_GET['v_comp_path'];

	$nodeInfos=getNodeInfos($db, $virtualPath);

} else{

	if (strlen($_POST['v_comp_path']) > 0)

		$virtualPath = $_POST['v_comp_path'];

	$nodeInfos=getNodeInfos($db,$virtualPath);
  
	$id=renameNode($idSite, $db,$virtualPath,$_POST['foldername']);
	
	if ($isMinisite) $idMinisite = renameMinisite($idSite, $virtualPath, $nodeInfos['libelle'], $_POST['foldername']);
 
}

?>
 

<form id="managetree" name="managetree" action="<?php echo $_SERVER['PHP_SELF'];?>?idSite=<?php echo $idSite; ?><?php echo $param; ?>" method="post">
<div class="ariane">
<span class="arbo2">ARBORESCENCE&nbsp;>&nbsp;</span>
<span class="arbo3">Renommer un dossier&nbsp;>&nbsp;</span>
<span class="arbo4"><?php echo getAbsolutePathString($idSite, $db, $virtualPath,'arbo.php'); ?></span><br /><br />
</div>
  <table cellpadding="0" cellspacing="0" border="0">
    <tr>

      <td colspan="3"><img src="/backoffice/cms/img/vide.gif"></td>

    </tr>

    <tr> 
      <td width="6" align="left" valign="top" class="arbo">
		  <div id="arborescence" >	
          <p><b><u>Arborescence :</u></b></p>

          <table cellpadding="8" cellspacing="0" border="1" bordercolor="#FFFFFF">

            <tr>

              <td bgcolor="D2D2D2">
				<?php
				//print drawCompTree($idSite, $db,$virtualPath);
				 print drawCompTree($idSite, $db, $virtualPath, null, "/backoffice/cms/site/arbo.php");
				
				?>
				</td>

            </tr>

          </table>

          <br />

          <br />
 			</div>
      </td>

      <td width="5"  align="left" valign="top" class="arbo2"><img src="/backoffice/cms/img/vide.gif" width="15"></td>

      <td  align="left" valign="top" class="arbo">

        <!-- contenu des actions -->

        <?php

	if(!strlen($_POST['foldername'])) {

?>

        <u><b><br />

      Renommer un dossier :</b></u> <br />

      <br />

      <table border="1" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF">

        <tr bgcolor="E6E6E6">

          <td class="arbo" style="vertical-align:middle">Ancien nom&nbsp;:</td>

          <td><input name="dummy" type="text" disabled class="arbo" id="dummy" value="<?php echo $nodeInfos['libelle']; ?>" size="14">

              <input type="hidden" name="v_comp_path" value="<?php echo $virtualPath; ?>"></td>

        </tr>

        <tr bgcolor="EEEEEE">

          <td bgcolor="EEEEEE" class="arbo" style="vertical-align:middle">Nouveau nom :</td>

          <td><input name="foldername" type="text" class="arbo" id="foldername" value="<?php echo $nodeInfos['libelle']; ?>" size="14"></td>

        </tr>

        <tr align="center" bgcolor="EEEEEE">

            <td colspan="2" nowrap bgcolor="D2D2D2" class="arbo"><a href="arbo.php?menuOpen=<?php echo $_GET['menuOpen']; ?>" class="arbo"><strong>Annuler</strong></a>&nbsp;&nbsp;<a href="arbo.php?menuOpen=<?php echo $_GET['menuOpen']; ?>" class="arbo"><img border="0" src="<?php echo $URL_ROOT; ?>/backoffice/cms/img/2013/icone/go.png"></a> 

              - <a href="#" class="arbo" onClick="javascript:document.forms['managetree'].submit();"><strong>Renommer 

              le dossier</strong></a>&nbsp;&nbsp;<a href="#" onClick="javascript:document.forms['managetree'].submit();" class="arbo"><img border="0" src="<?php echo $URL_ROOT; ?>/backoffice/cms/img/2013/icone/go.png"></a></td>

        </tr>

      </table>

      <br />

      <?php

	} else {

		// renommage d'un dossier

		if($id[0]!=false) {

?>

			<p><b><span class="arbo">Le dossier <?php echo $nodeInfos['libelle']; ?> a bien &eacute;t&eacute; renomm&eacute; en <?php echo $_POST['foldername']; ?></span></b> </p>
			<span class="arbo"><?php echo $id[1] ?></span>

      <?php

		} else {

?>

			<p><b><span class="arbo">Un probl&egrave;me est survenu durant l'op&eacute;ration. <br />
			Veuillez r&eacute;essayer ou contacter l'administrateur si l'erreur persiste.</span></b></p>

      <?php

		}

	}

?></td>

    </tr>

  </table>

  </form>











