<?php

include('Donnees.inc.php');

$mysqli = mysqli_connect('localhost', 'root', '') or die("Erreur de connexion");


// Create database
$sql = "CREATE DATABASE Projet_Boissons";
if ($mysqli->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $mysqli->error;
}

mysqli_query($mysqli,"USE Projet_Boissons") or die("USE Projet_Boissons : ".mysqli_error($mysqli));

$sql = "CREATE TABLE `contient` (
  `idPanier` int(10) NOT NULL,
  `idRecette` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "CREATE TABLE `hierarchie` (
  `nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "CREATE TABLE `index` (
  `idIndex` int(10) NOT NULL,
  `idRecette` int(10) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "CREATE TABLE `panier` (
  `id` int(10) NOT NULL,
  `login` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "INSERT INTO `panier` (`id`, `login`) VALUES
(1, 'alessi'),
(2, 'alessi'),
(3, 'alessi'),
(4, 'arthur'),
(5, 'arthur');";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "CREATE TABLE `recettes` (
  `id` int(10) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `ingredients` varchar(300) NOT NULL,
  `preparation` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "CREATE TABLE `sous-categorie` (
  `nomH` varchar(30) NOT NULL,
  `nomSC` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "CREATE TABLE `super-categorie` (
  `nomH` varchar(30) NOT NULL,
  `nomSC` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "CREATE TABLE `utilisateur` (
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `login` varchar(20) NOT NULL,
  `mdp` varchar(200) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `naissance` date NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `postal` int(5) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `tel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "INSERT INTO `utilisateur` (`nom`, `prenom`, `login`, `mdp`, `sexe`, `mail`, `naissance`, `adresse`, `postal`, `ville`, `tel`) VALUES
('Demange', 'Alessi', 'alessi', '$2y$10\$HkZF4JyFQQ/xa5No0hx2nufV6u4BhtCuS4VTKk8rnAaf/9LXrEAma', 'Homme', 'aa@gmail.com', '2021-12-09', '15 Rue des rues', 58781, 'VilleOuf', '0666666666'),
('Moitrier', 'Arthur', 'arthur', '$2y$10\$zWPJiYZQATYdxzIvsKXY/eGysTJnEVXBHuXU.0.0KMIIJ5CjamupO', 'Homme', 'bb@gmail.com', '1997-02-21', '48 Avenue des avenues', 79464, 'VillePasOuf', '0777777777');
";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "ALTER TABLE `contient`
  ADD PRIMARY KEY (`idPanier`,`idRecette`);";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "ALTER TABLE `hierarchie`
  ADD PRIMARY KEY (`nom`);";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "ALTER TABLE `index`
  ADD PRIMARY KEY (`idIndex`);";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`);";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "ALTER TABLE `recettes`
  ADD PRIMARY KEY (`id`);";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "ALTER TABLE `sous-categorie`
  ADD PRIMARY KEY (`nomH`,`nomSC`);";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));

$sql = "ALTER TABLE `super-categorie`
  ADD PRIMARY KEY (`nomH`,`nomSC`);";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`login`);";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "ALTER TABLE `index`
  MODIFY `idIndex` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "ALTER TABLE `panier`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));


$sql = "ALTER TABLE `recettes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;";
$res = mysqli_query($mysqli,$sql) or die($sql . " : " . mysqli_error($mysqli));




//Ajout des élément dans la base de données à partir du fichier Donneees.inc.php
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

foreach ($Recettes as $value){
    $titre = str_replace("'", "\'",$value['titre']);
    $ing = $value['ingredients'];
    $prepa = str_replace('"', '\"',$value['preparation']);
    $Sql="INSERT INTO  `recettes` (`titre`, `ingredients`, `preparation`)  VALUES(\"$titre\",\"$ing\",\"$prepa\")";
    $res = mysqli_query($mysqli,$Sql) or die($Sql . " : " . mysqli_error($mysqli));
    $Sql="SELECT id from recettes where titre like \"$titre\"";
    $result = mysqli_query($mysqli,$Sql) or die($Sql . " : " . mysqli_error($mysqli));
    $id = mysqli_fetch_array($result)[0];
    foreach ($value['index'] as $i){
        $Sql="INSERT INTO  `index` (`idRecette`, `nom`)  VALUES(\"$id\",\"$i\")";
        $res = mysqli_query($mysqli,$Sql) or die($Sql . " : " . mysqli_error($mysqli));
    }
}

mysqli_close($mysqli);