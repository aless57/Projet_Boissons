<?php

require '../../vendor/autoload.php';
use boissons\controls\RechercheAliment;

session_start();
if(isset($_GET['nom'])){
    $aliment = (String) trim($_GET['nom']);

    new RechercheAliment();
    $listealim = RechercheAliment::getListAliment($aliment);
    foreach($listealim as $a){
        echo "<div>".$a['nom']."</div>";
    }
}
?>