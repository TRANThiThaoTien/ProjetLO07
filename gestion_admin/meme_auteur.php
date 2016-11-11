<script type="text/javascript">

    $('#contenu').html('');

    $("#mem_auteurs").attr("class", "active");
    $('#articles').removeAttr('class');
</script>
<?php
if (isset($_POST['supprimer_article'])) {
    require_once '../php_sql_action.php';
    $action = new DB_driver();
    $where = 'id=' . $_POST['id_article'];
    $action->remove('articles', $where);
}
?>
<h2 class='text-center' style="font-weight: bold ;font-size: 1.6em; ">Les articles présent le même auteur  </h2>
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
        require_once '../php_sql_action.php';
        $action = new DB_driver();
        $sql1 = 'select distinct titre from articles';
        $article_distinct = $action->get_list($sql1);
        $syntaxe = '';
        $i = 0;
        foreach ($article_distinct as $elem) {
            $article_ids = array();
            $sql2 = 'select * from articles where titre="' . $elem['titre'] . '"';
            $nombre_titre = $action->nombre_row($sql2);
            $plusieur_titre = $action->get_list($sql2);
            foreach ($plusieur_titre as $value) {
                $liste_array = explode(',', $value['liste_id_auteurs']);
                $lesauteurs = '';
                $test = "True";
                for ($k = 0; $k <= count($liste_array) - 2; $k++) {
                    for ($j = $k + 1; $j <= count($liste_array) - 1; $j++) {
                        if ($liste_array[$k] == $liste_array[$j]) {
                            $test = "False";
                        }
                    }
                }
                if ($test == "False") {
                    foreach ($liste_array as $pt) {
                        $row = $action->get_row("select * from utilisateurs where id='$pt'");
                        $lesauteurs .='<p><a href="">  ' . $row['nom'] . ' ' . $row['prenom'] . ' (' . $row['organisation'] . ')</a>' . '</p>';
                    };
                    ++$i;
                    $syntaxe .='<tr>';
                    $syntaxe .='<td>' . $i . '</td>';
                    $syntaxe .='<td style="text-align: justify;">' . $value["titre"] . '</td>';
                    $syntaxe .='<td>' . $value["annee"] . '</td>';
                    $syntaxe .='<td>' . $value["etat"] . '</td>';
                    $syntaxe .='<td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#titre' . $i . '">Détail</button></td>';
                    $syntaxe .='<td><form method="POST" action="admin.php">'
                            . '<input type="hidden" name="id_article" value=' . $value['id'] . '>'
                            . '<input type="hidden" name="mem_auteurs" value="">'
                            . '&nbsp;&nbsp;&nbsp;&nbsp;<input name="supprimer_article" class="btn btn-danger btn-sm" type="submit" onclick="return confirmer();" value="-"></form></td>';
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
    $article_ids = array();
    $sql2 = 'select * from articles where titre="' . $elem['titre'] . '"';
    $nombre_titre = $action->nombre_row($sql2);
    $plusieur_titre = $action->get_list($sql2);
    foreach ($plusieur_titre as $value) {
        $liste_array = explode(',', $value['liste_id_auteurs']);
        $test = "True";
        for ($k = 0; $k <= count($liste_array) - 2; $k++) {
            for ($j = $k + 1; $j <= count($liste_array) - 1; $j++) {
                if ($liste_array[$k] == $liste_array[$j]) {
                    $test = "False";
                }
            }
        }
        if ($test == "False") {
            ++$i;
            $id_article = $value['id'];
            require 'contenu_article_admin.php';
        }
    }
}
?>