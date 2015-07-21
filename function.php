<?php 

/*  MESSAGE FLASH  *********************/

function flash(){
	if (isset($_SESSION['flash'])) {
		extract($_SESSION['flash']);
		unset($_SESSION['flash']);
		return "<div class='alert alert-$type alert-dismissable'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
		$message
		</div>";
	}
}

function setFlash($message, $type = 'success'){
	$_SESSION['flash']['message'] = $message;
	$_SESSION['flash']['type'] = $type;
}



function raccourcirChaine($chaine, $tailleMax)
{
    // Variable locale
    $positionDernierEspace = 0;
    if( strlen($chaine) >= $tailleMax )
    {
      $chaine = substr($chaine,0,$tailleMax);
      $positionDernierEspace = strrpos($chaine,' ');
      $chaine = substr($chaine,0,$positionDernierEspace).'...';
  }
  return $chaine;
}


function MoisFrancais($pMois){
    $aMois = array(  
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre"
        );
    if($pMois < count($aMois)+1)
        return $aMois[$pMois-1] ;
}



function debug($variable){
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function cleanCaracteresSpeciaux ($chaine)
{
    setlocale(LC_ALL, 'fr_FR');

    $chaine = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $chaine);

    $chaine = preg_replace('#[^0-9a-z]+#i', '.', $chaine);

    while(strpos($chaine, '--') !== false)
    {
        $chaine = str_replace('--', '-', $chaine);
    }

    $chaine = trim($chaine, '-');

    return $chaine;
}


if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = md5(time() + rand());
}

function csrf(){
    return 'csrf=' . $_SESSION['csrf'];
}

function checkCsrf(){
    if (!isset($_GET['csrf']) || $_GET['csrf'] != $_SESSION['csrf']) {
        header('Location:csrf.php');
        die();
    }
}