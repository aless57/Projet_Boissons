<?php


namespace boissons\controls;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use boissons\views\VueAccueil;



class ControleurAccueil {


    private $container;


    /**
     * ControleurAccueil constructor.
     * @param $container
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * GET
     * Affichage de l'accueil avec l'aliment "Aliment"
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function accueil(Request $rq, Response $rs, $args) : Response {
        include('Donnees.inc.php');
        $arrayHierarchie = array($Hierarchie, $Hierarchie['Aliment']);
        $vue = new VueAccueil($arrayHierarchie, $this->container);
        $rs->getBody()->write($vue->render(0));
        return $rs;
    }

    /**
     * Retourne les SuperAliments et les SousAliments des aliments en question
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherInformation(Request $rq, Response $rs, $args) : Response {
        include('Donnees.inc.php');
        $element = $args['element'];
        $element = str_replace("_"," ",$element);
        $elements = $Hierarchie[$element];
        $vue = new VueAccueil(array($elements,$element,$Recettes), $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

}