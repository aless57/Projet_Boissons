<?php


    namespace boissons\views;

    use boissons\controls\ControleurAccueil;
    use function Symfony\Component\Translation\t;

    /**
     * Class VueAccueil
     * @package mywishlist\vue
     */
    class VueAccueil
    {

        private $tab;
        private $container;

        /**
         * VueAccueil constructor.
         * @param $tab
         * @param $container
         */
        public function __construct($tab, $container)
        {
            $this->tab = $tab;
            $this->container = $container;

        }

        /**
         * Affiche les informations des aliments
         * @param $arrayHierarchie
         * @return string
         */
        public function afficherInformations($arrayHierarchie,$name){
            $html = <<<FIN
            <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
FIN;

            $html .= <<<FIN
                        <h2 class="section-heading mb-4">
                                    <span class="section-heading-upper">Ingredient</span>
                                    <span class="section-heading-lower">$name</span>
                       
FIN;

            $test = array_keys($arrayHierarchie);
            switch (count($test)){
                //Cas avec un type soit sous-categorie soit super-categorie
                case 1 :
                    if(array_keys($arrayHierarchie)[0] == 'sous-categorie'){
                        $html .= "<br><span class='section-heading-upper'>Sous-Catégorie(s)</span></h2>";
                        $html .= "<ul class='list-unstyled list-hours mb-5 text-left mx-auto'>";
                        foreach ($arrayHierarchie as $value){
                            foreach ($value as $element){
                                $element = str_replace(" ","_",$element);
                                $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $element]);
                                $html.= "<li class='list-unstyled-item list-hours-item d-flex'>";
                                $html .="<a href=$url_affichage>$element</a></li>";
                            }
                        }
                        $html.= "</ul>";
                    }else{
                        $html .= "<br><span class='section-heading-upper'>Super-Catégorie(s)</span></h2>";
                        $html .= "<ul class='list-unstyled list-hours mb-5 text-left mx-auto'>";
                        foreach ($arrayHierarchie as $value){
                            foreach ($value as $element){
                                $element = str_replace(" ","_",$element);
                                $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $element]);

                                $html.= "<li class='list-unstyled-item list-hours-item d-flex'>";
                                $html .="<a href=$url_affichage>$element</a></li>";
                            }
                        }
                        $html.= "</ul>";
                    }

                    break;
                //Cas avec super-categorie et sous-categorie
                case 2:
                    $html .= "<br><span class='section-heading-upper'>Super-Catégorie(s)</span></h2>";
                    $html .= "<ul class='list-unstyled list-hours mb-5 text-left mx-auto'>";
                    foreach ($arrayHierarchie['super-categorie'] as $value){
                        $value = str_replace(" ","_",$value);
                        $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $value]);
                        $html.= "<li class='list-unstyled-item list-hours-item d-flex'>";
                        $html .="<a href=$url_affichage>$value</a></li>";
                    }
                    $html.= "</ul>";
                    $html .= <<<FIN
                        <h2 class="section-heading mb-4">
FIN;
                    $html .= "<br><span class='section-heading-upper'>Sous-Catégorie(s)</span></h2>";
                    $html .= "<ul class='list-unstyled list-hours mb-5 text-left mx-auto'>";
                    foreach ($arrayHierarchie['sous-categorie'] as $value){
                        $value = str_replace(" ","_",$value);
                        $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $value]);
                        $html.= "<li class='list-unstyled-item list-hours-item d-flex'>";
                        $html .="<a href=$url_affichage>$value</a></li>";
                    }
                    $html.= "</ul>";
                    break;

                    default:
                    break;
            }

            return $html;
        }

        /**
         * Affiche les recettes assiciées à l'ingredient
         * @param $recettes
         * @param $aliments
         */
        public function afficherRecette($recettes, $aliments){
            $html = <<<FIN
                        <h2 class="section-heading mb-4">
                       
FIN;
            $html .= "<span class='section-heading-upper'> Recette(s) associe(s) : </span></h2>";



            //Foreach sur tous les aliments
            foreach ($recettes as $recette){
                //Foreach sur l'index de la recette (ici c'est les ingredient qui composent la recette)
                foreach ($recette['index'] as $ingredient){
                    //Si un ingredient correspong à l'ingredient de base
                    if ($ingredient == $aliments){

                        $html .= "<section class='recette'> <h2> " . $recette['titre'] . "</h2>";
                        $i = 0;
                        //Foreach sur la recette entiere
                        foreach ($recette as $recetteEntiere){
                            switch ($i){
                                case 0:
                                    break;
                                case 1:
                                    $html .= "<br><h4> Quantité : </h4>";
                                    $recetteEntiere = str_replace("|","<br>",$recetteEntiere);
                                    $html .= "<p> $recetteEntiere </p>";
                                    break;
                                case 2:
                                    $html .= "<br><h4> Recette : </h4>";
                                    $recetteEntiere = str_replace(".",".<br>",$recetteEntiere);
                                    $html .= "<p> $recetteEntiere </p>";
                                    break;
                                default:
                                $html .= "<br> <h4> Ingredient : </h4>";
                                foreach ($recetteEntiere as $ingredientUnParUn){
                                    $html .= "<li> $ingredientUnParUn </li>";
                                }
                                //Transformation du nom de la photo
                                $nomPhoto = $recette['titre'];
                                $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ','ñ');
                                $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y','n');
                                $nomPhoto = str_replace($search, $replace, $nomPhoto);
                                $nomPhoto = str_replace(" ", "_", $nomPhoto);
                                $nomPhoto = strtolower($nomPhoto);
                                $nomPhoto = ucfirst($nomPhoto);
                                $nomPhoto .= ".jpg";
                                //Inserer une photo si possible
                                $photodir = 'Photos';
                                $files = scandir($photodir);
                                $test = true;
                                foreach ($files as $value){
                                    $path = realpath($photodir.DIRECTORY_SEPARATOR.$value);
                                    if(!is_dir($path)){
                                        if($nomPhoto == $value){
                                            $html .= "<h4> Photo associee : </h4>";
                                            $html .= "<img src='Photos/$value' alt='Image' height='100' width='100'>";
                                            $test = false;
                                            break;
                                        }
                                    }
                                }
                            break;
                            }
                            $i++;
                            //$html .= "<tr></tr>";
                        }
                    }
                    $html .= "</section>";
                }
            }
            $html .= "</div></div></div></div>";
            return $html;
        }
        /**
         * RENDER
         * @param int $select
         * @return string
         */
        public function render( int $select )
        {
            $url_affichageHome = $this->container->router->pathFor("racine");
            $url_affichageAliment =$this->container->router->pathFor("afficherInformation",['element' => 'Aliment']);
            $url_inscription = $this->container->router->pathFor("inscription");
            $url_deconnexion = $this->container->router->pathFor("deconnexion");

            $connexion = "";
            $content = "";
            if (isset($_SESSION['profile']['username'])){
                // l'utilisateur est connecté
                $connexion .= <<<FIN
                    <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="$url_deconnexion">Deconnexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
FIN;
            }else{
                // l'utilisateur n'est pas connecté
                $connexion .= <<<FIN
                    <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="$url_inscription">Connexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
FIN;
            }
            switch ($select){
                //Home
                case 0:
                    $url = "";
//                    $ensembleNom = array_keys($this->tab[0]);
//                    $nomAliment = end($ensembleNom);
//                    $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $nomAliment]);
//                    $html .= "<a href=$url_affichage>$nomAliment</a>" ;
                    $content .= <<<FIN
<section class="page-section clearfix">
            <div class="container">
                <div class="intro">
                    <img class="intro-img img-fluid mb-3 mb-lg-0 rounded" src="assets/img/intro.jpg" alt="..." />
                    <div class="intro-text left-0 text-center bg-faded p-5 rounded">
                        <h2 class="section-heading mb-4">
                            <span class="section-heading-upper">Nouveau Bar</span>
                            <span class="section-heading-lower">Gouter l'excellence</span>
                        </h2>
                        <p class="mb-3">
Chaque cocktail de notre alcool artisanal de qualité commence avec des ingrédients locaux et cueillis à la main. Une fois que vous l'aurez essayé, notre cocktail aura un merveilleux ajout à votre routine quotidienne - Nous vous le garantissons !</p>
                        <div class="intro-button mx-auto"><a class="btn btn-primary btn-xl" href="$url_affichageAliment">Regardez nos ingredient !</a></div>
                    </div>
                </div>
            </div>
        </section>
FIN;

                    break;
                case 1:
                    $url = "../";
                    //Affiche Hierarchie
                    $content .= $this->afficherInformations($this->tab[0],$this->tab[1]);
                    //Affichage Recette
                    $content .= $this->afficherRecette($this->tab[2], $this->tab[1]);
                    break;
                default:
                    break;
            }
            $urlentierCss = $url . "css/styles.css";
            $html = <<<FIN
    <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Projet Web Licence Informatique</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="$urlentierCss" rel="stylesheet" />
    </head>
    <body>
        <header>
            <h1 class="site-heading text-center text-faded d-none d-lg-block">
                <span class="site-heading-upper text-primary mb-3">WEB Project</span>
                <span class="site-heading-lower">Web Bar & Co</span>
            </h1>
        </header>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-uppercase fw-bold d-lg-none" href="index.html">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="$url_affichageHome">Home</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="$url_affichageAliment">Listes des aliments</a></li>
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="products.html">Products</a></li>           
FIN;

            $html .= $connexion;
            $html .= $content;

            $html .= <<<FIN
    </body>
    </html>
FIN;

            return $html;
        }
    }