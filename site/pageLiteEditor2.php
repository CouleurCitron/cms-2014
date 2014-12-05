<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/composants.lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/gabarit.lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/selectSite.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_class.php');

activateMenu('gestionpage');  //permet de d�rouler le menu contextuellement

// site sur lequel on est positionn�
if ($idSite == "") $idSite = $_SESSION['idSite_travail'];
	
$contenus = dbGetObjectsFromFieldValue("cms_theme", array("get_site", "get_statut"),  array($idSite, DEF_ID_STATUT_LIGNE), NULL);

if(sizeof($contenus) == 1) {
	// skip
	$oTheme = $contenus[0];
	echo '<script type="text/javascript">document.location.href="pageLiteEditor3.php?idGab='.$_GET['idGab'].'&idThe='.$oTheme->get_id().'&idSite='.$idSite.'";</script>';
}
elseif(sizeof($contenus) == 0) {
	// skip
	echo '<script type="text/javascript">document.location.href="pageLiteEditor3.php?idGab='.$_GET['idGab'].'&idSite='.$idSite.'";</script>';
}
else{

?><div class="ariane"><span class="arbo2">PAGES >&nbsp;</span><span class="arbo3">Cr�er une page&nbsp;>&nbsp;
Etape 1 : choix du th�me</span></div>
<script src="/backoffice/cms/js/preview.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/backoffice/cms/css/bo.css">
<form name="pageLiteForm" id="pageLiteForm" method="post">
<span class="arbo">
Choisissez le th�me � utiliser pour continuer le processus.<br><br>
Choix du th�me � utiliser :<br>
  <br>
</span>
<table border="0" cellpadding="5" cellspacing="0" class="arbo">
<?php
foreach ($contenus as $k => $oTheme) {
?>
  <tr>
   <td>Th�me <?php echo $oTheme->get_nom();?></td>
    <td bgcolor="D2D2D2" class="arbo">&nbsp;<a href="pageLiteEditor3.php?idGab=<?php echo $_GET['idGab']; ?>&idThe=<?php echo $oTheme->get_id(); ?>" class="arbo" title="<?php echo $oTheme->get_nom().' : '.$oTheme->get_desc(); ?>">choisir</a>&nbsp;</td>
    
  </tr>
<?php
}
?>
</table>
</form>
<?php
} 

include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoappend.php');
?>