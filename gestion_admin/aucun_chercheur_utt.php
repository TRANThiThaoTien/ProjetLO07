<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LES PUBLICATION</title>
        <link href="../Css/bootstrap.min.css" rel="stylesheet">
        <link href="../style.css" rel="stylesheet">
        <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
    </head>
</body>
<script type="text/javascript">

    $('#contenu').html('');

    $("#aucun_utt").attr("class", "active");
    $('#articles').removeAttr('class');
</script>
<h2 class='text-center' style="font-weight: bold ;font-size: 1.6em; ">Les articles n'a aucune chercheur UTT</h2>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>Ordre</th>
            <th>Titre</th>
            <th>Année</th>
            <th width='10%'>État</th>
            <th>Détail</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $categorie = array("RI" => "RI : Article dans des Revues Internationales",
            "CI" => "CI : Article dans des Conférences Internationales",
            "RF" => "RF : Article dans des Revues Françaises",
            "CF" => "CF : Article dans des Conférences Françaises",
            "OS" => "OS : Ouvrage Scientifique (Chapitre de Livre, ...)",
            "TD" => "TD : Thèse de Doctorat",
            "BV" => "BV : Brevet",
            "AP" => "AP : Autre Production");
        require_once '../php_sql_action.php';
        $action = new DB_driver();
        $sql1 = 'select distinct titre from articles';
        $article_distinct = $action->get_list($sql1);
        $syntaxe = '';
        $i = 0;
        foreach ($article_distinct as $elem) {
            $article_ids = array();
            $erreur = 0;
            $sql2 = 'select * from articles where titre="' . $elem['titre'] . '"';
            $nombre_titre = $action->nombre_row($sql2);
            $plusieur_titre = $action->get_list($sql2);
            foreach ($plusieur_titre as $value) {
                ++$i;
                $liste_array = explode(',', $value['liste_id_auteurs']);
                $lesauteurs = '';
                $test = "false";
                foreach ($liste_array as $pt) {
                    $row = $action->get_row("select * from utilisateurs where id='$pt'");

                    if (strtolower($row['organisation']) == "utt" || strtolower($row['organisation']) == "université de techonologie de troyes") {
                        $test = "true";
                    };
                };
                if ($test == "false") {
                    foreach ($liste_array as $pt) {
                        $row = $action->get_row("select * from utilisateurs where id='$pt'");
                        $lesauteurs .='<p><a href="">  ' . $row['nom'] . ' ' . $row['prenom'] . ' (' . $row['organisation'] . ')</a>' . '</p>';
                    };
                    $syntaxe .='<tr>';
                    $syntaxe .='<td>' . $i . '</td>';
                    $syntaxe .='<td style="text-align: justify;">' . $value["titre"] . '</td>';
                    $syntaxe .='<td>' . $value["annee"] . '</td>';
                    $syntaxe .='<td>' . $value["etat"] . '</td>';
                    $syntaxe .='<td> <button type="button" class="btn btn-link" data-toggle="modal" data-target="#titre' . $i . '">Détail</button></td>';
                    $syntaxe .='<td><form method="POST" action="admin.php">'
                            . '<input type="hidden" name="id_article" value=' . $value['id'] . '>'
                            . '<input type="hidden" name="aucun_utt" value="">'
                            . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="supprimer_article" class="btn btn-danger" type="submit" onclick="return confirmer();" value="-"></form></td>';
                    $syntaxe .='</tr>';
                }
            }
        }
        echo $syntaxe;
        ?>
    </tbody>
</table>
</body>
</html>
<?php
$i = 0;
foreach ($article_distinct as $elem) {
    $article_ids = array();
    $erreur = 0;
    $sql2 = 'select * from articles where titre="' . $elem['titre'] . '"';
    $nombre_titre = $action->nombre_row($sql2);
    $plusieur_titre = $action->get_list($sql2);
    foreach ($plusieur_titre as $value) {
        ++$i;
        $id_article = $value['id'];
        require 'contenu_article_admin.php';
    }
}
?>
