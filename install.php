<?php

include('Donnees.inc.php');

$mysqli = mysqli_connect('localhost', 'root', '') or die("Erreur de connexion");
mysqli_query($mysqli,"USE Projet_Boissons") or die("USE Projet_Boissons : ".mysqli_error($mysqli));

foreach ($Hierarchie as $key => $value) {
    $Sql="INSERT INTO Hierarchie VALUE (\"$key\")";
    $res = mysqli_query($mysqli,$Sql) or die($Sql . " : " . mysqli_error($mysqli));
    if(isset($value['sous-categorie'])){
        foreach ($value['sous-categorie'] as $sous){
            $Sql="INSERT INTO  `sous-categorie` (`nomH`, `nomSC`)  VALUES(\"$key\",\"$sous\")";
            $res = mysqli_query($mysqli,$Sql) or die($Sql . " : " . mysqli_error($mysqli));
        }
    }

    if(isset($value['super-categorie'])){
        foreach ($value['super-categorie'] as $sup){
            $Sql="INSERT INTO  `super-categorie` (`nomH`, `nomSC`)  VALUES(\"$key\",\"$sup\")";
            $res = mysqli_query($mysqli,$Sql) or die($Sql . " : " . mysqli_error($mysqli));
        }
    }

}

foreach ($Recettes as $key => $value){

}

mysqli_close($mysqli);