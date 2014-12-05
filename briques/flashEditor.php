<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/include/autoprepend.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/composants.lib.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/include/cms-inc/selectSite.php');

if ($idSite == "") $idSite = $_SESSION['idSite'];

activateMenu('gestionbrique');

$id = $_GET['id'];

$composant = null;
if (strlen($id) > 0)
	$composant = getComposantById($id);
?>
<div class="ariane"><span class="arbo2">Cr�er une brique Flash (SWF)</span></div>
<?php
if(!strlen($_POST['swf'])>0) {
	// premiere phase
	$nom = '';
	$larg = '';
	$long = '';
	$type='';
	$sSwfUrl='';
	$sSwf='';
	$sParams='';
	$sWmode='opaque';
	if ($composant != null) {
		$nom = ' value="'.$composant['name'].'" ';
		$larg = ' value="'.$composant['width'].'" ';
		$long = ' value="'.$composant['height'].'" ';
		$type = ' value="'.$composant['type'].'" ';
		//echo "type :$type";		
		$sBodyHTML = $composant['html'];		
		$sSwfUrl = ereg_replace( ".*swfSrcEmbed = \"([^\"]+)embedUrl.*", "\\1", $sBodyHTML);		
		$sSwf = ereg_replace("([^\?]+)(\?.*)", "\\1.swf", $sSwfUrl);
		$sParams = ereg_replace("([^\?]+\?)(.*)", "\\2", $sSwfUrl);		
		$sWmode = ereg_replace('.*"wmode", "([^"]*)".*', '\\1', $sBodyHTML);
		if (trim($sWmode)==''){
			$sWmode='opaque';
		}
	}	
	
// Chargement de la classe
require_once('cms-inc/lib/fileUpload/upload.class.php');

// Instanciation d'un nouvel objet "upload"
$Upload = new Upload();

// Pour ajouter des attributs aux champs de type file
$Upload-> FieldOptions = 'style="border-color:black;border-width:1px;"';

// Pour indiquer le nombre de champs d�sir�
$Upload-> Fields = 1;

// Initialisation du formulaire
$Upload-> InitForm();
?>
<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'].'?idSite='.$idSite.'&id='.$id; ?>&" name="creation" id="creation">
<?php
// Affichage du champ MAX_FILE_SIZE
print $Upload-> Field[0];
?>
<input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" name="pickswf" id="pickswf" value="pickswf" />
<input type="hidden" name="sparams" id="sparams" value="<?php echo $sParams; ?>" />
<input type="hidden" name="fwmode" id="fwmode" value="<?php echo $sWmode; ?>" />
<input type="hidden" name="minisite" id="minisite" value="<?php echo $_GET['minisite']; ?>" />

<div class="arbo" id="briqueFlashEditor">
        <div class="col_titre">
            Cr&eacute;ation de la brique Flash
        </div>
        <div>
          <label for="swf">choix du SWF :</label>
          <select name="swf" id="swf" class="arbo">
		  	<option value="-1">Choisissez un fichier SWF</option>
		  	<?php
			$aRepertoires = array("/medias", "/media"); // CUSTOM			
			$aRepertoires[] = "/custom/swf/".$_SESSION["rep_travail"]; // GENERIC
			dirExists("/custom/swf/".$_SESSION["rep_travail"]);			
			
			foreach($aRepertoires as $cKey => $sRepertoire){	
				$basedir = $_SERVER['DOCUMENT_ROOT'].$sRepertoire;
				if (is_dir($basedir)){					
					if ($dir = @opendir($basedir)) {
						while (($file = readdir($dir)) !== false) {					
							if ((is_file($basedir."/".$file)) && (ereg(".*\.(swf|SWF)", $file))) {
								$swfPath = str_replace($_SERVER['DOCUMENT_ROOT'], "", $basedir."/".$file);								
								
								 if($swfPath == $sSwf){
									$selected = " selected";
								 }
								 else{
									$selected = "";
								}
								echo "<option value=\"".$swfPath."\"".$selected.">".$swfPath."</option>\n";
							} 
						}
					  closedir($dir);
					}	
				}				
			}
			?>  
          </select>
        </div>
        <p>
            ou
        </p>
        <div class="rightContent">
            <label>Upload de SWF :</label>
          <?php echo $Upload->Field[1]; ?>
        </div>
        <div>
              <input name="Suite (cr&eacute;ation) &gt;&gt;" type="submit" class="arbo" id="SuiteButton" value="Suite (cr&eacute;ation) &gt;&gt;">
        </div>
    </div>

</form>
<?php	
} elseif (is_post("pickswf")) {	

$sParams = $_POST['sparams'];
$sWmode = $_POST['fwmode'];

// Chargement de la classe
require_once('cms-inc/lib/fileUpload/upload.class.php');

// Instanciation d'un nouvel objet "upload"
$Upload = new Upload();

// Pour ne pas �craser un fichier existant
$Upload->  WriteMode  = '1';

 // D�finition du r�pertoire de destination
dirExists("/custom/swf/".$_SESSION["rep_travail"]);		
$Upload-> DirUpload    = $_SERVER['DOCUMENT_ROOT']."/custom/swf/".$_SESSION["rep_travail"];

// Pour limiter la taille d'un  fichier (exprim�e en ko)
$Upload-> MaxFilesize  = '10000';

// On lance la proc�dure d'upload
$Upload-> Execute();

if (is_file($Upload->Infos[1]["chemin"])){
	$selectedFile =  str_replace($_SERVER['DOCUMENT_ROOT'], "", $Upload->Infos[1]["chemin"]);	
}
elseif(is_file($_SERVER['DOCUMENT_ROOT'].$_POST["swf"])){
	$selectedFile = $_POST["swf"];
}
else{
?>
	<script type="text/javascript">
	alert("Choix du SWF incorrect");
	history.back();
	</script>
	<?php
	die();
}
?>
<script language="javascript" type="text/javascript">
function insertRow(){
	nextNum = parseInt(document.getElementById('numparam').value);	
	currentHTML = "";
	for (i=0;i<nextNum;i++){
		currentHTML += '<br /><input id="param'+i+'" name="param'+i+'" type="text" value="'+document.getElementById('param'+i).value+'" /><input id="value'+i+'" name="value'+i+'" type="text" value="'+document.getElementById('value'+i).value+'" />'	
	}
	document.getElementById('rows').innerHTML = currentHTML + '<br /><input id="param'+nextNum+'" name="param'+nextNum+'" type="text" value="" /><input id="value'+nextNum+'" name="value'+nextNum+'" type="text" value="" />';
	document.getElementById('numparam').value = nextNum + 1;
}

</script>
<form method="post" enctype="multipart/form-data" name="formulaire" id="formulaire" action="<?php echo $_SERVER['PHP_SELF']; ?>?idSite=<?php echo $idSite; ?>&id=<?php echo $id; ?>&">
<span class="arbo2"><strong>Choix des param�tres pour <?php echo $selectedFile; ?> :</strong></span>
<br /><br /><span class="arbo2">Param�trage Plug-in Flash</span><br /><br />
<span class="arbo">
WMODE&nbsp;:&nbsp;<input id="fwmode" name="fwmode" value="<?php echo $sWmode ?>" type="text" /></span>
<br /><br /><span class="arbo2">Param�tres transmis au SWF : Nom / Valeur</span><br />

<div id="rows">
<?php
$eParamCount = 0;
$aParams = split("&", $sParams);

$isAdmin = false;
if (($_SESSION["rank"] == "ADMIN")||(intval($_SESSION["groupe"]) == 1)){
	$isAdmin = true;
}

if ($isAdmin == true){ // pour les admins, param�tres names �ditables
	foreach($aParams as $k => $sParamSet){
		if (strlen($sParamSet) > 0){
			$aParamSet = split("=", $sParamSet);
			echo "<br /><input id=\"param".$eParamCount."\" name=\"param".$eParamCount."\" type=\"text\" value=\"".$aParamSet[0]."\" />";
			echo "<input id=\"value".$eParamCount."\" name=\"value".$eParamCount."\" type=\"text\" value=\"".flashurl_decode(utf8_decode($aParamSet[1]))."\" />";
			$eParamCount++;
		}
	}
	if ($eParamCount == 0){
		echo "<br /><input id=\"param0\" name=\"param0\" type=\"text\" value=\"\" /><input id=\"value0\" name=\"value0\" type=\"text\" value=\"\" />";
		$eParamCount++;
	}
	
	echo "</div>";
	echo "<input type=\"button\" name=\"Insert\" value=\"Ajouter\" class=\"arbo\" onclick=\"insertRow();\" /><br />";	
}
else{ // pour les autres, param�tres values �ditables only
	foreach($aParams as $k => $sParamSet){
		if (strlen($sParamSet) > 0){
			$aParamSet = split("=", $sParamSet);
			echo "<br /><input id=\"__".$eParamCount."\" name=\"__".$eParamCount."\" type=\"text\" value=\"".$aParamSet[0]."\" disabled=\"1\" />";
			echo "<input id=\"param".$eParamCount."\" name=\"param".$eParamCount."\" type=\"hidden\" value=\"".$aParamSet[0]."\" />";
			echo "<input id=\"value".$eParamCount."\" name=\"value".$eParamCount."\" type=\"text\" value=\"".flashurl_decode(utf8_decode($aParamSet[1]))."\" />";
			$eParamCount++;
		}
	}
	echo "</div>";
	echo "<br />";		
}
?>


<br />
<input type="hidden" id="numparam" name="numparam" value="<?php echo $eParamCount; ?>" />
<input type="hidden" id="TYPEcontent" name="TYPEcontent" value="SWF" class="arbo" />
<input type="hidden" id="largeur" name="largeur" value="" class="arbo" />
<input type="hidden" id="hauteur" name="hauteur" value="" class="arbo" />
<input type="hidden" id="nom" name="nom" value="<?php echo $_POST['nom']; ?>" class="arbo" />
<input type="hidden" id="type" name="type" value="<?php echo $_POST['type']; ?>" class="arbo" />
<input type="hidden" id="idSite" name="idSite" value="<?php echo $idSite; ?>" />
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
<input type="hidden" id="swf" name="swf" value="<?php echo $selectedFile; ?>" />
<input type="hidden" id="pickparam" name="pickparam" value="pickparam" />
<input type="submit" id="submit" name="submit" class="arbo" value="Envoyer" />
</form>
<?php	
}elseif (is_post("pickparam")) {

$sSwf = $_POST['swf'];
$wmode =  $_POST['fwmode'];
list($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].$sSwf);
$sSwfUrl = str_replace(".swf", "", $sSwf);
$sSwfUrlObject = $sSwfUrl."?";
$sSwfUrlEmbed = $sSwfUrl."?";
$sFlashVars = "";
if (($_POST["numparam"] > 0) && (is_post("param0"))){	
	for ($i=0;$i<$_POST["numparam"];$i++){
		if (strlen($_POST["param".$i]) > 0){
			$sSwfUrlObject .= $_POST["param".$i]."=".(flashurl_encode($_POST["value".$i]))."&amp;";
			$sSwfUrlEmbed .= $_POST["param".$i]."=".utf8_encode(flashurl_encode($_POST["value".$i]))."&amp;";
			$sFlashVars .= $_POST["param".$i]."=".(flashurl_encode($_POST["value".$i]))."&amp;";
		}
	}
}

$sBodyHTML = '<script src="/backoffice/cms/js/AC_RunActiveContent.js" type="text/javascript"></script>';
$sBodyHTML .= '<script type="text/javascript">';
$sBodyHTML .= 'swfSrcObject = "'.$sSwfUrlObject.'embedUrl="+escape(document.location.href);';
$sBodyHTML .= 'swfSrcEmbed = "'.$sSwfUrlEmbed.'embedUrl="+escape(document.location.href);';
$sBodyHTML .= 'flashvars = "'.$sFlashVars.'embedUrl="+escape(document.location.href);';

$sBodyHTML .= 'AC_FL_RunContent( "codebase","https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version='.DEF_FLASHPLAYERREQUIRED.',0,0,0",
"width","'.$width.'","height","'.$height.'","src", "'.$sSwfUrl.'", "quality","high","pluginspage","https://get.adobe.com/flashplayer/",
"align", "middle", "play", "true", "loop", "true", "scale", "showall", "wmode", "'.$wmode.'", "devicefont", "false",
"id", "'.basename($sSwf).'", "name", "'.basename($sSwf).'", "menu", "false", "allowFullScreen", "false",
"allowScriptAccess","sameDomain","movie", "'.$sSwfUrl.'", "salign", "", "flashvars", flashvars );';
$sBodyHTML .= '</script>';

echo $sBodyHTML;
?>
<form method="post" name="formulaire" id="formulaire" action="saveComposant.php?idSite=<?php echo $idSite; ?>&id=<?php echo $id; ?>&">
<span class="arbo2"><strong>Preview de la brique SWF pour <?php echo $_POST['swf']; ?>:</strong></span>

<input type="hidden" id="TYPEcontent" name="TYPEcontent" value="SWF" class="arbo" />
<input type="hidden" id="WIDTHcontent" name="WIDTHcontent" value="<?php echo $width; ?>">
<input type="hidden" id="HEIGHTcontent" name="HEIGHTcontent" value="<?php echo $height; ?>">
<input type="hidden" id="NAMEcontent" name="NAMEcontent" value="<?php echo basename($sSwf); ?>">
<input type="hidden" id="HTMLcontent" name="HTMLcontent" value='<?php echo $sBodyHTML; ?>'>
<input type="hidden" id="OBJTABLEcontent" name="OBJTABLEcontent" value="<?php echo $_POST['type']; ?>">
<input type="hidden" id="OBJIDcontent" name="OBJIDcontent" value="<?php echo $_POST['fitem']; ?>">
<input type="hidden" id="largeur" name="largeur" value="<?php echo $width; ?>" class="arbo" />
<input type="hidden" id="hauteur" name="hauteur" value="<?php echo $height; ?>" class="arbo" />
<input type="hidden" id="nom" name="nom" value="<?php echo $_GET['nom']; ?>" class="arbo" />
<input type="hidden" id="type" name="type" value="<?php echo $_POST['type']; ?>" class="arbo" />
<input type="hidden" id="idSite" name="idSite" value="<?php echo $idSite; ?>" />
<input type="submit" id="submit" name="submit" class="arbo" value="Envoyer" />
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
<input type="hidden" id="swf" name="swf" value="<?php echo $sSwf; ?>" />
</form>
<?php	
}
?>