<?php

namespace boissons\controls;

use boissons\models\Utilisateur;
use boissons\views\VueAccueil;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use boissons\views\VueCompte;
use boissons\controls\Authentification;

class ControleurCompte
{
    private $container;
    private $today;

    /**
     * ControleurCompte constructor.
     * @param $container
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * GET
     * Affichage du formulaire pour création de compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function inscription(Request $rq, Response $rs, $args) : Response {
        $vue = new VueCompte( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render(3)) ;
        return $rs;
    }

    /**
     * POST
     * Enregistrement des informations du nouveau compte dans la base de données
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function enregistrerInscription(Request $rq, Response $rs, $args) : Response {
        $post = $rq->getParsedBody();
        $login = filter_var($post['login'] , FILTER_SANITIZE_STRING) ;
        $pass = filter_var($post['pass'] , FILTER_SANITIZE_STRING) ;
        $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $prenom = filter_var($post['prenom'], FILTER_SANITIZE_STRING);
        $sexe = filter_var($post['sexe'], FILTER_SANITIZE_STRING);
        $mail = filter_var($post['mail'], FILTER_SANITIZE_EMAIL);
        $naissance = filter_var($post['naissance'], FILTER_SANITIZE_STRING);
        $adresse = filter_var($post['adresse'], FILTER_SANITIZE_STRING);
        $postal = filter_var($post['postal'], FILTER_SANITIZE_STRING);
        $ville = filter_var($post['ville'], FILTER_SANITIZE_STRING);
        $tel = filter_var($post['tel'], FILTER_SANITIZE_STRING);
        $vue = new VueCompte( [ 'login' => $login ] , $this->container ) ;
        try {
            //redirection sur mon afficherCompte avec $_SESSION
            Authentification::createUser($nom, $prenom,$login, $pass, $sexe, $mail, $naissance, $adresse, $postal,$ville, $tel);
            Authentification::authenticate($login, $pass);
            $_SESSION['inscriptionOK'] = true;
            $url_accueil = $this->container->router->pathFor("racine");
            return $rs->withRedirect($url_accueil);
        }
        catch (Exception $e) {
            $rs->getBody()->write( $vue->render(2));
        }
        return $rs;
    }

    /**
     * GET
     * Affichage du formulaire de connexion
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function connexion(Request $rq, Response $rs, $args) : Response {
        if (isset($_SESSION['connexionOK'])){
            if(!$_SESSION['connexionOK']){
                $vue = new VueCompte([] , array($this->container)) ;
                $rs->getBody()->write( $vue->render(0));
                session_destroy();
                $_SESSION = [];
                return $rs;
            }
            //autre cas (avec les inscriptions)
        }else{
            $vue = new VueCompte([], $this->container);
            $rs->getBody()->write( $vue->render(1));
            return $rs;
        }
    }

    /**
     * POST
     * Test de la connexion
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function testConnexion(Request $rq, Response $rs, $args) : Response {
        $post = $rq->getParsedBody() ;
        $login = filter_var($post['login']       , FILTER_SANITIZE_STRING) ;
        $pass = filter_var($post['pass'] , FILTER_SANITIZE_STRING) ;
        $connexionOK = Authentification::authenticate($login, $pass);
        var_dump($connexionOK);
        if ($connexionOK){
            $url_compte = $this->container->router->pathFor("racine");
            //$_SESSION['profile'] = $login;
            return $rs->withRedirect($url_compte);
        }else{
            $_SESSION['connexionOK']=false;
            $url_connexion = $this->container->router->pathFor("connexion");
            return $rs->withRedirect($url_connexion);
        }
    }

    /**
     * GET
     * Affichage du compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherCompte(Request $rq, Response $rs, $args) : Response {
        $infosUser = Utilisateur::where('login','=',$_SESSION['profile']['username'])->first();
        $vue = new VueCompte($infosUser->toArray(), $this->container );
        if (isset($_SESSION['inscriptionOK'])) {
            if ($_SESSION['inscriptionOK']) {
                // on vient de s'inscrire
                $rs->getBody()->write( $vue->render(4));
                $info = $_SESSION['profile'];
                $_SESSION = [];
                $_SESSION['profile'] = $info;
                return $rs;
            }
            else {
                $rs->getBody()->write( $vue->render(5));
                return $rs;
            }
        }
        else if (isset($_SESSION['passwordOK'])) {
            if ($_SESSION['passwordOK']) {
                $info = $_SESSION['profile'];
                $_SESSION = [];
                $_SESSION['profile'] = $info;
                $vue = new VueCompte($infosUser->toArray(), $this->container);
                $rs->getBody()->write($vue->render(7));
                return $rs;
            } else {
                $info = $_SESSION['profile'];
                $_SESSION = [];
                $_SESSION['profile'] = $info;
                $vue = new VueCompte($infosUser->toArray(), $this->container);
                $rs->getBody()->write($vue->render(5));
                return $rs;
            }
        }
        else{
            $rs->getBody()->write($vue->render(5));
            return $rs;
        }

    }

    /**
     * POST
     * Enregistrement du nouveau mot de passe
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function enregistrerMotDePasse(Request $rq, Response $rs, $args) : Response {
        $infosUser = User::where('login','=',$_SESSION['profile']['username'])->first();
        $post = $rq->getParsedBody();
        $ancienMDP = filter_var($post['ancienMDP'], FILTER_SANITIZE_STRING);
        $nouveauMDP = filter_var($post['nouveauMDP'], FILTER_SANITIZE_STRING);
        $confirmerMDP = filter_var($post['confirmerMDP'], FILTER_SANITIZE_STRING);
        $mdpOK = Authentication::authenticate($_SESSION['profile']['username'], $ancienMDP);

        if (!$mdpOK) {
            $vue = new VueCompte( $infosUser->toArray() , $this->container ) ;
            $rs->getBody()->write($vue->render(11)) ;
            return $rs;
        }

        else {
            if ($nouveauMDP != $confirmerMDP) {
                $vue = new VueCompte( $infosUser->toArray() , $this->container ) ;
                $rs->getBody()->write($vue->render(12)) ;
                return $rs;
            }
            else {
                $infosUser->pass = password_hash($nouveauMDP, PASSWORD_DEFAULT);
                $infosUser->save();
                $_SESSION['passwordOK'] = true;
                $url_enregisterModif = $this->container->router->pathFor('enregistrerModif');
                return $rs->withRedirect($url_enregisterModif);
            }
        }

    }

    /**
     * POST
     * Enregistrement des nouvelles informations sur le compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function enregistrerModif(Request $rq, Response $rs, $args) : Response {
        $infoUser = User::where("id","=",$_SESSION['profile']['userid'])->first();
        $post = $rq->getParsedBody();
        $nouveauLogin = filter_var($post['login'], FILTER_SANITIZE_STRING);
        $nbNouveauLogin = User::where("login","=",$nouveauLogin)->count();
        $nouveauEmail = filter_var($post['mail']);
        $nbNouveauEmail = User::where("mail","=",$nouveauEmail)->count();
        $nouveauNom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
        $nouveauPrenom = filter_var($post['prenom'], FILTER_SANITIZE_STRING);
        if ($nbNouveauLogin > 0 && $nouveauLogin != $infoUser->login) {
            $vue = new VueCompte($infoUser->toArray(), $this->container);
            $rs->getBody()->write($vue->render(8));
            return $rs;
        }
        elseif ($nbNouveauEmail > 0 && $nouveauEmail != $infoUser->email) {
            $vue = new VueCompte($infoUser->toArray(), $this->container);
            $rs->getBody()->write($vue->render(9));
            return $rs;
        }
        else {
            $infoUser->nom = $nouveauNom;
            $infoUser->prenom = $nouveauPrenom;
            $infoUser->login = $nouveauLogin;
            $infoUser->email = $nouveauEmail;
            $infoUser->save();
            $vue = new VueCompte( $infoUser->toArray(), $this->container ) ;
            $_SESSION['profile']['username'] = $nouveauLogin;
            $rs->getBody()->write( $vue->render(7));
            return $rs;
        }
    }

    /**
     * GET
     * Affichage du formulaire de modification des informations du compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function modifierCompte(Request $rq, Response $rs, $args) : Response  {
        $infosUser = Utilisateur::where('login','=',$_SESSION['profile']['username'])->first();
        $vue = new VueCompte( $infosUser->toArray() , $this->container ) ;
        $rs->getBody()->write( $vue->render(6)) ;
        return $rs;
    }

    /**
     * GET
     * Affichage du formulaire de modification de mot de passe
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function changerMotDePasse (Request $rq, Response $rs, $args) : Response  {
        $infosUser = Utilisateur::where('login','=',$_SESSION['profile']['username'])->first();
        $vue = new VueCompte( $infosUser->toArray() , $this->container ) ;
        $rs->getBody()->write($vue->render(10));
        return $rs;
    }

    /**
     * GET
     * Deconnexion du compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function deconnexion(Request $rq, Response $rs, $args) : Response {
        session_destroy();
        $_SESSION = [];
        $url_accueil = $this->container->router->pathFor('connexion');
        return $rs->withRedirect($url_accueil);
    }

    /**
     * GET
     * Suppression du compte
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function supprimerCompte(Request $rq, Response $rs, $args) : Response {
        session_destroy();
        $listes = Liste::where('user_id','=',$_SESSION['profile']['userid'])->get();
        foreach ($listes as $liste) {
            $date = date('Y-m-d',strtotime($liste['expiration']));
            if ($this->today < $date) {
                $listeASupprimer = Liste::find($liste['no']);
                $items = Item::where('liste_id','=',$liste['no'])->get();
                foreach ($items as $item) {
                    $itemASupprimer = Item::find($item['id']);
                    $messages = Message::where('id_parent','=',$item['id'])->where('type_parent','=','item')->get();
                    foreach ($messages as $message) {
                        $messageASupprimer = Message::find($message['id_message']);
                        $messageASupprimer->delete();
                    }
                    $itemASupprimer->delete();
                }
                $messages = Message::where('id_parent','=',$liste['no'])->where('type_parent','=','liste')->get();
                foreach ($messages as $message) {
                    $messageASupprimer = Message::find($message['id_message']);
                    $messageASupprimer->delete();
                }
                $listeASupprimer->delete();
            }
        }
        $user = User::find($_SESSION['profile']['userid']);
        $user->delete();
        setcookie("user_id", '-1', time() + 60*60*24*30, "/" );
        session_destroy();
        $_SESSION = [];
        $url_accueil = $this->container->router->pathFor('racine');
        $vue = new VueCompte( [], $this->container);
        return $rs->withRedirect($url_accueil);

    }
}