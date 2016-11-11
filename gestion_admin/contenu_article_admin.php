<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="titre<?php echo $i; ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
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
                $sql5 = 'select * from articles where id="' . $id_article . '" order by id desc ;';
                $nombre = $action->nombre_row($sql5);
                $syntaxe = '';
                if ($nombre != 0) {
                    $ligne = $action->get_row($sql5);
                    $liste_array = explode(',', $ligne['liste_id_auteurs']);
                    $liste_id_auteurs = implode(' ', $liste_array);
                    $liste_auteurs = array();
                    $nombre_auteurs = 0;
                    $lesauteurs = '';
                    foreach ($liste_array as $elem) {
                        $row = $action->get_row("select * from utilisateurs where id='$elem'");
                        $lesauteurs .='<p  class="cont"><a href="../accueil/index.php?id_auteur=' . $elem . '">' . $row['nom'] . ' ' . $row['prenom'] . ' - '
                                . $row['laboratoire'] . ' - ' . $row['organisation'] . '</a>' . '</p>';
                    };
                    ?>
                    <div class="row">
                        <div class="col-md-2">
                            <img class="img-thumbnail img-responsive" style="height: 120px ;width: 150px; " src="../images/<?php echo $ligne["photo"]; ?>"/>
                        </div>
                        <div class="col-md-10">    
                            <div class="row">
                                <div class="col-md-2">
                                    <p class="attr">Titre</p>
                                </div>    
                                <div class="col-md-10" id="modifier_titre_contenu">
                                    <p class="attr"><?php echo $ligne["titre"] ?></p>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-2">
                                    <p class="attr">Categorie</p>
                                </div>    
                                <div class="col-md-10">
                                    <p class="cont"><?php echo $categories[$ligne["categorie"]]; ?></p>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-2"><p class="attr">Auteurs</p></div>
                                <div class="col-md-10" id="modifier_auteurs_contenu"><?php echo $lesauteurs; ?></div>

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
                                    <p class="cont" style="text-align: justify;"><?php echo $ligne["resume"]; ?></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                };
                ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>