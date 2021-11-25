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
     * Affichage de l'accueil
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function accueil(Request $rq, Response $rs, $args) : Response {
        $vue = new VueAccueil(array(), $this->container);
        $rs->getBody()->write($vue->render(0));
        return $rs;
    }

}