<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/arbominisite.lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/composants.lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/procedures.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_cms.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/include_class.php');

activateMenu('gestioncontenu');  //permet de d�rouler le menu contextuellement

$id = $_GET['id'];
$node_id = 0;
$node_name = 'non d�fini';
$composant = null;

if (strlen($id) > 0 ) {
	$composant = getComposantById($id);
	$node_id = $composant['node_id'];
	$node = getNodeInfos($db, $node_id);
	$node_name = $node['libelle'];
}

if(!(isset($_POST['node_id']) && strlen($_POST['node_id'])>0 )) {

?>
<script type="text/javascript">
  function chooseFolder() {
	window.open('/backoffice/cms/chooseFolder.php?idSite=<?php echo $composant["id_site"]; ?>','browser','scrollbars=yes,width=500,height=500,resizeable=yes,menubar=no');
  }
</script>
<span class="arbo2"><strong>D�placement de la brique <?php echo $composant['name']; ?> dans l'arborescence</strong></span>
<form name="saveCuBrick" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post">
<input type="hidden" name="node_id" value="<?php echo $node_id; ?>">
<table border="1" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF" class="arbo">
 <tr>
  <td align="right">Dossier de stockage&nbsp;:&nbsp;</td>
  <td align="left"><input name="foldername" type="text" disabled class="arbo" value="<?php echo $node_name; ?>" size="20">
  &nbsp;&nbsp;<a href="#" class="arbo" onClick="chooseFolder();"><img src="/backoffice/cms/img/2013/icone/go.png" border="0">&nbsp;choisir le dossier</a></td>
 </tr>
 <tr bgcolor="D2D2D2">
  <td colspan="2" align="center"><input name="D�placer" type="submit" class="arbo" value="D�placer"></td>
 </tr>
</table>
</form>

<?php
} else {
	// ok, on enregistre
	$test = null;
	$id = $_GET['id'];
	$test = moveComposant($id, $_POST['node_id']);
	if($test) {
?>
<span class="arbo">La brique composant a �t� d�plac�e.</span>
<br />
<br />
<?php
	} else {
?>
<span class="arbo">Une erreur s'est produite lors de la sauvegarde de la brique. Veuillez r�essayer. Si le probl�me persiste, veuillez contacter l'administrateur</span>
<?php
	}
}
?>
