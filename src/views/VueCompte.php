<?php

namespace boissons\views;

class VueCompte
{
    private $tab;
    private $container;

    /**
     * VueCompte constructor.
     * @param $tab
     * @param $container
     */
    public function __construct($tab, $container){
        $this->tab = $tab;
        $this->container = $container;
    }

    /**
     * Formulaire d'inscription
     * @return string
     */
    private function formInscription() : string {
        // fonction pour enregistrer le formulaire
        $url_enregistrerInscription = $this->container->router->pathFor( 'enregistrerInscription' ) ;
        // proposition de redirection vers une connexion si on possède deja un compte
        $url_redirConnexion = $this->container->router->pathFor('connexion');
        $html = <<<FIN
        <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
                                    <div class="text-center">
                                        Inscrivez vous !
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="$url_enregistrerInscription">
                                            <div class="form-group">
                                                <label for="form_nom" >Nom</label>
                                                <input type="text" class="form-control" id="form_nom" placeholder="" name="nom" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_prenom" >Prénom</label>
                                                <input type="text" class="form-control" id="form_prenom" placeholder="" name="prenom" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_login" >Login</label>
                                                <input type="text" class="form-control" id="form_login" placeholder="" name="login" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_pass" >Mot de passe</label>
                                                <input type="password" class="form-control" id="form_pass" placeholder="" name="pass" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_mail" >Adresse mail</label>
                                                <input type="text" class="form-control" id="form_mail" placeholder="" name="mail" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_sexe" >Sexe</label>
                                                <select class="form-control" id="form_sexe" name="sexe">
                                                    <option value=""></option>
                                                    <option value="Homme">Homme</option>
                                                    <option value="Femme">Femme</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_naissance" >Date de naissance</label>
                                                <input type="date" class="form-control" id="form_naissance" placeholder="" name="naissance" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_adresse" >Adresse</label>
                                                <input type="text" class="form-control" id="form_adresse" placeholder="" name="adresse" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_postal" >Code postal</label>
                                                <input type="text" class="form-control" id="form_postal" placeholder="" name="postal" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_ville" >Ville</label>
                                                <input type="text" class="form-control" id="form_ville" placeholder="" name="ville" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_tel" >Téléphone</label>
                                                <input type="text" class="form-control" id="form_tel" placeholder="" name="tel" required>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary text-center">Enregistrer le compte</button>
                                            </div>
                                         
                                        </form>    
                                    </div>
                                    <div class="text-center" > 
                                        Déjà un compte ? <a href="$url_redirConnexion"> Se connecter </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        FIN;
        return $html;
    }

    /**
     * Formulaire de connexion
     * @return string
     */
    private function formConnexion() : string {
        // fonction pour envoyer le formulaire de connexion, et tester si id et mdp sont corrects
        $url_testConnexion = $this->container->router->pathFor( 'testConnexion' ) ;
        // redirection vers le formulaire d'inscription si on ne possède pas encore de compte
        $url_redirInscription = $this->container->router->pathFor('inscription');
        $html = <<<FIN
        <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
                                <div class="text-center">
                                    Connectez vous !
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="$url_testConnexion">
                                        <div class="form-group">
                                            <label for="form_login" >Login</label>
                                            <input type="text" class="form-control" id="form_login" placeholder="thomasRz" name="login" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="form_pass" >Mot de passe</label>
                                            <input type="password" class="form-control" id="form_nom" placeholder="Mot de passe" name="pass" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Se connecter</button>
                                        </div>
                                    </form> 
                                </div>
                                <div class="text-center" > 
                                    Pas encore de compte ? <a href="$url_redirInscription"> En créer un </a>
                                </div>
                            </div>   
                           </div>
                        </div>
                    </div>
                </div>
        FIN;
        return $html;
    }

    /**
     * Afficage des information du compte
     * @return string
     */
    public function afficherInformations() : string{
        $url_modifier = $this->container->router->pathFor('modifierCompte');
        $url_changemdp = $this->container->router->pathFor('changerMotDePasse');
        $url_deconnexion = $this->container->router->pathFor('deconnexion');
        $url_supprimerCompte = $this->container->router->pathFor('supprimerCompte');
        $url_afficherPanier = $this->container->router->pathFor('afficherPanier');
        $html = "";
        $nom = $this->tab['nom'];
        $prenom = $this->tab['prenom'];
        $login = $this->tab['login'];
        $email = $this->tab['mail'];
        $sexe = $this->tab['sexe'];
        $dateDeNaissance = $this->tab['naissance'];
        $adresse = $this->tab['adresse'];
        $codePostal = $this->tab['postal'];
        $ville = $this->tab['ville'];
        $telephone = $this->tab['tel'];
        $html = <<<FIN
            <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
                            <h3 class="text-center ">
                 Mes informations
            </h3>
                <form>
                    <div class="form-group row">
                        <label for="form_prenom" class="col-sm-2 col-form-label">   Prénom :</label>
                        <div class="col-sm-4">
                            <input readonly type="text" class="form-control" id="form_prenom" placeholder="{$prenom}" name="prenom" required>
                        </div>
                        <label for="form_nom" class="col-sm-2 col-form-label">   Nom :</label>
                        <div class="col-sm-4">
                            <input readonly type="text" class="form-control" id="form_nom" placeholder="{$nom}" name="nom" required>
                        </div>
                    </div>
                        
                    <div class="form-group row">
                        <label for="form_login" class="col-sm-2 col-form-label">Login :</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="form_login" placeholder="{$login}" name="login" required>
                        </div>
                    </div>
                    
                   <div class="form-group row">
                        <label for="form_login" class="col-sm-2 col-form-label">Email :</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="form_email" placeholder="{$email}" name="email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="form_login" class="col-sm-2 col-form-label">Sexe :</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="form_sexe" placeholder="{$sexe}" name="sexe" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="form_login" class="col-sm-2 col-form-label">Date de naissance :</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="form_DateDeNaissance" placeholder="{$dateDeNaissance}" name="dateDeNaissance" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="form_login" class="col-sm-2 col-form-label">Adresse :</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="form_adresse" placeholder="{$adresse}" name="adresse" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="form_login" class="col-sm-2 col-form-label">Code Postal :</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="form_codePostal" placeholder="{$codePostal}" name="codePostal" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="form_login" class="col-sm-2 col-form-label">Ville :</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="form_ville" placeholder="{$ville}" name="ville" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="form_login" class="col-sm-2 col-form-label">Telephone :</label>
                        <div class="col-sm-10">
                            <input readonly type="text" class="form-control" id="form_telephone" placeholder="{$telephone}" name="telephone" required>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <a type="submit" class="btn btn-primary" href="$url_modifier" role="button">Modifier mes informations</a>
                        <a type="submit" class="btn btn-warning" href="$url_changemdp" role="button">Changer mon mot de passe</a>
                    </div>
                    <br>
                    <div class="text-center deconnexion">
                         <a href='$url_deconnexion' class="btn btn-danger text-center">Déconnexion</a>  
                         <a href='$url_supprimerCompte' class="btn btn-dark text-center"> Suppression </a>
                    </div>
                    <br>
                    <div class="text-center">
                        <a type="submit" class="btn btn-primary" href="$url_afficherPanier" role="button">Afficher panier</a>
                    </div>
                
                </form> 
                </div>
                </div>
                </div>
                </div>
        
        FIN;
        return $html;
    }

    /**
     * Formulaire de modification des informations du compte
     * @return string
     */
    public function modifierInformations() {
        $url_enregistrerModif = $this->container->router->pathFor( 'enregistrerModif' ) ;
        $html = "";
        $nom = $this->tab['nom'];
        $prenom = $this->tab['prenom'];
        $login = $this->tab['login'];
        $mail = $this->tab['mail'];
        $sexe = $this->tab['sexe'];
        $dateDeNaissance = $this->tab['naissance'];
        $adresse = $this->tab['adresse'];
        $codePostal = $this->tab['postal'];
        $ville = $this->tab['ville'];
        $telephone = $this->tab['tel'];
        $html = <<<FIN
        
        <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
            <h3 class=" text-center">
                Modifiez vos informations !
            </h3>
                <form method="POST" action="$url_enregistrerModif">
                    <div class="form-group">
                        <label for="form_nom" >Nom</label>
                        <input type="text" class="form-control" id="form_nom" placeholder="$nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="form_prenom" >Prénom</label>
                        <input type="text" class="form-control" id="form_prenom" placeholder="$prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="form_login" >Login</label>
                        <input type="text" class="form-control" id="form_login" placeholder="$login" name="login" required>
                    </div>
                    <div class="form-group">
                        <label for="form_mail" >Adresse mail</label>
                        <input type="text" class="form-control" id="form_mail" placeholder="$mail" name="mail" required>
                    </div>
                    <div class="form-group">
                        <label for="form_sexe" >Sexe</label>
                        <select class="form-control" id="form_sexe" name="sexe" >
                            <option value=""></option>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="form_naissance" >Date de naissance</label>
                        <input type="date" class="form-control" id="form_naissance" placeholder="$dateDeNaissance" name="naissance" required>
                    </div>
                    <div class="form-group">
                        <label for="form_adresse" >Adresse</label>
                        <input type="text" class="form-control" id="form_adresse" placeholder="$adresse" name="adresse" required>
                    </div>
                    <div class="form-group">
                        <label for="form_postal" >Code postal</label>
                        <input type="text" class="form-control" id="form_postal" placeholder="$codePostal" name="postal" required>
                    </div>
                    <div class="form-group">
                        <label for="form_ville" >Ville</label>
                        <input type="text" class="form-control" id="form_ville" placeholder="$ville" name="ville" required>
                    </div>
                    <div class="form-group">
                        <label for="form_tel" >Téléphone</label>
                        <input type="text" class="form-control" id="form_tel" placeholder="$telephone" name="tel" required>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary text-center">Enregistrer le compte</button>
                    </div>
                </form> 
                </div>
                </div>
                </div>
                </div>
                </div>
        
        FIN;
        return $html;
    }

    /**
     * Formulaire de modification du mot de passe
     * @return string
     */
    public function changerMotDePasse() :string{
        $url_enregistrerMdp = $this->container->router->pathFor( 'enregistrerMotDePasse' ) ;
        $html = <<<FIN
        <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
            <h4 class=" text-center">
                Modifiez votre mot de passe
            </h4>
            <div class="card-body">
                <form method="POST" action="$url_enregistrerMdp">
                    <div class="form-group">
                        <label for="form_login" >Ancien mot de passe</label>
                        <input type="password" class="form-control" id="form_login" placeholder="Ancien mot de passe" name="ancienMDP" required>
                    </div>
                    <div class="form-group">
                        <label for="form_pass" >Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="form_nom" placeholder=" Nouveau mot de passe" name="nouveauMDP" required>
                    </div>
                    <div class="form-group">
                        <label for="form_pass" >Confirmez le mot de passe</label>
                        <input type="password" class="form-control" id="form_nom" placeholder="Nouveau mot de passe" name="confirmerMDP" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form> 
            </div>
            </div>
            </div>
        </div>   
        FIN;
        return $html;
    }

    public function afficherPanier(){
        $panierArray = $this->tab[0];
        $html = <<<FIN
            <div class="about-heading-content">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10 mx-auto">
                            <div class="bg-faded rounded p-5">
            <h3 class=" text-center">
                Panier
            </h3>
            FIN;
        $html .= "<section class='recette'> ";
        foreach ($panierArray as $panier){
            $html .= "<div class='form-group row'>";
            $html .= "<div class='col-sm flex-row'><p>" .  $panier['titre']. "</p> </div>";
            $url_suppression = $this->container->router->pathFor( 'supprimerPanier', ['id' => $panier['id']] );
            $html .= "<div class='col-sm-4'><a href='$url_suppression' class='btn btn-dark text-center'> Suppression </a></div>";
            $html .= "</div>";
        }
        $html .= <<<FIN
 </section> </div></div></div></div>
FIN;
        return $html;
    }

    /**
     * RENDER
     * @param int $select
     * @return string
     */
    public function render( int $select ) : string
    {
        $url_affichageHome = $this->container->router->pathFor("racine");
        $url_affichageAliment =$this->container->router->pathFor("afficherInformation",['element' => 'Aliment']);
        $url_connexion = $this->container->router->pathFor("connexion");
        $url_compte = $this->container->router->pathFor("afficherCompte");
        $url_recherche = $this->container->router->pathFor("recherche");

        $content = "";


        if (isset($_SESSION['profile']['username'])){
            // l'utilisateur est connecté
            $connecteOuNon = <<<FIN
                    <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="$url_compte">Mon Compte</a></li>
                    </ul>
                </div>
            </div>
        </nav>
FIN;
        }else{
            // l'utilisateur n'est pas connecté
            $connecteOuNon = <<<FIN
                    <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="$url_connexion">Connexion</a></li>
                    </ul>
                </div>
            </div>
        </nav>
FIN;
        }
        switch ($select) {
            //connexion echec: message d'erreur + réaffichage du formulaire de connexion
            case 0 :
            {
                $content .= "<div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i> Mot de passe incorrect !</div>";
            }
            //connexion: formulaire de connexion
            case 1 :
            {
                $path = "..";
                $content .= $this->formConnexion();
                break;
            }
            // inscription echec: message d'erreur + réaffichage du formulaire d'inscription
            case 2 :
            {
                $content .= "<div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i> Echec de l'inscription ! Ce login existe déjà</div>";
            }
            //inscription: formulaire d'inscription
            case 3 :
            {
                $path = "..";
                $content .= $this->formInscription();
                break;
            }
            //accès au compte apres inscription
            case 4 :
            {
                $content .= "<div class=\"alert alert-success\" role=\"alert\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i> Inscription réussie ! Login <b> {$this->tab['login']} </b> enregistré</div>";
            }
            //accès au compte apres connexion
            case 5 :
            {
                $path = "..";
                $content .= $this->afficherInformations();
                break;
            }
            // modification des info du compte
            case 6 :
            {
                $path = "../..";
                $pathIntermediaire = "<li class=\"breadcrumb-item \" aria-current=\"page\"><a href=\"$url_compte\">Espace personnel</a></li>";
                $content = $this->modifierInformations();
                break;
            }
            // modification succes
            case 7 :
            {
                $path = "..";
                $content = "<div class=\"alert alert-success\" role=\"alert\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i> Modifications enregistrées !</div>";
                $content .= $this->afficherInformations();
                break;
            }
            // modification echec login
            case 8 :
            {
                $path = "..";
                $content = "<div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i> Echec de la modification ! Le login existe déjà</div>";
                $content .= $this->afficherInformations();
                break;
            }
            // modication echec email
            case 9 :
            {
                $path = "..";
                $content = "<div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i> Echec de la modification ! L'email existe déjà</div>";
                $content .= $this->afficherInformations();
                break;
            }
            // modification mot de passe
            case 10 :
            {
                $path = "../..";
                $content .= $this->changerMotDePasse();
                break;
            }
            // modification mot de passe echec ancienMDP incorrect
            case 11 :
            {
                $path = "..";
                $content.= "<div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i> L'ancien mot de passe est incorrect !</div>";
                $content .= $this->changerMotDePasse();
                break;
            }
            // modification mot de passe echec confirmationMDP différent nouveauMDP
            case 12 :
            {
                $path = "..";
                $content = "<div class=\"alert alert-danger\" role=\"alert\"<i class=\"fa fa-times\" aria-hidden=\"true\"></i> >Les deux mots de passe sont différents !</div>";
                $content .= $this->changerMotDePasse();
                break;
            }
            // Ajout element panier
            case 13 :
            {
                $path = "../..";
                $content .= $this->afficherPanier();
                break;
            }
        }
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
        <link href="$path/css/styles.css" rel="stylesheet" />
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
                        <li class="nav-item px-lg-4"><a class="nav-link text-uppercase" href="$url_recherche">Recherche produit</a></li>           
FIN;
        $html .= $connecteOuNon;
        $html .= $content;
        $html .= <<<FIN
    </body>
    </html>
FIN;
        return $html;
    }
}