<?php
declare(strict_types=1);

include('Donnees.inc.php');

session_start();

require 'vendor/autoload.php';
use boissons\controls\ControleurAccueil;
use boissons\controls\ControleurCompte;

$config = ['settings' => [
    'displayErrorDetails' => true,
]];

$db = new \Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('config/config.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$container = new \Slim\Container($config);
$app = new \Slim\App($container);

//Chemin Accueil
$app->get('/', ControleurAccueil::class.':accueil')->setName('racine');
$app->get('/afficher/{element}',ControleurAccueil::class.':afficherInformation')->setName('afficherInformation');
$app->get('/deconnexion/',ControleurCompte::class.':deconnexion')->setName('deconnexion');


//Chemin Compte
$app->get('/inscription/', ControleurCompte::class.':inscription')->setName('inscription');
$app->post('/inscription', ControleurCompte::class.':enregistrerInscription')->setName('enregistrerInscription');
$app->get('/connexion/', ControleurCompte::class.':connexion')->setName('connexion');
$app->post('/connexion', ControleurCompte::class.':testConnexion')->setName('testConnexion');
$app->get('/compte/', ControleurCompte::class.':afficherCompte')->setName('afficherCompte');
$app->get('/compte/modifier/', ControleurCompte::class.':modifierCompte')->setName('modifierCompte');
$app->get('/compte/changePassword/', ControleurCompte::class.':changerMotDePasse')->setName('changerMotDePasse');
$app->get('/supprimerCompte/', ControleurCompte::class.':supprimerCompte')->setName('supprimerCompte');
$app->post('/', ControleurCompte::class.':enregistrerModif')->setName('enregistrerModif');


$app->run();
