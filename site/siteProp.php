<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
/*
sponthus 07/06/2005

Gestion des propri�t�s du site

*/

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_class.php');


activateMenu('gestiondusite');  //permet de d�rouler le menu contextuellement


if (!isset($_POST['id'])) {
	$id = 1;
}
else {
	// par d�faut le site de base est id=1
	$id = $_POST['id'];
}

$oSite = new Cms_site($id);
?>
<style type="text/css">
	.ligne {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 12px;
		text-decoration: none;
		font-weight: normal;
		letter-spacing: normal;
	}
</style>
<?php
if ($bResult) {
?>
<script>
	// validation du formulaire
	function valider(id, operation)
	{
		document.siteForm.action = "validerSite.php";
		document.siteForm.id.value = id;		
		document.siteForm.submit();	
	}
</script>
<form name="siteForm" method="post">

<input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">

<span class="arbo2"><b>Propri�t�s du site</b></span>

<table align="center" border="0" cellpadding="3" cellspacing="3" class="arbo">
	<tr class="ligne">
		<td class="arbo" >Nom</td>
		<td class="arbo"><?php echo $oSite->get_name(); ?><?//=$oSite->getDesc_site()?>&nbsp;</td>
	</tr>
	<tr class="ligne">
		<td class="arbo">URL</td>
		<td class="arbo"><?php echo $oSite->getUrl_site(); ?>&nbsp;</td>
	</tr>
	<tr class="ligne">
		<td class="arbo">Fonctionnalit�s</td>
		<td class="arbo">
<?php
// les fonctionnalit�s du site
$aFonct = split(";", $oSite->getFonct_site());

for ($a=0; $a<sizeof($aFonct); $a++)
{
	$sLibFonct = getLibelleDefineWithCode($aFonct[$a]);
?>
	<?php echo $sLibFonct; ?><?php if ($a != sizeof($aFonct)-1) { ?><br><?php } ?>
<?php
}
?>		
		&nbsp;</td>
	</tr>
</table>

<br>
<div align="center" class="arbo"><input type="button" class="arbo" value="Modifier" onClick="javascript:valider(<?php echo $oSite->get_id(); ?>, 'UPDATE')"></div>

</form>
<?php
} else {
?><div align="center" class="arbo">Les propri�t�s du site ne sont pas d�finies</div>
<?php
}
?>