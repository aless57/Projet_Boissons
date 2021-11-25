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
</body>
</html>
FIN;
        switch ($select){
            case 0:

                break;
            default:
                break;
        }
        return $html;
    }
}