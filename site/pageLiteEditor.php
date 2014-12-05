<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/composants.lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/gabarit.lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/selectSite.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_class.php');

activateMenu('gestionpage');  //permet de d�rouler le menu contextuellement

// site sur lequel on est positionn�
if ($idSite == "") $idSite = $_SESSION['idSite_travail'];

$dir_gabarits = $_SERVER['DOCUMENT_ROOT']."/".DEF_GABARIT_ROOT;

?><div class="ariane"><span class="arbo2">PAGES >&nbsp;</span><span class="arbo3">Cr�er une page&nbsp;>&nbsp;
Etape 1 : choix du gabarit</span></div>

<script type="text/javascript">document.title="Pages BB";</script>
<script src="/backoffice/cms/js/preview.js" type="text/javascript"></script>
<script type="text/javascript">

	// affinage de la liste des gabarits
	// bandeau de recherche
	function recherche()
	{
		document.pageLiteForm.action = "pageLiteEditor.php";
		document.pageLiteForm.submit();
	}

</script>
<link rel="stylesheet" type="text/css" href="/backoffice/cms/css/bo.css">
<form name="pageLiteForm" method="post">
<span class="arbo">
Choisissez le gabarit � utiliser pour continuer le processus.<br><br>
Choix du gabarit � utiliser :<br>
  <br>
<?php
// r�pertoire des gabarits
if(dirExists($dir_gabarits)) {	
	$contenus = getListGabarits($idSite);

	if(sizeof($contenus) > 0) {
?>
</span>

<table border="0" cellpadding="5" cellspacing="0" class="arbo" id="chooseGabarit">
  <?php
	if((!is_array($contenus)) or (sizeof($contenus)==0)) {
?>
  <tr>
    <td align="center" colspan="3">&nbsp;<strong>Aucun �l�ment � afficher</strong></td>
 </tr>
<?php
	} else {
		foreach ($contenus as $k => $page) {
?>
  <tr>
   <td>Gabarit <?php echo $page['name'];?></td>
    <td class="arbo">&nbsp;<a href="pageLiteEditor2.php?idGab=<?php echo $page['id']; ?>&idSite=<?php echo $idSite; ?>" class="arbo">choisir</a>&nbsp;</td>
    <td class="arbo">&nbsp;<a href="javascript:preview_gabarit(<?php echo  $page['id'] ; ?>)" class="arbo">visualiser</a>&nbsp;</td>
  </tr>
<?php
		}
	}
  ?>
  </table>
<br>
<span class="arbo">
<?php
	 } else {
?>
Aucun �l�ment � afficher.
<?php
	 }
	
} else {
	// pas de repertoire de gabarits...
	error_log("R�pertoire de gabarits absent (".$dir_gabarits."). Veuillez le cr�er");
?>
<b>Erreur !!!!</b>&nbsp;les gabarits sont actuellement indisponibles. Veuillez r�essayer plus tard.<br>
Si le probl�me persiste, veuillez contacter l'administrateur.
<?php
}
?>
</span>
</form>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoappend.php');
?>