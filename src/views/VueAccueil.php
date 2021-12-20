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
            $html = "<h1> $name </h1>";
            $test = array_keys($arrayHierarchie);
            switch (count($test)){
                //Cas avec un type soit sous-categorie soit super-categorie
                case 1 :
                    if(array_keys($arrayHierarchie)[0] == 'sous-categorie'){
                        $html .= "<h2> Sous-Catégorie </h2>";
                        foreach ($arrayHierarchie as $value){
                            foreach ($value as $element){
                                $element = str_replace(" ","_",$element);
                                $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $element]);
                                $html .="<a href=$url_affichage>$element</a><br>";
                            }
                        }
                    }else{
                        $html .= "<h2> Super-Catégorie </h2>";
                        foreach ($arrayHierarchie as $value){
                            foreach ($value as $element){
                                $element = str_replace(" ","_",$element);
                                $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $element]);

                                $html .="<a href=$url_affichage>$element</a><br>";
                            }
                        }
                    }

                    break;
                //Cas avec super-categorie et sous-categorie
                case 2:
                    $html .= "<h2> Super-Catégorie </h2>";
                    foreach ($arrayHierarchie['super-categorie'] as $value){
                        $value = str_replace(" ","_",$value);
                        $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $value]);
                        $html .="<a href=$url_affichage>$value</a><br>";
                    }
                    $html .= "<h2> Sous-Catégorie </h2>";
                    foreach ($arrayHierarchie['sous-categorie'] as $value){
                        $value = str_replace(" ","_",$value);
                        $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $value]);
                        $html .="<a href=$url_affichage>$value</a><br>";
                    }
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
            $html = "<h2> Recette(s) associe(s) : </h2>";
            //Foreach sur tous les aliments
            foreach ($recettes as $recette){
                //Foreach sur l'index de la recette (ici c'est les ingredient qui composent la recette)
                foreach ($recette['index'] as $ingredient){
                    //Si un ingredient correspong à l'ingredient de base
                    if ($ingredient == $aliments){
                        $html .= "<h3> Recette de " . $recette['titre'] . "</h3>";
                        $i = 0;
                        //Foreach sur la recette entiere
                        foreach ($recette as $recetteEntiere){
                            if($i<3){
                                $html .= "<li> $recetteEntiere </li>";
                                $i = $i + 1;
                            }else{
                                $html .= "<p> <strong> Ingredient :</strong> </p>";
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
                                foreach ($files as $value){
                                    $path = realpath($photodir.DIRECTORY_SEPARATOR.$value);
                                    if(!is_dir($path)){
                                        if($nomPhoto == $value){
                                            $html .= "<h4> Photo associee : </h4>";
                                            $html .= "<img src='Photos/$value' alt='Image' height='100' width='100'>";
                                            break;
                                        }
                                    }
                                }

                            }

                        }
                    }
                }
            }
            return $html;
        }
        /**
         * RENDER
         * @param int $select
         * @return string
         */
        public function render( int $select )
        {
            $html = <<<FIN
    <!DOCTYPE html>
    <html>
    <head>
        <title>Boissons</title>
        <link rel="stylesheet" href="css/boissons.css">
    </head>
    <body>
        <p></p>
FIN;


            switch ($select){
                case 0:
                    $ensembleNom = array_keys($this->tab[0]);
                    $nomAliment = end($ensembleNom);

                    $url_affichage =$this->container->router->pathFor("afficherInformation",['element' => $nomAliment]);
                    $html .= "<a href=$url_affichage>$nomAliment</a>" ;


                    break;
                case 1:
                    //Affiche Hierarchie
                    $html .= $this->afficherInformations($this->tab[0],$this->tab[1]);
                    //Affichage Recette
                    $html .= $this->afficherRecette($this->tab[2], $this->tab[1]);
                    break;
                default:
                    break;
            }
            $html .= <<<FIN
    </body>
    </html>
FIN;

            return $html;
        }
    }