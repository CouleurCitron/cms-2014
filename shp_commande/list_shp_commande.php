<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');

$aCustom = array();
$sRep = "../../../custom/newsletter/";
$aCustom["JS"] = " // js
function voirDetail(id) {
		document.##classePrefixe##_list_form.display.value = id;
		document.##classePrefixe##_list_form.actiontodo.value = \"REPONDRE\";
		document.##classePrefixe##_list_form.action = \"/backoffice/cms/shp_commande/detail_shp_commande.php?display=\"+id;
		document.##classePrefixe##_list_form.submit();
}

";
$aCustom["Action"] = "<a href=\"javascript:voirDetail(##id##);\" title=\"Voir le d�tail\"><img src=\"/backoffice/cms/img/2013/icone/details.png\" alt=\"Voir le d�tail\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:exporter(##id##);\" title=\"Voir le d�tail\"> </a>";

include('cms-inc/autoClass/list.php');

?>