<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LES PUBLICATION</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../style.css" rel="stylesheet">
        <script language="javascript" src="../js/jquery-2.0.0.min.js"></script>
    </head>
    <body>
        <?php
        require_once '../gestion/action_utilisateur.php';

        if (isset($_REQUEST['id_article'])) {
            $categories = array("RI" => "Article dans des Revues Internationales",
                "CI" => "Article dans des Conférences Internationales",
                "RF" => "Article dans des Revues Françaises",
                "CF" => "Article dans des Conférences Françaises",
                "OS" => "Ouvrage Scientifique (Chapitre de Livre, ...)",
                "TD" => "Thèse de Doctorat",
                "BV" => "Brevet",
                "AP" => "Autre Production");
            $id_article = $_REQUEST['id_article'];
            require_once '../php_sql_action.php';
            $action = new DB_driver();
            $sql = 'select * from articles where id="' . $id_article . '" order by id desc ;';
            $nombre = $action->nombre_row($sql);
            $syntaxe = '';
            if ($nombre != 0) {
                $ligne = $action->get_row($sql);
                ?>
                <script language="javascript">
                    $('#accueil').removeAttr('class');
                    $('#accueil').attr("class", "btn btn-lg btn-default");
                    $("#<?php echo $ligne['categorie']; ?>").attr("class", "btn btn-lg btn-default active");
                </script>
                <?php
                $liste_array = explode(',', $ligne['liste_id_auteurs']);
                $liste_id_auteurs = implode(' ', $liste_array);
                $liste_auteurs = array();
                $nombre_auteurs = 0;
                $lesauteurs = '';
                foreach ($liste_array as $elem) {
                    $row = $action->get_row("select * from utilisateurs where id='$elem'");
                    $lesauteurs .='<p  class="cont"><a href="../accueil/index.php?id_auteur=' . $elem . '">' . $row['nom'] . ' ' . $row['prenom'] . ' - '
                            . $row['laboratoire'] . ' - ' . $row['organisation'] . '</a>' . '</p>';
                    ++$nombre_auteurs;
                    $liste_auteurs[$nombre_auteurs]['nom'] = $row['nom'];
                    $liste_auteurs[$nombre_auteurs]['prenom'] = $row['prenom'];
                    $liste_auteurs[$nombre_auteurs]['organisation'] = $row['organisation'];
                    $liste_auteurs[$nombre_auteurs]['laboratoire'] = $row['laboratoire'];
                    $liste_auteurs[$nombre_auteurs]['id'] = $elem;
                };
                ?>
                <div class="col-md-12">
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

                    <div class="col-md-offset-2" id='ajouter_unplus' style='display:none;'>
                        <h3 class="text-center" style="border-bottom: solid #ddd 1px;font-size: 18px;"> Ajouter un auteur</h3>
                        <form class="form-horizontal" name="ajouter_unplus_auteur" id="ajouter_unplus_auteur" method="POST" action="verifier_ajouter_auteur.php">
                            <div class='form-group'>
                                <label class='col-md-2 control-label'>Nom</label>
                                <div class='col-md-10'>
                                    <input type='text' class='form-control' name='nom_auteur' id="nom_auteur">
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-md-2 control-label'>Prénom</label>
                                <div class='col-md-10'>
                                    <input type='text' class='form-control' name='prenom_auteur' id="prenom_auteur">
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-md-2 control-label'>Organisation</label>
                                <div class='col-md-10'>
                                    <input type='text' class='form-control' name='organisation2' id="organisation2">
                                </div>
                            </div>
                            <div class='form-group'>
                                <label class='col-md-2 control-label'>Laboratoire</label> 
                                <div class='col-md-10'>
                                    <select class='form-control' name='laboratoire2' id="laboratoire2">
                                        <option value='CREIDD'>CREIDD : Centre de Recherches et d'Etudes Interdisciplinaires sur le Développement Durable</option>
                                        <option value='ERA'>ERA : Environnement de Réseaux Autonomes</option>
                                        <option value='GAMMA3'>GAMMA3 : Génération Automatique de Maillage et Méthodes Avancées</option>
                                        <option value='LASMIS'>LASMIS : Systèmes Mécaniques et Ingénierie Simultanée</option>
                                        <option value='LM2S'>LM2S : Modélisation et Sûreté des Systèmes</option>
                                        <option value='LNIO'>LNIO : Nanotechnologie et Instrumentation Optique</option>
                                        <option value='LOSI'>LOSI : Optimisation des Systèmes Industriels</option>
                                        <option value='Tech-CICO'>Tech-CICO : Technologies pour la Coopération, l'Interaction et les COnnaissances dans les collectifs</option> 
                                    </select>
                                </div>
                            </div>
                            <div class='form-group'>
                                <div class='col-md-10 col-md-offset-2'>
                                    <div id='tb' class="alert alert-danger hide"></div>
                                    <div id='tc' class="alert alert-success hide"></div>
                                </div>
                            </div>
                            <div class='clearfix'></div>
                            <div class='form-group'>
                                <div class='col-md-10 col-md-offset-2'>
                                    <input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
                                    <input class="btn btn-primary btn-sm" type="button" value="Submit" name="ajouter_auteur" id='ajouter_auteur'>
                                    <input class="btn btn-danger btn-sm" type="reset" id="reset" value="Reset">   
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                    if (isset($_SESSION['id_connexion'])) {
                        $kt = false;
                        foreach ($liste_array as $value) {
                            if ($value == $_SESSION['id_connexion']) {
                                $kt = true;
                            }
                        }
                        if ($kt == true) {
                            ?>
                            <div class="col-md-offset-2">
                                <input id="modifier_titre"  type="button" class="btn btn-sm btn-default" value="Modifier le titre">
                                <input id="supprimer"  type="button" class="btn btn-sm btn-default" value="Supprimer un auteur">
                                <input id="ajouter" type="button" class="btn btn-sm btn-default" value="Ajouter un auteur">
                                <input id="modifier_ordre" type="button" class="btn btn-sm btn-default" value="Changer ordre un auteur">
                                <a href="../accueil/index.php?id_article=<?php echo $id_article; ?>"><input style="display:none;" id="annuler_modifier" type="button" class="btn btn-sm btn-danger" value="Annuler"></a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            } else {
                echo"<p> <h2> Il n'y a aucune article!";
            };
            ?>
            <?php
            $auteurs_n = '';
            for ($i = 1; $i <= $nombre_auteurs; $i++) {
                if ($i == 1) {
                    $auteurs_n .='<input type ="hidden" value="' . $liste_auteurs[$i]["organisation"] . '">';
                    $auteurs_n .='<input type ="radio" checked="checked" name = "id_auteur" value =" ' . $liste_auteurs[$i]["id"] . '"> ' . $liste_auteurs[$i]["nom"] . ' ' . $liste_auteurs[$i]["prenom"] . ' - ' . $liste_auteurs[$i]["laboratoire"] . ' - ' . $liste_auteurs[$i]["organisation"] . '   </input> <br/>';
                    continue;
                }
                $auteurs_n .='<input type ="hidden" value="' . $liste_auteurs[$i]["organisation"] . '">';
                $auteurs_n .='<input type ="radio" name = "id_auteur" value =" ' . $liste_auteurs[$i]["id"] . '"> ' . $liste_auteurs[$i]["nom"] . ' ' . $liste_auteurs[$i]["prenom"] . ' - ' . $liste_auteurs[$i]["laboratoire"] . ' - ' . $liste_auteurs[$i]["organisation"] . '   </input><br/>';
            }
            $supprimer = '<form action="../accueil/index.php" method="POST" id="supprimer_form"><div class = form-group><label>Choisir un auteur pour supprimer </label><p/>' . $auteurs_n . '</div>'
                    . '<input type="hidden" name="id_article" value="' . $id_article . '">'
                    . '<input type = "submit" name="supprimer_auteur" id="supprimer_auteur" action="../accueil/index.php" method="POST" class = "btn btn-danger btn-sm " value = "Supprimer"> '
                    . '</form>';
            $ordre_auteurs = '<div class="row"> <div class="col-md-10"> <form method="POST" id="ordre_form" action="../accueil/index.php" class="form-horizontal">';
            for ($i = 1; $i <= $nombre_auteurs; $i++) {
                $option = '';
                for ($j = 1; $j <= $nombre_auteurs; $j++) {
                    if ($i == $j) {
                        $option .='<option selected="selected" value="' . $liste_auteurs[$j]["id"] . '">' . $liste_auteurs[$j]["nom"] . ' ' . $liste_auteurs[$j]["prenom"] . ' (' . $liste_auteurs[$j]["organisation"] . ')' . '</option>\ ';
                    } else {
                        $option .='<option value="' . $liste_auteurs[$j]["id"] . '">' . $liste_auteurs[$j]["nom"] . $liste_auteurs[$j]["prenom"] . ' (' . $liste_auteurs[$j]["organisation"] . ')' . '</option>\ ';
                    };
                };
                $ordre_auteurs .='<div class="form-group">\
                <label class=" col-md-2 control-label">Ordre ' . $i . '</label>\
                <div class="col-md-10"><select class="form-control" name="id_auteurs[]">\ '
                        . $option
                        . '</select></div>\
            </div>';
            };
            $ordre_auteurs .= '<input type="hidden" name="id_article" value="' . $id_article . '">\
            <input type="submit" name ="changer_ordre"  id="changer_ordre" class="btn btn-primary btn-sm " value="Sauver"> \n\
            <input type="reset" class="btn btn-primary btn-sm" value="Remettre"></form></div></div>';
            if (isset($_SESSION['id_connexion'])) {
                if ($kt == true) {
                    ?>
                    <script language="javascript" type="text/javascript">
                        var modifier_titre = document.getElementById("modifier_titre");
                        var supprimer = document.getElementById("supprimer");
                        var ajouter = document.getElementById("ajouter");
                        var modifier_ordre = document.getElementById("modifier_ordre");
                        var annuler_modifier = document.getElementById("annuler_modifier");

                        function display_none() {
                            modifier_titre.style.display = "none";
                            supprimer.style.display = "none";
                            ajouter.style.display = "none";
                            modifier_ordre.style.display = "none";
                            annuler_modifier.style.display = "";
                        }
                        ;
                        modifier_titre.addEventListener("click", function () {
                            display_none();
                            document.getElementById("modifier_titre_contenu").innerHTML = '<div class="">\n\
            <form action = "../accueil/index.php" method="POST"> \n\
            <div class = "form-group" >\n\
            <input type = "hidden" name = "id_article" value = "<?php echo $id_article; ?>" >\n\
            <input class = "form-control" type = "text" name = "titre" value = "<?php echo $ligne["titre"]; ?>"> \n\
            </div><input type = "submit" name = "modifier_titre_action" class = "btn btn-primary btn-sm " value = "Sauver">\n\
            <input type = "reset" class = "btn btn-primary btn-sm " value = "Remettre" > </form></div>';
                        });
                        supprimer.addEventListener("click", function () {
                            display_none();
                            document.getElementById("modifier_auteurs_contenu").innerHTML = '<?php echo $supprimer; ?>';
                            $('#supprimer_auteur').click(function () {
                                var inputs = document.forms['supprimer_form'].getElementsByTagName('input');
                                var test = 0;
                                for (var i = 0; i < inputs.length; i++) {
                                    if (inputs[i].value.toLowerCase() == 'utt') {
                                        ++test;
                                    }
                                }
                                var verifier = true;
                                for (var i = 0; i < inputs.length; i++) {
                                    if (inputs[i].getAttribute('type') == 'radio') {
                                        if (inputs[i].checked) {
                                            if (inputs[i].previousSibling.value.toLowerCase() == 'utt' && test == 1) {
                                                alert("Cet article doit avoir un auteur de l'UTT");
                                                return false;
                                                verifier = false;
                                            }
                                        }
                                    }
                                }
                                if (verifier) {
                                    return confirm("Cet auteur va être supprimé!");
                                }
                            });
                        });
                        ajouter.addEventListener("click", function () {
                            display_none();
                            document.getElementById("ajouter_unplus").style.display = "block";

                            var inputs = document.forms['ajouter_unplus_auteur'].getElementsByTagName('input');
                            var reset = document.getElementById('reset');
                            reset.onclick = function () {
                                run_onchange = false;
                                for (var i = 0; i < inputs.length; i++) {
                                    var p = inputs[i].parentNode;
                                    if (p.lastChild.nodeName == 'SPAN') {
                                        p.removeChild(p.lastChild);
                                        inputs[i].style.border = '';
                                        inputs[i].style.background = '';
                                    }
                                }
                            }
                            $(document).ready(function () {
                                var erreur = false;
                                var run_onchange = false;
                                var run = false;
                                function valid() {
                                    var data = {
                                        nom_auteur: $('#nom_auteur').val(),
                                        prenom_auteur: $('#prenom_auteur').val(),
                                        organisation: $('#organisation2').val(),
                                        laboratoire: $('#laboratoire2').val(),
                                        liste_id_auteurs: ' <?php echo trim($liste_id_auteurs); ?> ',
                                        id_article: <?php echo $id_article; ?>,
                                    };
                                    url = "../gestion/verifier_ajouter_auteur.php";
                                    $.ajax({
                                        type: "post",
                                        dataType: "JSON",
                                        url: url,
                                        data: data,
                                        success: function (result)
                                        {
                                            if (result.hasOwnProperty('error') && result.error == '1') {
                                                for (var i = inputs.length - 1; i >= 0; i--) {
                                                    var id = inputs[i].getAttribute('id');
                                                    var span = document.createElement('span');

                                                    var p = inputs[i].parentNode;
                                                    if (p.lastChild.nodeName == 'SPAN') {
                                                        p.removeChild(p.lastChild);
                                                        inputs[i].style.border = '';
                                                        inputs[i].style.background = '';
                                                    }

                                                    if (id == 'nom_auteur' && result.nom_auteur != '') {
                                                        span.innerHTML = result.nom_auteur;
                                                    }
                                                    if (id == 'prenom_auteur' && result.prenom_auteur != '') {
                                                        span.innerHTML = result.prenom_auteur;
                                                    }
                                                    if (id == 'organisation2' && result.organisation != '') {
                                                        span.innerHTML = result.organisation;
                                                    }
                                                    if (span.innerHTML != '') {
                                                        span.setAttribute('style', 'color: red; font-style:italic');
                                                        inputs[i].parentNode.appendChild(span);
                                                        run_onchange = true;
                                                        inputs[i].style.border = '1px solid #c6807b';
                                                        inputs[i].style.background = '#fffcf9';
                                                        inputs[i].focus();
                                                        erreur = true;
                                                    }
                                                }
                                                if (result.text != '') {
                                                    $('#tb').removeClass('hide');
                                                    $('#tb').html(result.text);
                                                    run_onchange = true;
                                                    erreur = true;
                                                }
                                            } else {
                                                if (run == false) {
                                                    $('#tc').removeClass('hide');
                                                    $('#tc').html("Succès");

                                                    setTimeout("location.reload(true);", 800);

                                                }
                                            }
                                        }
                                    });
                                }
                                ;
                                $('#ajouter_auteur').click(function () {
                                    run = false;
                                    return valid();
                                });
                                for (var i = 0; i < inputs.length; i++) {
                                    var id = inputs[i].getAttribute('id');
                                    inputs[i].onchange = function () {
                                        if (run_onchange == true) {
                                            $('#tb').addClass('hide');
                                            this.style.border = '';
                                            this.style.background = '';
                                            if (this.parentNode.lastChild.nodeName == 'SPAN') {
                                                this.parentNode.removeChild(this.parentNode.lastChild);
                                            }
                                            run = true;
                                            return valid();
                                        }
                                    };
                                }
                                var laboratoire = document.getElementById("laboratoire2");
                                laboratoire.onchange = function () {
                                    if (run_onchange == true) {
                                        $('#tb').addClass('hide');
                                        return valid();
                                    }
                                }
                            });

                        });
                        modifier_ordre.addEventListener("click", function () {
                            display_none();
                            document.getElementById("modifier_auteurs_contenu").innerHTML = '<?php echo $ordre_auteurs; ?>';
                            $('#changer_ordre').click(function () {
                                var selects = document.forms['ordre_form'].getElementsByTagName('select');
                                var test = true;
                                for (var i = 0; i < selects.length - 1; i++) {
                                    for (var j = i + 1; j < selects.length; j++)
                                        if (selects[i].value == selects[j].value) {
                                            test = false;
                                            break;
                                        }
                                }
                                if (test == false) {
                                    alert("Il y a eurrer, deux ordre a le même auteur!");
                                    return false;
                                }
                            })
                        });
                    </script>
                    <?php
                }
            }
        };
        ?>
    </body> 
</html>

