<!DOCTYPE html>
<?php
if (isset($_GET['categorie'])) {
    $categories = array("RI" => "Article dans des Revues Internationales",
        "CI" => "Article dans des Conférences Internationales",
        "RF" => "Article dans des Revues Françaises",
        "CF" => "Article dans des Conférences Françaises",
        "OS" => "Ouvrage Scientifique (Chapitre de Livre, ...)",
        "TD" => "Thèse de Doctorat",
        "BV" => "Brevet",
        "AP" => "Autre Production");
    $categorie = $_GET['categorie'];
    ?>
    <html lang="en">
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>LES PUBLICATION</title>
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <link href="../style.css" rel="stylesheet">
            <script language="javascript" src="../js/jquery-2.0.0.min.js"></script>
            <script language="javascript">
                $("#<?php echo $categorie; ?>").attr("class", "btn btn-lg btn-default active");
                $('#accueil').removeAttr('class');
                $('#accueil').attr("class", "btn btn-lg btn-default");
            </script>
        </head>
        <body>
            <?php
            $affiche = $categories[$categorie];
            echo '<h3 style="border-bottom: 1px solid #ddd; ">' . $affiche . '</h3>';
            require_once '../php_sql_action.php';
            $action = new DB_driver();
            $sql = 'select * from articles where categorie="' . $categorie . '" order by id desc ;';
            $nombre = $action->nombre_row($sql);
            $syntaxe = '';
            $test = false;
            if ($nombre != 0) {
                $array_ligne = $action->get_list($sql);
                foreach ($array_ligne as $ligne) {
                    if ($ligne['etat'] == 'Publié') {
                        $test = true;
                        $liste_array = explode(',', $ligne['liste_id_auteurs']);
                        $liste_auteurs = array();
                        $auteurs = '';
                        foreach ($liste_array as $elem) {
                            $row = $action->get_row("select * from utilisateurs where id='$elem'");
                            $auteurs .='<i><a href="../accueil/index.php?id_auteur=' . $elem . '">' . $row['nom'] . ' ' . $row['prenom'] . '</a></i>';
                            $auteurs .=',';
                        };
                        $auteurs = trim($auteurs, ',');
                        ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="../accueil/index.php?id_article=<?php echo $ligne['id']; ?>"><img class="img-thumbnail img-responsive" style="height: 120px ;width: 150px; " src="../images/<?php echo $ligne["photo"]; ?>"/></a>
                                </div>
                                <div class="col-md-10">    
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p class="attr">Titre</p>
                                        </div>    
                                        <div class="col-md-10">
                                            <a href="../accueil/index.php?id_article=<?php echo $ligne['id']; ?>"><p class="attr"><?php echo $ligne["titre"] ?></p></a>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="col-md-2"><p class="attr">Auteurs</p></div>
                                        <div class="col-md-10">
                                            <p  class="cont"><?php echo $auteurs; ?></p>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-2" ><p class="attr">Année</p></div>
                                        <div class="col-md-10">
                                            <p  class="cont"> <?php echo $ligne["annee"]; ?></p>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-2"><p class="attr">Lieu</p> </div>
                                        <div class="col-md-10">
                                            <p  class="cont"><?php echo $ligne["lieu"]; ?></p>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-2"><p class="attr">Résumé</p></div>
                                        <div class="col-md-10">
                                            <p class="cont" style="text-align: justify;"><?php echo substr($ligne["resume"], 0, 360); ?>...</p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <p style="border-bottom: 1px solid #ddd; "></p>
                        </div>

                        <?php
                    }
                }
                if ($test == false) {
                    echo"<p class='annoncer'>Il n'y a aucune article!</p>";
                }
            } else {
                echo"<p class='annoncer'>Il n'y a aucune article!</p>";
            };
            ?>
        </body>
    </html>
    <?php
}
?>




