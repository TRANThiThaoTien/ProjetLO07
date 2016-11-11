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
        <script type="text/javascript">
            function confirmer() {
                return confirm("Cet article va être supprimé");
            }
            function confirmer2() {
                return confirm("Ce compte va être supprimé");
            }
        </script>
        <style>
            td{
                text-align: center;
            }
        </style>
    </head>
    <?php
    if (isset($_POST['supprimer_article'])) {
        require_once '../php_sql_action.php';
        $action = new DB_driver();
        $where = 'id=' . $_POST['id_article'];
        $action->remove('articles', $where);
    }
    if (isset($_POST['supprimer_utilisateur'])) {
        require_once '../php_sql_action.php';
        $action = new DB_driver();
        $data = array('login' => '',
            'password' => '');
        $where = 'id=' . $_POST['id_utilisateur'];
        $action->update('utilisateurs', $data, $where);
    }
    if (isset($_POST["publier_article"])) {
        require_once '../php_sql_action.php';
        $action = new DB_driver();
        $data = array('etat' => 'Publié');
        $where = 'id=' . $_POST['id_article'];
        $action->update('articles', $data, $where);
    }
    ?>
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
                                            ?>
                                            <li><a href="../accueil/index.php?id_auteur=<?php echo $_SESSION['id_connexion']; ?>">
                                                    <span id='admin' title='<?php echo $ligne['nom'] . ' ' . $ligne['prenom'] . ' - ' . $ligne['laboratoire'] . ' (' . $ligne['level_utilisateur'] . ')'; ?>' class="glyphicon glyphicon-user connect" aria-hidden="true"> 
                                                        <?php echo $ligne['nom'] . ' ' . $ligne['prenom']; ?>
                                                    </span>
                                                </a></li>
                                            <?php
                                            echo "<li>&nbsp;&nbsp;</li>"
                                            ?>
                                            <li><button class="btn btn-danger navbar-btn" id="deconnexion">Déconnexion</button></li>

                                            <?php
                                        };
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <script language="javascript" src="../accueil/connecter_deconnecter.js"></script>
                        </div>    
                    </div>  
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
                        <a href='../accueil/index.php'><button id="accueil" type="button" class=" active btn btn-lg btn-default "><span  style="color: #3498DB; font-weight: bold; " class="glyphicon glyphicon-home" aria-hidden="true"> Accueil</span></button></a>
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
        <div class="container">
            <div class='row'>   
                <p style="border-top: solid; border-color: #ddd; line-height:15px;"></p>
                <div class='col-md-3' style="height:1000px;">
                    <table style=" border: solid 1px #ddd;">
                        <tr style="background: #3E454C;"><th><h4 class="text-center" style="color: #ECF0F1;">GESTION</h4></th></tr>
                        <tr>
                            <td style="text-align:left;">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="active" id="articles"><a href="admin.php"  >La liste d'articles</a></li>
                                    <li id="auteurs"><a href="?auteurs">La liste des auteurs</a></li>
                                    <li id="utilisateurs"><a href="?utilisateurs">La liste d'utilisateurs</a></li>
                                    <li id="article_deux_fois"><a href="?article_deux_fois">Les articles ont même titre</a></li>
                                    <li id="mem_auteurs"><a href="?mem_auteurs">Les articles avec deux fois auteurs</a></li>
                                    <li id="aucun_utt"><a href="?aucun_utt">Les articles n'a aucune auteur de l'UTT</a></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <div  id="contenu" class='col-md-9'>

                    <?php
                    if (isset($_POST['supprimer_article'])) {
                        echo '<script language="javascript"> alert("SUPPRIMER L\'ARTICLE SUCCÈS!");</script>';
                    };
                    if (isset($_POST["publier_article"])) {
                        echo '<script language="javascript"> alert("PUBLIER L\'ARTICLE SUCCÈS!");</script>';
                    };
                    if (isset($_POST['supprimer_utilisateur'])) {
                        echo '<script language="javascript"> alert("SUPPRIMER L\'UTILISATEUR SUCCÈS!");</script>';
                    }


                    if (isset($_REQUEST['utilisateurs'])) {
                        require 'liste_utilisateurs.php';
                    } elseif (isset($_REQUEST['auteurs'])) {
                        require 'liste_auteurs.php';
                    } elseif (isset($_REQUEST['article_deux_fois'])) {
                        require 'article_deux_fois.php';
                    } elseif (isset($_REQUEST['mem_auteurs'])) {
                        require 'meme_auteur.php';
                    } elseif (isset($_REQUEST['aucun_utt'])) {
                        require 'aucun_chercheur_utt.php';
                    } else {
                        require 'liste_articles.php';
                    }
                    ?>

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
        <script src="../Js/jquery-2.0.0.min.js"></script>
        <script src="../Js/bootstrap.min.js"></script>
        <script language="javascript" src="../js/jquery-ui.js"></script>
        <script language="javascript">
            $("#CF").tooltip();
            $("#RI").tooltip();
            $("#CI").tooltip();
            $("#RF").tooltip();
            $("#OS").tooltip();
            $("#TD").tooltip();
            $("#BV").tooltip();
            $("#AP").tooltip();
            $("#admin").tooltip({
                placement: "bottom"
            });
        </script>
    </body>
</html>


