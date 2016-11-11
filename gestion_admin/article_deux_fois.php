
<script type="text/javascript">

    $('#contenu').html('');

    $("#article_deux_fois").attr("class", "active");
    $('#articles').removeAttr('class');


</script>
<h2 class='text-center' style="font-weight: bold ;font-size: 1.6em; ">Les articles présent plusieurs fois dans la base </h2>
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
            $sql2 = 'select * from articles where titre="' . $elem['titre'] . '"';
            $nombre_titre = $action->nombre_row($sql2);
            if ($nombre_titre > 1) {
                $plusieur_titre = $action->get_list($sql2);
                foreach ($plusieur_titre as $value) {
                    ++$i;
                    $syntaxe .='<tr>';
                    $syntaxe .='<td>' . $i . '</td>';
                    $syntaxe .='<td style="text-align: justify;">' . $value["titre"] . '</td>';
                    $syntaxe .='<td>' . $value["annee"] . '</td>';
                    $syntaxe .='<td>' . $value["etat"] . '</td>';
                    $syntaxe .='<td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#titre' . $i . '">Détail</button></td>';
                    $syntaxe .='<td><form method="POST" action="admin.php">'
                            . '<input type="hidden" name="id_article" value=' . $value['id'] . '>'
                            . '<input type="hidden" name="article_deux_fois" value="">'
                            . '&nbsp;&nbsp;&nbsp;&nbsp;<input name="supprimer_article" class="btn btn-sm btn-danger" type="submit" onclick="return confirmer();" value="-"></form></td>';
                    $syntaxe .='</tr>';
                }
            }
        }
        echo $syntaxe;
        ?>
    </tbody>
</table>
<?php
$i = 0;
foreach ($article_distinct as $elem) {
    $sql2 = 'select * from articles where titre="' . $elem['titre'] . '"';
    $nombre_titre = $action->nombre_row($sql2);
    if ($nombre_titre > 1) {
        $plusieur_titre = $action->get_list($sql2);
        foreach ($plusieur_titre as $value) {
            ++$i;
            $id_article = $value['id'];
            require 'contenu_article_admin.php';
        }
    }
}
?>
