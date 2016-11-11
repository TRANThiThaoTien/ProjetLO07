
<html>
    <head>
        <meta charset="UTF-8">
        <title>L'executation de la fonction de rechercher</title>
        <link href="../Css/bootstrap.min.css" rel="stylesheet">
        <link href="../style.css" rel="stylesheet">
        <script language="javascript" src="../js/jquery-2.0.0.min.js"></script>
    </head>
    <body>
        <?php
        $categories = array("RI" => "Article dans des Revues Internationales",
            "CI" => "Article dans des Conférences Internationales",
            "RF" => "Article dans des Revues Françaises",
            "CF" => "Article dans des Conférences Françaises",
            "OS" => "Ouvrage Scientifique (Chapitre de Livre, ...)",
            "TD" => "Thèse de Doctorat",
            "BV" => "Brevet",
            "AP" => "Autre Production");

        require_once '../php_sql_action.php';
        $action = new DB_driver();
        if (isset($_GET['submit_tous_article'])) {
            ?>
            <script language="javascript">
                document.getElementById("tous_articles").parentNode.setAttribute("class", "active");
                document.getElementById("cher2").parentNode.removeAttribute("class", "active");
                document.getElementById("cher3").parentNode.removeAttribute("class", "active");
                document.getElementById("cher4").parentNode.removeAttribute("class", "active");
                document.getElementById("cher5").parentNode.removeAttribute("class", "active");
                document.getElementById("cher6").parentNode.removeAttribute("class", "active");
            </script>
            <?php
            $sql = 'SELECT * from articles where titre like "%' . trim($_GET['rc_titre']) . '%" order by categorie desc, annee desc';
            $array_ligne = $action->get_list($sql);
            $nombre = $action->nombre_row($sql);
            $syntaxe = '';
            $k = 0;
            if ($nombre != 0) {
                $syntaxe .='<table class="table table-condensed">';
                foreach ($array_ligne as $ligne) {
                    if ($ligne['etat'] == 'Publié') {
                        $k = $k + 1;
                        if ($k == 1) {
                            $categorie = $categories[$ligne['categorie']];
                            $syntaxe .="<tr><td><p style='font-size:1.6em'><b>$categorie</b></td></td></tr>";
                        }
                        if ($k != 1 && $categories[$ligne['categorie']] != $categorie) {
                            $categorie = $categories[$ligne['categorie']];
                            $syntaxe .="<tr><td><p style='font-size:1.6em'><b>$categorie</b></td></td></tr>";
                        }
                        $liste_array = explode(',', $ligne['liste_id_auteurs']);
                        $liste_auteurs = array();
                        $auteurs = '';
                        foreach ($liste_array as $elem) {
                            $row = $action->get_row("select * from utilisateurs where id='$elem'");
                            $auteurs .='<i><a href="../accueil/index.php?id_auteur=' . $elem . '">' . $row['nom'] . ' ' . $row['prenom'] . '</a></i>';
                            $auteurs .=',';
                        };
                        $auteurs = trim($auteurs, ',');
                        $row = $action->get_row('select id from articles where titre="' . $ligne['titre'] . '"');
                        $id_article = $row['id'];
                        $syntaxe .= '<tr>'
                                . '<td>'
                                . '<p style="font-size:1.2em"><a href="../accueil/index.php?id_article=' . $id_article . '">' . $ligne["titre"] . '</a></p>'
                                . '<p><b><i>Les auteurs: </i></b>' . $auteurs . '</p>'
                                . '<p><b><i>Année: </i></b>' . $ligne["annee"] . '</p>';
                        if ($ligne['resume'] != '') {
                            $syntaxe .='<p><b>Résumé:</b> ' . substr($ligne["resume"], 0, 360) . '</p>';
                        }
                        $syntaxe .= '</td>'
                                . '</tr>';
                    }
                };
                $syntaxe .='</table>';
                echo $syntaxe;
                if ($k == 0) {
                    echo"<p class='annoncer'>Il n'y a aucune article!</p>";
                }
            } else {
                echo"<p class='annoncer'>Il n'y a aucune article!</p>";
            };
        } elseif (isset($_GET['submit_rc_laboratoire'])) {
            ?>
            <script language="javascript">
                document.getElementById("cher2").parentNode.setAttribute("class", "active");
                document.getElementById("tous_articles").parentNode.removeAttribute("class", "active");
                document.getElementById("cher3").parentNode.removeAttribute("class", "active");
                document.getElementById("cher4").parentNode.removeAttribute("class", "active");
                document.getElementById("cher5").parentNode.removeAttribute("class", "active");
                document.getElementById("cher6").parentNode.removeAttribute("class", "active");
            </script>
            <?php
            $labor = trim($_GET['lab']);
            $annee = trim($_GET['year']);
            $sql = "SELECT id from utilisateurs WHERE laboratoire= '$labor'";
            $liste_id_labo = $action->get_list($sql);
            $array_id_labo = array();
            foreach ($liste_id_labo as $id1) {
                $array_id_labo[] = $id1['id'];
            }
            if ($_GET['year'] != '') {
                $sql2 = "SELECT * from articles where annee >=" . $annee . " order by categorie desc, annee desc";
            } else {
                $sql2 = "SELECT * from articles order by categorie desc, annee desc";
            }
            $les_articles = $action->get_list($sql2);
            $syntaxe = '';
            $syntaxe .='<table class="table table-condensed">';
            $k = 0;
            foreach ($les_articles as $ligne) {
                $array_id_auteurs = explode(',', $ligne['liste_id_auteurs']);
                $test = false;
                foreach ($array_id_auteurs as $elem) {
                    if (in_array($elem, $array_id_labo)) {
                        $test = true;
                        break;
                    }
                }
                if ($test == true && $ligne['etat'] == 'Publié') {
                    $k = $k + 1;
                    if ($k == 1) {
                        $categorie = $categories[$ligne['categorie']];
                        $syntaxe .="<tr><td><p style='font-size:1.2em'><b>$categorie</b></td></td></tr>";
                    }
                    if ($k != 1 && $categories[$ligne['categorie']] != $categorie) {
                        $categorie = $categories[$ligne['categorie']];
                        $syntaxe .="<tr><td><p style='font-size:1.2em'><b>$categorie</b></td></td></tr>";
                    }
                    $liste_array = explode(',', $ligne['liste_id_auteurs']);
                    $liste_auteurs = array();
                    $auteurs = '';
                    foreach ($liste_array as $elem) {
                        $row = $action->get_row("select * from utilisateurs where id='$elem'");
                        $auteurs .='<i><a href="../accueil/index.php?id_auteur=' . $elem . '">' . $row['nom'] . ' ' . $row['prenom'] . '</a></i>';
                        $auteurs .=',';
                    };
                    $auteurs = trim($auteurs, ',');
                    $id_article = $ligne['id'];
                    $syntaxe .= '<tr>'
                            . '<td>'
                            . '<p style="font-size:1.2em"><a href="../accueil/index.php?id_article=' . $id_article . '">' . $ligne["titre"] . '</a></p>'
                            . '<p><b><i>Les auteurs: </i></b>' . $auteurs . '</p>'
                            . '<p><b><i>Année: </i></b>' . $ligne["annee"] . '</p>';
                    if ($ligne['resume'] != '') {
                        $syntaxe .='<p><b>Résumé:</b> ' . substr($ligne["resume"], 0, 360) . '...</p>';
                    }
                    $syntaxe .= '</td>'
                            . '</tr>';
                }
            }
            $syntaxe .='</table>';
            echo $syntaxe;
            if ($k == 0) {
                echo"<p class='annoncer'>Il n'y a aucune article!</p>";
            }
        } elseif (isset($_GET['submit_rc_auteur'])) {
            ?>
            <script language="javascript">
                document.getElementById("tous_articles").parentNode.removeAttribute("class", "active");
                document.getElementById("cher2").parentNode.removeAttribute("class", "active");
                document.getElementById("cher3").parentNode.setAttribute("class", "active");
                document.getElementById("cher4").parentNode.removeAttribute("class", "active");
                document.getElementById("cher5").parentNode.removeAttribute("class", "active");
                document.getElementById("cher6").parentNode.removeAttribute("class", "active");
            </script>
            <?php
            $nomsaisir = trim($_GET['saisirnom']);
            $prenomsaisir = trim($_GET['saisirprenom']);
            if ($nomsaisir != '' || $prenomsaisir != '') {
                if ($nomsaisir == '') {
                    $sql = "SELECT * from utilisateurs WHERE prenom ='$prenomsaisir' ";
                } elseif ($prenomsaisir == '') {
                    $sql = "SELECT * from utilisateurs WHERE nom ='$nomsaisir' ";
                } else {
                    $sql = "SELECT * from utilisateurs WHERE nom ='$nomsaisir' && prenom ='$prenomsaisir' ";
                }
                $nombre2 = $action->nombre_row($sql);
                if ($nombre2 == 0) {
                    echo'Personne n\'existe';
                } else {
                    $array_id1 = $action->get_list($sql);
                    $array_id_auteur = array();
                    foreach ($array_id1 as $id1) {
                        $array_id_auteur[] = $id1['id'];
                    }
                    $sql2 = "SELECT * from articles order by categorie desc, annee desc";
                    $les_articles = $action->get_list($sql2);
                    $syntaxe = '';
                    $syntaxe .='<table class="table table-condensed">';
                    $k = 0;
                    foreach ($les_articles as $ligne) {
                        $array_id_auteurs = explode(',', $ligne['liste_id_auteurs']);
                        $test = false;
                        foreach ($array_id_auteurs as $elem) {
                            if (in_array($elem, $array_id_auteur)) {
                                $test = true;
                                break;
                            }
                        }
                        if ($test == true && $ligne['etat'] == 'Publié') {
                            $k = $k + 1;
                            if ($k == 1) {
                                $categorie = $categories[$ligne['categorie']];
                                $syntaxe .="<tr><td><p style='font-size:1.2em'><b>$categorie</b></td></td></tr>";
                            }
                            if ($k != 1 && $categories[$ligne['categorie']] != $categorie) {
                                $categorie = $categories[$ligne['categorie']];
                                $syntaxe .="<tr><td><p style='font-size:1.2em'><b>$categorie</b></td></td></tr>";
                            }
                            $liste_array = explode(',', $ligne['liste_id_auteurs']);
                            $liste_auteurs = array();
                            $auteurs = '';
                            foreach ($liste_array as $elem) {
                                $row = $action->get_row("select * from utilisateurs where id='$elem'");
                                $auteurs .='<i><a href="../accueil/index.php?id_auteur=' . $elem . '">' . $row['nom'] . ' ' . $row['prenom'] . '</a></i>';
                                $auteurs .=',';
                            };
                            $auteurs = trim($auteurs, ',');
                            $id_article = $ligne['id'];
                            $syntaxe .= '<tr>'
                                    . '<td>'
                                    . '<p style="font-size:1.2em"><a href="../accueil/index.php?id_article=' . $id_article . '">' . $ligne["titre"] . '</a></p>'
                                    . '<p><b><i>Les auteurs: </i></b>' . $auteurs . '</p>'
                                    . '<p><b><i>Année: </i></b>' . $ligne["annee"] . '</p>';
                            if ($ligne['resume'] != '') {
                                $syntaxe .='<p><b>Résumé:</b> ' . substr($ligne["resume"], 0, 360) . '...</p>';
                            }
                            $syntaxe .= '</td>'
                                    . '</tr>';
                        }
                    }
                    $syntaxe .='</table>';
                    echo $syntaxe;
                    if ($k == 0) {
                        echo"<p class='annoncer'>Il n'y a aucune article!</p>";
                    }
                }
            }
        } elseif (isset($_GET['submit_collaboration'])) {
            ?>
            <script language="javascript">
                document.getElementById("tous_articles").parentNode.removeAttribute("class", "active");
                document.getElementById("cher2").parentNode.removeAttribute("class", "active");
                document.getElementById("cher3").parentNode.removeAttribute("class", "active");
                document.getElementById("cher4").parentNode.setAttribute("class", "active");
                document.getElementById("cher5").parentNode.removeAttribute("class", "active");
                document.getElementById("cher6").parentNode.removeAttribute("class", "active");
            </script>
            <?php
            $id_auteur = $_GET['id_auteur_rc'];
            $action = new DB_driver();
            $sql3 = "select * from utilisateurs where id='$id_auteur'";
            $auteur = $action->get_row($sql3);
            echo '<h3>La liste des collaborations du chercheur ' . $auteur['nom'] . ' ' . $auteur['prenom'] . '-' . $auteur['laboratoire'] . '-UTT :</h3>';
            $sql = "select * from articles where etat='Publié'";
            $liste_article = $action->get_list($sql);
            $array_collaboration = array();
            $test = false;
            foreach ($liste_article as $value) {
                $array_id_auteurs = explode(',', $value['liste_id_auteurs']);
                if (in_array($id_auteur, $array_id_auteurs)) {
                    $k = 0;
                    foreach ($array_id_auteurs as $elem) {
                        $sql2 = "select * from utilisateurs where id='$elem'";
                        if ($action->nombre_row($sql2) != 0) {
                            $auteur_col = $action->get_row($sql2);
                            if (strtoupper($auteur_col['organisation']) != 'UTT' && !in_array(strtoupper($auteur_col['organisation']), $array_collaboration)) {
                                $array_collaboration[] = strtoupper($auteur_col['organisation']);
                                ++$k;
                            }
                        }
                    }
                    if ($k != 0) {
                        $test = true;
                        echo '<p style="font-size:1.2em">' . implode(', ', $array_collaboration) . '</p>';
                        echo '<p><b>Par article :</b> <a href="../accueil/index.php?id_article=' . $value['id'] . '">' . $value['titre'] . '</a></p>';
                    };
                }
            }
            if ($test == false) {
                echo '<p><i>Il n\'a pas de collaboration</i></p>';
            }
        } elseif (isset($_GET['submit_coauteur'])) {
            ?>
            <script language="javascript">
                document.getElementById("tous_articles").parentNode.removeAttribute("class", "active");
                document.getElementById("cher2").parentNode.removeAttribute("class", "active");
                document.getElementById("cher3").parentNode.removeAttribute("class", "active");
                document.getElementById("cher4").parentNode.removeAttribute("class", "active");
                document.getElementById("cher5").parentNode.setAttribute("class", "active");
                document.getElementById("cher6").parentNode.removeAttribute("class", "active");
            </script>
            <?php
            $id_auteur = $_GET['id_auteur_rc'];
            $action = new DB_driver();
            $sql3 = "select * from utilisateurs where id='$id_auteur'";
            $auteur = $action->get_row($sql3);
            echo '<h3>La liste des co-auteurs du chercheur ' . $auteur['nom'] . ' ' . $auteur['prenom'] . ' - ' . $auteur['laboratoire'] . ' - '.$auteur['organisation'] .' : </h3>';
            $sql = "select * from articles where etat='Publié'";
            $liste_article = $action->get_list($sql);
            $array_id_coauteur = array();
            foreach ($liste_article as $value) {
                $array_id_auteurs = explode(',', $value['liste_id_auteurs']);
                if (in_array($id_auteur, $array_id_auteurs)) {
                    $test = false;
                    foreach ($array_id_auteurs as $elem) {
                        $sql2 = "select * from utilisateurs where id='$elem'";
                        if ($action->nombre_row($sql2) != 0) {
                            $auteur_col = $action->get_row($sql2);
                            if ($auteur_col['id'] != $id_auteur && !in_array($auteur_col['id'], $array_id_coauteur)) {
                                $array_id_coauteur[] = $auteur_col['id'];
                            }
                        }
                    }
                }
            }
            $i = 0;
            foreach ($array_id_coauteur as $elem) {
                $sql2 = "select * from utilisateurs where id='$elem'";
                $auteur_col = $action->get_row($sql2);
                $array_articles = array();
                $sql3 = "select * from articles where (liste_id_auteurs like '$id_auteur,%' || liste_id_auteurs like '%,$id_auteur,%' || liste_id_auteurs like '%,$id_auteur') &&"
                        . "(liste_id_auteurs like '$elem,%' || liste_id_auteurs like '%,$elem,%' || liste_id_auteurs like '%,$elem') && etat='Publié'";
                $nombre_article = $action->nombre_row($sql3);
                if ($nombre_article != 0) {
                    ++$i;
                    $liste[$i][1] = $nombre_article;
                    $liste[$i][2] = '';
                    $liste[$i][2] .='<a href="../accueil/index.php?id_auteur=' . $elem . '"><p><b>'
                            . '    ' . $auteur_col['nom'] . ' ' . $auteur_col['prenom'] . ' - ' . $auteur_col['laboratoire'] . ' - ' . $auteur_col['organisation']
                            . '</b></p></a>'
                            . '<p><b><i>Par articles :</i></b></p>';
                    $liste_articles = $action->get_list($sql3);
                    foreach ($liste_articles as $value) {
                        $liste[$i][2] .='<a href="../accueil/index.php?id_article=' . $value['id'] . '">' . $value['titre'] . '</a><br/><br/>';
                    }
                }
            }
            for ($j = 1; $j <= $i - 1; $j++) {
                for ($k = $j + 1; $k <= $i; $k++) {
                    if ($liste[$j][1] < $liste[$k][1]) {
                        $tg1 = $liste[$k][1];
                        $liste[$k][1] = $liste[$j][1];
                        $liste[$j][1] = $tg1;
                        $tg2 = $liste[$k][2];
                        $liste[$k][2] = $liste[$j][2];
                        $liste[$j][2] = $tg2;
                    }
                }
            }
            for ($j = 1; $j <= $i; $j++) {
                echo $liste[$j][2];
            }
            if ($i==0){
                echo '<p><i>Il n\'a pas de co-auteurs</i></p>';
            }
        } else {
            echo '<h3>Rechercher l\'article par le titre</h3><div>'
            . '<form method="get" action="../rechercher/recherche.php">'
            . '<input class="form-control" type="text" name="rc_titre" id="rc_titre2" placeholder="Le titre de l\'article">'
            . '<input class="form-control" type="submit" name="submit_tous_article" value="Rechecher">'
            . '</form></div>';
        };
        ?>
    </body>
</html>
