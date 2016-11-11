<h2 class='text-center' style="font-weight: bold ;font-size: 1.6em; ">La liste d'articles</h2>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>Ordre</th>
            <th>Titre</th>
            <th>Année</th>
            <th width='10%'>État</th>
            <th>Détail</th>
            <th>Publier</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../php_sql_action.php';
        $action = new DB_driver();
        $sql = 'select * from articles order by etat,id desc;';
        $liste_articles = $action->get_list($sql);
        $syntaxe = '';
        $i = 0;
        foreach ($liste_articles as $elem) {
            ++$i;
            $syntaxe .='<tr>';
            $syntaxe .='<td>' . $i . '</td>';
            $syntaxe .='<td style="text-align: justify;">' . $elem["titre"] . '</td>';
            $syntaxe .='<td>' . $elem["annee"] . '</td>';
            $syntaxe .='<td>' . $elem["etat"] . '</td>';
            $syntaxe .='<td> <button type="button" class="btn btn-link" data-toggle="modal" data-target="#titre' . $i . '">Détail</button></td>';
            if ($elem["etat"] == 'En attente') {
                $syntaxe .='<td><form method="POST" action="admin.php">'
                        . '<input type="hidden" name="id_article" value=' . $elem['id'] . '>'
                        . '<input type="hidden" name="articles" value="">'
                        . '&nbsp;&nbsp;&nbsp;<input name="publier_article" class="btn btn-primary btn-sm" type="submit" value="+"></form></td>';
            } else {
                $syntaxe .='<td></td>';
            }
            $syntaxe .='<td><form method="POST" action="admin.php">'
                    . '<input type="hidden" name="id_article" value=' . $elem['id'] . '>'
                    . '<input type="hidden" name="articles" value="">'
                    . '&nbsp;&nbsp;&nbsp;&nbsp;<input name="supprimer_article" class="btn btn-danger btn-sm" type="submit" onclick="return confirmer();" value="-"></form></td>';
            $syntaxe .='</tr>';
        }
        echo $syntaxe;
        ?>
    </tbody>
</table>

<?php
$i = 0;
foreach ($liste_articles as $elem) {
    ++$i;
    $id_article = $elem['id'];
    require 'contenu_article_admin.php';
}
?>

