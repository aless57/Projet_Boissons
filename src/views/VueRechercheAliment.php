<?php


/*
 * SELECT idRecette FROM `index`
WHERE idRecette IN (select idRecette from `index` where nom like 'Malibu')
AND idRecette IN (select idRecette from `index` where nom like 'Cerise')
GROUP BY idRecette;
 */

require '../../vendor/autoload.php';
use boissons\controls\RechercheAliment;

session_start();
$html = "";
if(isset($_GET['nom'])){
    $aliment = (String) trim($_GET['nom']);
    $afficher = array();
    new RechercheAliment();
    $listealim = RechercheAliment::getListAliment($aliment);
    echo "<h4 class='text-center'> Element(s) recherche(s) </h4>";
    foreach($listealim as $a){
        if(!in_array($a['nom'], $afficher, true)) {
            $test = $a['nom'];
            $html .=
                "<div>" . $a['nom'] . "
                </div> 
                <a href=' " . ajouterElementSessions($test) ."' > Ajouter Element A</a>";
            array_push($afficher, $a['nom']);
        }
        $listesc = RechercheAliment::getListSC($a['nom']);
        foreach ($listesc as $s){
            if(!in_array($s['nomSC'], $afficher, true)) {
                $test2 = $s['nomSC'];
                $html .=
                    "<div>".$s['nomSC']."
                    </div> 
                <a href=''" . ajouterElementSessions($test2)."  > Ajouter Element B</a>";
                array_push($afficher, $s['nomSC']);
            }
        }
    }
}

echo $html;

/**
 * Fonction ajouterElementSessions qui permet d'ajouter un element de recherche a la variable de session
 * @param $elementSession
 */
function ajouterElementSessions($elementSession){
    if(!isset($_SESSION['recherche'])){
        $_SESSION['recherche'][0] = array();
    }
    $_SESSION['recherche'] = [];
    $_SESSION['recherche'] = array($elementSession);
}
?>