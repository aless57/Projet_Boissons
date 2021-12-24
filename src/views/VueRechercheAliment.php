<?php

require '../../vendor/autoload.php';
use boissons\controls\RechercheAliment;

session_start();
if(isset($_GET['nom'])){
    $aliment = (String) trim($_GET['nom']);
    $afficher = array();
    new RechercheAliment();
    $listealim = RechercheAliment::getListAliment($aliment);
    foreach($listealim as $a){
        if(!in_array($a['nom'], $afficher, true)) {
            echo "<div>" . $a['nom'] . "</div>";
            array_push($afficher, $a['nom']);
        }
        $listesc = RechercheAliment::getListSC($a['nom']);
        foreach ($listesc as $s){
            if(!in_array($s['nomSC'], $afficher, true)) {
                echo "<div>".$s['nomSC']."</div>";
                array_push($afficher, $s['nomSC']);
            }
        }
    }
}
?>