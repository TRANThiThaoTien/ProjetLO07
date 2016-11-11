
<script language="javascript">
    $('#accueil').removeAttr('class');
    $('#accueil').attr("class", "btn btn-lg btn-default");
</script>

<?php
if (isset($_GET["id_auteur"])) {
    require_once "../php_sql_action.php";
    $action = new DB_driver();
    $sql = 'select * from articles order by id desc ;';
    $array_ligne = $action->get_list($sql);
    $nombre = $action->nombre_row($sql);
    $syntaxe = '';
    $test = false;
    $sql = 'select * from utilisateurs where id=' . $_GET["id_auteur"] . ';';
    $auteur1 = $action->get_row($sql);
    $syntaxe_auteur = $auteur1['nom'] . ' ' .$auteur1['prenom'] . ' - ' . $auteur1['laboratoire'] . ' - ' . $auteur1['organisation'];
    if ($nombre != 0) {
        echo '<h3>Les articles de l\'auteur ' . $syntaxe_auteur . ' :</h3>';
        foreach ($array_ligne as $ligne) {
            if ($ligne['etat'] == 'Publié') {
                $liste_array = explode(',', $ligne['liste_id_auteurs']);
                $kt = false;
                foreach ($liste_array as $value) {
                    if ($value == $_GET["id_auteur"]) {
                        $kt = true;
                    }
                }
                if ($kt == true) {
                    $test = true;
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
                                    <div class="col-md-10" id="modifier_titre_contenu">
                                        <a href="../accueil/index.php?id_article=<?php echo $ligne['id']; ?>"><p class="attr"><?php echo $ligne["titre"] ?></p></a>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-2"><p class="attr">Auteurs</p></div>
                                    <div class="col-md-10" id="modifier_auteurs_contenu">
                                        <p  class="cont"> <?php echo $auteurs; ?></p>
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
        };
        if ($test == false) {
            echo"<p class='annoncer'>Il n'y a aucune article!</p>";
        }
    }
}
?>