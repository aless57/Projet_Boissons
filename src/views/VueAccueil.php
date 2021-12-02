<?php


namespace boissons\views;

use boissons\controls\ControleurAccueil;

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

    public function afficherInformations($arrayHierarchie) : string{
        $html = "";
        foreach ($arrayHierarchie as $value){
            $html .= <<<FIN

FIN;

        }

        return '';
    }
    /**
     * RENDER
     * @param int $select
     * @return string
     */
    public function render( int $select ) : string
    {
        $html = <<<FIN
<!DOCTYPE html>
<html>
<head>
    <title>Boissons</title>
    <link rel="stylesheet" href="css/boissons.css">
</head>
<body>
    <p>YOOOOO</p>
FIN;

        var_dump($this->tab[1]);
        switch ($select){
            case 0:

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