<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LES PUBLICATION</title>
        <link href="../Css/bootstrap.min.css" rel="stylesheet">
        <link href="../style.css" rel="stylesheet">
        <script language="javascript" src="../js/jquery-2.0.0.min.js"></script>
        <link rel="stylesheet" href="../jquery-ui.css"> 
    </head>
    <body >
        <div class="container" style='background: #FFFFFF; height:210px;'>
            <div class='row'>
                <div class="header">
                    <div class='navbar navbar-inverse' style="background-color: #272F32;"> 
                        <div class='navbar-header'>
                            <a href='../accueil/index.php' class='navbar-brand'>ICD</a>
                        </div>  
                        <div class='navbar-collapse collapse' id="menu">
                            <form method="get" action="../rechercher/recherche.php" class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="rc_titre" id="rc_titre" placeholder="Titre de l'article">
                                </div>
                                <input type="submit" class="btn btn-default" name="submit_tous_article" value="Rechecher">
                            </form>
                            <ul class='nav navbar-nav'>
                                <li><a href='../rechercher/recherche.php'><i>(Avancée)</i></a></li>
                            </ul>
                            <div id="connexion" class="navbar-right">
                                <div class='navbar-collapse collapse' >
                                    <ul class='nav navbar-nav'>
                                        <?php
                                        session_start();
                                        if (isset($_SESSION['id_connexion'])) {
                                            require_once '../php_sql_action.php';
                                            $action = new DB_driver();
                                            $sql = 'select * from utilisateurs where id="' . $_SESSION['id_connexion'] . '";';
                                            $ligne = $action->get_row($sql);
                                            if ($ligne["level_utilisateur"] == "utilisateur") {
                                                ?>
                                                <li>
                                                    <a href="../accueil/index.php?id_auteur=<?php echo $_SESSION['id_connexion']; ?>">
                                                        <span id='user' title='<?php echo $ligne['nom'] . ' ' . $ligne['prenom'] . ' - ' . $ligne['laboratoire'] . ' (' . $ligne['level_utilisateur'] . ')'; ?>' class="glyphicon glyphicon-user connect" aria-hidden="true"> 
                                                            <?php echo $ligne['nom'] . ' ' . $ligne['prenom']; ?>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li><form method="GET" action="../accueil/index.php" ><input type = "submit" class="btn btn-primary navbar-btn" id="publier" value="Publier">
                                                        <input type="hidden" name="ajouter_article" value="a"></form></li>
                                                <?php ?>

                                                <?php
                                            } elseif ($ligne["level_utilisateur"] == "admin") {
                                                ?>
                                                <li>
                                                    <a href="../accueil/index.php?id_auteur=<?php echo $_SESSION['id_connexion']; ?>" >
                                                        <span id='admin' title='<?php echo $ligne['nom'] . ' ' . $ligne['prenom'] . ' - ' . $ligne['laboratoire'] . ' (' . $ligne['level_utilisateur'] . ')'; ?>' class="glyphicon glyphicon-user connect" aria-hidden="true"> 
                                                            <?php echo $ligne['nom'] . ' ' . $ligne['prenom']; ?>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li><form action="../gestion_admin/admin.php"><input type = "submit" class="btn btn-info navbar-btn" value="Gestion de l'admin"></form></li>
                                                <?php
                                            }
                                            echo "<li>&nbsp;&nbsp;</li>"
                                            ?>
                                            <li><button class="btn btn-danger navbar-btn" id="deconnexion">Déconnexion</button></li>
                                            <?php
                                        } else {
                                            ?>
                                            <li><button id="inscrire_c" class="btn btn-info navbar-btn" data-toggle="modal" data-target="#myModal2"  >S'inscrire</button></li>
                                            <li><?php echo '&nbsp;&nbsp;'; ?></li>
                                            <li><button class="btn btn-info navbar-btn" data-toggle="modal" data-target="#myModal">Connexion</button></li>
                                            <?php
                                        };
                                        //echo "<li>&nbsp;&</li>"
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>    
                    </div>  
                    <div class="clearfix"></div>
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Connexion</h4>
                                </div>
                                <div class="modal-body">
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <form class='form-inline'>
                                                <div class='form-group'>
                                                    <label class='sr-only'>L'identifiant</label>
                                                    <input id="login_connexion" type='text' class='form-control' placeholder="L'identifiant" name='login' tabindex='1'>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='sr-only'>Mot de passe</label>
                                                    <input id="mdp_connexion" type='password' class='form-control' placeholder='Mot de passe' name='mdp' tabindex='2'>
                                                </div>
                                                <input class='btn btn-primary' id="connecter" type="button" value='Je me connecte' tabindex='3' >
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-danger hide"></div>
                                <div class="alert alert-success hide"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link navbar-left" data-toggle="modal" data-target="#myModal2"  ><i>S'inscrire un nouvel compte</i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script language="javascript" src="../accueil/connecter_deconnecter.js"></script>
                    <div id="myModal2" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Création d'un nouveau compte</h4>
                                </div>
                                <div class="modal-body">
                                    <div class='row'>
                                        <div class='col-md-12'>
                                            <?php require_once '../accueil/form_inscrire.php' ?>
                                        </div>
                                    </div>
                                </div>
                                <div id ='succes' class="alert alert-success hide"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script language="javascript" src="../inscrire/verifier_inscrire.js"></script>
                </div>
                <div class="breadcrumb" >
                    <h1 class='text-center' >Institut Charles Delaunay</h1>
                    <p class='text-center liste'>(Université de Technologie de Troyes)</p>
                </div>
            </div>
        </div>
        <div class="container" style='background: #FFFFFF;'>
            <div class='row'>
                <div class="btn-group btn-group-justified" role="group" aria-label="..">
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php'><button id="accueil" type="button" class=" btn btn-lg btn-default "><span  style="color: #3498DB; font-weight: bold; " class="glyphicon glyphicon-home" aria-hidden="true"> Accueil</span></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php?categorie=CF'><button id="CF" type="button" title="Article dans des Conférences Françaises" class="btn btn-lg btn-default"><span class="cat">CF</span></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php?categorie=RI'><button id="RI" type="button" class="btn btn-lg btn-default" title="Article dans des Revues Internationales"><span class="cat">RI</span></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php?categorie=CI'><button id="CI" type="button" class="btn btn-lg btn-default" title="Article dans des Conférences Internationales" ><span class="cat">CI</span></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php?categorie=RF'><button id="RF" type="button" class="btn btn-lg btn-default" title="Article dans des Revues Françaises"><span class="cat">RF</span></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php?categorie=OS'><button id="OS" type="button" class="btn btn-lg btn-default" title='Ouvrage Scientifique'><span class="cat">OS</span></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php?categorie=TD'><button id="TD" type="button" class="btn btn-lg btn-default" title="Thèse de Doctorat"><span class="cat">TD</span></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php?categorie=BV'><button id="BV" type="button" class="btn btn-lg btn-default" title='Brevet'><span class="cat">BV</span></button></a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href='../accueil/index.php?categorie=AP'><button id="AP" type="button" class="btn btn-lg btn-default" title="Autre Production"><span class="cat">AP</span></button></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style='background: #FFFFFF;'>
            <div class='row'>
                <p style="border-top: solid; border-color: #ddd; line-height:15px;"></p>
                <div class='col-md-3' style="height:1000px;">
                    <table style=" border: solid 1px #ddd;">
                        <tr style="background: #3E454C;"><th><h4 class="text-center" style="color: #ECF0F1;">RECHERCHER</h4></th></tr>
                        <tr>
                            <td>
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="active"><a  id="tous_articles" href="#">Rechercher l'articles par titre</a></li>
                                    <li ><a id='cher2' href="#">Rechercher par Laboratoire</a></li>
                                    <li><a  id='cher3' href="#">Rechercher publication par auteur</a></li>
                                    <li ><a id='cher4' href="#">Rechercher collaborations de l'auteur</a></li>
                                    <li ><a id='cher5' href="#">Rechercher Co-auteur</a></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <div  id="contenu_recher" class='col-md-6'>
                    <?php
                    require_once '../rechercher/action.php';
                    ?>
                </div>
                <div class='col-md-3 breadcrumb ' style="height:100%;" >
                    <table width="100%" class="table" >    <?php //data-spy ="affix" data-offset-top="200"                                    ?>
                        <thead>
                            <tr style= "background-color:#3E454C;">
                                <th class="text-center" style="font-size: 1.3em;font-weight: bold; color: #ECF0F1;" >Les articles recents</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once '../php_sql_action.php';
                            $sql = "select * from articles order by temps desc; ";
                            $action = new DB_driver();
                            $liste_articles = $action->get_list($sql);
                            $i = 0;
                            $syntaxe = '';
                            foreach ($liste_articles as $elem) {
                                if ($elem['etat'] == 'Publié') {
                                    $i = $i + 1;
                                    if ($i == 1) {
                                        $syntaxe .= '<tr><td><div class="row">'
                                                . '<div><p class="titre_recent" style="text-align: justify;"><a href="../accueil/index.php?id_article=' . $elem['id'] . '">' . $elem['titre'] . '</a></p></div>'
                                                . '<div class="clearfix"></div>'
                                                . '<div><a href="../accueil/index.php?id_article=' . $elem['id'] . '"><img class="img-thumbnail img-responsive"   src="../images/' . $elem['photo'] . '"/></a></div>'
                                                . '<div class="clearfix"></div> <br/>'
                                                . '<div style="text-align: justify;">' . substr($elem["resume"], 0, 100) . '...</div>'
                                                . '</div></td></tr>';
                                        continue;
                                    }
                                    $syntaxe .= '<tr><td style="color:#E74C3C;"><p class="liste" style="text-align: justify;"><a href="../accueil/index.php?id_article=' . $elem['id'] . '">' . $elem['titre'] . '</a></p></td></tr>';
                                    if ($i == 12) {
                                        break;
                                    };
                                }
                            }
                            echo $syntaxe;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="container">
            <div class='row'>
                <div id="footer">
                    <p style="color: #FFFFFF;">Les publications des chercheurs de l'Université de Technologie de Troyes</p>
                    <p style="color: #FFFFFF;">Copyright by LE Van Phuc - TRAN Thi Thao Tien</p>
                </div>
            </div>
        </div>
        <script language='javascript' src="../rechercher/javascrip_rechercher.js">
        </script>
        <script src="../Js/jquery-2.0.0.min.js"></script>
        <script src="../Js/bootstrap.min.js"></script>
        <script language="javascript" src="../js/jquery-ui.js"></script>
    </body>
</html>













