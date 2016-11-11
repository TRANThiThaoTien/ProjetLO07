$(document).ready(function ()
{
    var cher = document.getElementById('contenu_recher');
    $('#tous_articles').click(function () {
        document.getElementById("tous_articles").parentNode.setAttribute("class", "active");
        document.getElementById("cher2").parentNode.removeAttribute("class", "active");
        document.getElementById("cher3").parentNode.removeAttribute("class", "active");
        document.getElementById("cher4").parentNode.removeAttribute("class", "active");
        document.getElementById("cher5").parentNode.removeAttribute("class", "active");
        cher.innerHTML = '<h3>Rechercher l\'article par le titre</h3><div>'
                + '<form method="get" action="../rechercher/recherche.php">'
                + '<input class="form-control" type="text" name="rc_titre" id="rc_titre2" placeholder="Le titre de l\'article">'
                + '<input class="form-control" type="submit" name="submit_tous_article" value="Rechecher">'
                + '</form></div>';
        $("#rc_titre2").autocomplete({
            source: '../rechercher/autocomplete_titre.php',
        });
    });
    $('#cher2').click(function () {
        document.getElementById("cher2").parentNode.setAttribute("class", "active");
        document.getElementById("tous_articles").parentNode.removeAttribute("class", "active");
        document.getElementById("cher3").parentNode.removeAttribute("class", "active");
        document.getElementById("cher4").parentNode.removeAttribute("class", "active");
        document.getElementById("cher5").parentNode.removeAttribute("class", "active");
        cher.innerHTML = '<div>'
                + '<form method="get" action="../rechercher/recherche.php">'
                + '<label> La Publication est de </label>'
                + '<select class="form-control" name="lab">'
                + '<option value="CREIDD">CREIDD : Centre de Recherches et d\'Etudes Interdisciplinaires sur le Développement Durable</option>'
                + '<option value="ERA">ERA : Environnement de Réseaux Autonomes</option>'
                + '<option value="GAMMMA3">GAMMA3 : Génération Automatique de Maillage et Méthodes Avancées</option>'
                + '<option value="LASMIS">LASMIS : Systèmes Mécaniques et Ingénierie Simultanée</option>'
                + '<option value="LM2S">LM2S : Modélisation et Sûreté des Systèmes</option>'
                + '<option value="LNIO">LNIO : Nanotechnologie et Instrumentation Optique</option>'
                + '<option value="LOSI">LOSI : Optimisation des Systèmes Industriels</option>'
                + '<option value="tech-CICO">Tech-CICO : Technologies pour la Coopération, l\'Interaction et les COnnaissances dans les collectifs</option>'
                + '</select>'
                + '<label> Depuis année: </label>'
                + '<input class="form-control" type="text" name="year" id="year">'
                + '<br/><input class="form-control" type="submit" name="submit_rc_laboratoire" id="submit_rc_laboratoire" value="Rechercher par Laboratoire">'
                + '</form></div>';
        $('#submit_rc_laboratoire').click(function () {
            var value = document.getElementById('year').value;
            if (isNaN(value) == true) {
                alert("Mauvais saisir!");
                return false;
            }
        });

    });
    $('#cher3').click(function () {
        document.getElementById("tous_articles").parentNode.removeAttribute("class", "active");
        document.getElementById("cher2").parentNode.removeAttribute("class", "active");
        document.getElementById("cher3").parentNode.setAttribute("class", "active");
        document.getElementById("cher4").parentNode.removeAttribute("class", "active");
        document.getElementById("cher5").parentNode.removeAttribute("class", "active");
        cher.innerHTML = '<h3>Rechercher publication par auteur</h3>'
                + '<div class="row">'
                + '<form method="get" action="../rechercher/recherche.php">'
                + '<div class="col-md-12 form-group">'
                + '<label> Saisir l\'auteur:</label>'
                + '</div><div class="clear-fix"></div>'
                + '<div class="col-md-6 form-group">'
                + '<input class="form-control" type="text" name="saisirnom" id="saisirnom" placeholder="Nom">'
                + '</div>'
                + '<div class="col-md-6 form-group">'
                + '<input class="form-control" type="text" name="saisirprenom" id="saisirprenom" placeholder="Prenom">'
                + '</div>'
                + '<div class="clear-fix"></div>'
                + '<div class="form-group col-md-6">'
                + '<input class="btn btn-default" type="submit" name="submit_rc_auteur" value="Rechercher">'
                + '</div>'
                + '</form>'
                + '</div>';
        $("#saisirnom").autocomplete({
            source: '../rechercher/autocomplete_nom_auteur.php',
        });
        $("#saisirprenom").autocomplete({
            source: '../rechercher/autocomplete_prenom_auteur.php',
        });
    });
    $('#cher4').click(function () {
        document.getElementById("tous_articles").parentNode.removeAttribute("class", "active");
        document.getElementById("cher2").parentNode.removeAttribute("class", "active");
        document.getElementById("cher3").parentNode.removeAttribute("class", "active");
        document.getElementById("cher4").parentNode.setAttribute("class", "active");
        document.getElementById("cher5").parentNode.removeAttribute("class", "active");

        $.ajax({
            url: '../rechercher/rechercher_collaborations.php',
            type: 'get',
            dataType: 'text',
            success: function (result) {
                cher.innerHTML = result;
            }
        });
    });
    $('#cher5').click(function () {
        document.getElementById("tous_articles").parentNode.removeAttribute("class", "active");
        document.getElementById("cher2").parentNode.removeAttribute("class", "active");
        document.getElementById("cher3").parentNode.removeAttribute("class", "active");
        document.getElementById("cher4").parentNode.removeAttribute("class", "active");
        document.getElementById("cher5").parentNode.setAttribute("class", "active");
        $.ajax({
            url: '../rechercher/rechercher_coauteur.php',
            type: 'get',
            dataType: 'text',
            success: function (result) {
                cher.innerHTML = result;
            }
        });
    });
    $("#CF").tooltip();
    $("#RI").tooltip();
    $("#CI").tooltip();
    $("#RF").tooltip();
    $("#OS").tooltip();
    $("#TD").tooltip();
    $("#BV").tooltip();
    $("#AP").tooltip();
    $("#user").tooltip({
        placement: "bottom"
    });
    $("#admin").tooltip({
        placement: "bottom"
    });
});