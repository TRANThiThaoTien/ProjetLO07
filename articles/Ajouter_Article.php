
<html>
    <head>
        <title>Ajouter un publication</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../Css/bootstrap.min.css" rel="stylesheet">
        <script src="../Js/jquery-2.0.0.min.js"></script>
        <link rel="stylesheet" href="../jquery-ui.css"> 
    </head>
    <body>
        <?php
        $nom_a = '';
        $prenom_a = '';
        $laboratoire_a = '';
        $organisation_a = '';
        if (isset($_SESSION['id_connexion'])) {
            require_once '../php_sql_action.php';
            $action = new DB_driver();
            $sql = 'select * from utilisateurs where id="' . $_SESSION['id_connexion'] . '";';
            $ligne = $action->get_row($sql);
            $nom_a = $ligne['nom'];
            $prenom_a = $ligne['prenom'];
            $laboratoire_a = $ligne['laboratoire'];
            $organisation_a = $ligne['organisation'];
        }
        ?>
        <div class="row">
            <div class="col-md-12 ">
                <h3 class="text-center" style="border-bottom: solid"> Ajouter d'une nouvelle publication</h3>
                <form name="ajouter_article" method="POST" action="../accueil/index.php"  enctype="multipart/form-data" >
                    <div class="form-group">
                        <label>Le titre de l'article</label>
                        <input type="text" class="form-control" name="titre" >
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label>La liste de auteur</label>
                        <div class="container">
                            <div class="row" id="ajouter_auteur">
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <label class='col-md-4 control-label'>Nom de l'auteur n.1</label>
                                        <div class='col-md-8'>
                                            <input type='text' class='form-control' name='nom_auteurs[]' id="nom_auteurs1" role="auto_nom" value="<?php echo $nom_a; ?>">
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-md-4 control-label'>Prénom de l'auteur n.1</label>
                                        <div class='col-md-8'>
                                            <input type='text' class='form-control' name='prenom_auteurs[]' id="prenom_auteurs1" role='auto_prenom' value="<?php echo $prenom_a; ?>">
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-md-4 control-label'>Organisation</label>
                                        <div class='col-md-8'>
                                            <input type='text' class='form-control' name='organisation[]' role='auto_organisation' value="<?php echo $organisation_a; ?>">
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='col-md-4 control-label'>Laboratoire</label> 
                                        <div class='col-md-8'>
                                            <select class='form-control' name='laboratoire[]'>
                                                <option value='CREIDD' <?php if ($laboratoire_a == 'CREIDD') echo 'selected="selected"'; ?> >CREIDD : Centre de Recherches et d'Etudes Interdisciplinaires sur le Développement Durable</option>
                                                <option value='ERA' <?php if ($laboratoire_a == 'ERA') echo 'selected="selected"'; ?> >ERA : Environnement de Réseaux Autonomes</option>
                                                <option value='GAMMA3' <?php if ($laboratoire_a == 'GAMMA3') echo 'selected="selected"'; ?>>GAMMA3 : Génération Automatique de Maillage et Méthodes Avancées</option>
                                                <option value='LASMIS' <?php if ($laboratoire_a == 'LASMIS') echo 'selected="selected"'; ?>>LASMIS : Systèmes Mécaniques et Ingénierie Simultanée</option>
                                                <option value='LM2S' <?php if ($laboratoire_a == 'LM2S') echo 'selected="selected"'; ?>>LM2S : Modélisation et Sûreté des Systèmes</option>
                                                <option value='LNIO' <?php if ($laboratoire_a == 'LNIO') echo 'selected="selected"'; ?>>LNIO : Nanotechnologie et Instrumentation Optique</option>
                                                <option value='LOSI' <?php if ($laboratoire_a == 'LOSI') echo 'selected="selected"'; ?>>LOSI : Optimisation des Systèmes Industriels</option>
                                                <option value='Tech-CICO' <?php if ($laboratoire_a == 'Tech-CICO') echo 'selected="selected"'; ?>>Tech-CICO : Technologies pour la Coopération, l'Interaction et les COnnaissances dans les collectifs</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <button id="ajouter" type="button" class="btn btn-link" aria-label="Left Align">
                                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Ajouter un plus auteur
                            </button>
                            <button id="supprimer" type="button" class="btn btn-link" aria-label="Left Align">
                                <span style="color: red;"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> Supprimer le dernier</span>
                            </button>
                        </div>
                    </div>    
                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label>Le type de la publication</label>
                        <select class="form-control" name="categorie">
                            <option value="RI">RI : Article dans des Revues Internationales</option>
                            <option value="CI">CI : Article dans des Conférences Internationales</option>
                            <option value="RF">RF : Article dans des Revues Françaises</option>
                            <option value="CF">CF : Article dans des Conférences Françaises</option>
                            <option value="OS">OS : Ouvrage Scientifique (Chapitre de Livre, ...)</option>
                            <option value="TD">TD : Thèse de Doctorat</option>
                            <option value="BV">BV : Brevet</option>
                            <option value="AP">AP : Autre Production</option> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label>L'année de la publication</label>
                        <input type="text" class="form-control" name="annee" id='annee'>
                    </div>
                    <div class="form-group">
                        <label>Lieu de conférence</label>
                        <input type="text" class="form-control" name="lieu">
                    </div>
                    <div class="form-group-lg">
                        <label>Résumé de l'article</label>
                        <textarea name="resume" class="form-control" style="margin-bottom: 10px; height: 180px"></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label>Choisiez un photo</label>
                        <input class="form" type="file" name="photo" id="photo">
                    </div>
                    <div class="clearfix"></div>
                    <p/>
                    <p style="display:none; font-style: italic; color: red"  id="erreur"></p>
                    <input class="btn btn-primary" type="submit" value="Submit" name="submit_article" id='submit_article'>
                    <input class="btn btn-danger" type="reset" value="Reset">   
                </form>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap"s JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var i = 1;
                $('[role="auto_nom"]').autocomplete({
                    source: '../rechercher/autocomplete_nom_auteur.php'
                });
                $("[role='auto_prenom']").autocomplete({
                    source: '../rechercher/autocomplete_prenom_auteur.php'
                });
                $("[role='auto_organisation']").autocomplete({
                    source: '../rechercher/autocomplete_organisation.php'
                });
                $('#ajouter').click(function () {
                    i = i + 1;
                    var auteur = document.createElement('div');
                    auteur.setAttribute('class', 'col-md-8');
                    auteur.innerHTML = " </br><div class='form-group'>\
                                            <label class='col-md-4 control-label'>Nom de l'auteur n." + i + "</label>\
                                            <div class='col-md-8'>\
                                                <input type='text' class='form-control' name='nom_auteurs[]' id='nom_auteurs" + i + "' role='auto_nom' >\
                                            </div>\
                                        </div>\
                                        <div class='form-group'>\
                                            <label class='col-md-4 control-label'>Prénom de l'auteur n." + i + "</label>\
                                            <div class='col-md-8'>\
                                                <input type='text' class='form-control' name='prenom_auteurs[]' id='prenom_auteurs" + i + "' role='auto_prenom' >\
                                            </div>\
                                        </div>\n\
                                         <div class='form-group'> \n\
                                         <label class='col-md-4 control-label'>Organisation</label>\
                                            <div class='col-md-8'>\n\
                                        <input type='text' class='form-control' name='organisation[]' role='auto_organisation' >\n\
                                        </div>\
                                        </div>\n\
                                            <div class='form-group'>\
                                        <label class='col-md-4 control-label'>Laboratoire</label>\
                                            <div class='col-md-8'>\
                                        <select class='form-control' name='laboratoire[]'>\
<option value='CREIDD'>CREIDD : Centre de Recherches et d'Etudes Interdisciplinaires sur le Développement Durable</option>\\n\
<option value='ERA'>ERA : Environnement de Réseaux Autonomes</option>\n\
<option value='GAMMA3'>GAMMA3 : Génération Automatique de Maillage et Méthodes Avancées</option>\n\
<option value='LASMIS'>LASMIS : Systèmes Mécaniques et Ingénierie Simultanée</option>\n\
<option value='LM2S'>LM2S : Modélisation et Sûreté des Systèmes</option>\n\
<option value='LNIO'>LNIO : Nanotechnologie et Instrumentation Optique</option>\n\
<option value='LOSI'>LOSI : Optimisation des Systèmes Industriels</option>\n\
<option value='Tech-CICO'>Tech-CICO : Technologies pour la Coopération, l'Interaction et les COnnaissances dans les collectifs</option>\n\
</select></div></div>"
                    document.getElementById("ajouter_auteur").appendChild(auteur);
                    $("[role='auto_nom']").autocomplete({
                        source: '../rechercher/autocomplete_nom_auteur.php'
                    });
                    $("[role='auto_prenom']").autocomplete({
                        source: '../rechercher/autocomplete_prenom_auteur.php'
                    });
                    $("[role='auto_organisation']").autocomplete({
                        source: '../rechercher/autocomplete_organisation.php'
                    });
                    <?php require_once'verifier_article.js'; ?>
                });
                $('#supprimer').click(function () {
                    var liste_auteur = document.getElementById("ajouter_auteur");
                    if (document.forms['ajouter_article'].getElementsByTagName('input').length > 11) {
                        a = confirm("Le dernier auteur va être supprimer!")
                        if (a == true) {
                            i = i - 1;
                            liste_auteur.removeChild(liste_auteur.lastChild);
                        }
                    } else {
                        alert("Cet article doit avoir au moins un auteurs");
                    }
                });
            })
        </script>
        <script src="../articles/verifier_article.js"></script>
        <script language="javascript" src="../js/jquery-ui.js"></script>
    </body>
</html>


