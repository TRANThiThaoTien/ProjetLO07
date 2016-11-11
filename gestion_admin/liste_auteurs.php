<script language="javascript">
    $('#contenu').html('');
    $("#auteurs").attr("class", "active");
    $('#articles').removeAttr('class');


</script>
<h2 class='text-center' style="font-weight: bold ;font-size: 1.6em;" >La liste des auteurs</h2>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>Ordre</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Organisation</th>
            <th>laboratoire</th>
            <th>Le nombre de publication</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../php_sql_action.php';
        $action = new DB_driver();
        $sql = 'select * from utilisateurs where level_utilisateur="utilisateur" order by nom asc';
        $liste_utilisateurs = $action->get_list($sql);
        $syntaxe = '';
        $i = 0;
        foreach ($liste_utilisateurs as $elem) {
            $sql2 = "select * from articles where (liste_id_auteurs like '" . $elem['id'] . ",%' || liste_id_auteurs like '%," . $elem['id'] . ",%' || liste_id_auteurs like '%," . $elem['id'] . "') && etat='Publié'";
            $nombre = $action->nombre_row($sql2);
            if ($nombre != 0) {
                ++$i;
                $syntaxe .='<tr>';
                $syntaxe .='<td>' . $i . '</td>';
                $syntaxe .='<td>' . $elem["nom"] . '</td>';
                $syntaxe .='<td>' . $elem["prenom"] . '</td>';
                $syntaxe .='<td>' . $elem["organisation"] . '</td>';
                $syntaxe .='<td>' . $elem["laboratoire"] . '</td>';
                $syntaxe .='<td> <button type="button" class="btn btn-link" data-toggle="modal" data-target="#auteur' . $i . '">' . $nombre . '</button></td>';
                $syntaxe .='</tr>';
            }
        }
        echo $syntaxe;
        ?>
    </tbody>
</table>

<?php
$i = 0;
foreach ($liste_utilisateurs as $elem) {
    $sql2 = "select * from articles where (liste_id_auteurs like '" . $elem['id'] . ",%' || liste_id_auteurs like '%," . $elem['id'] . ",%' || liste_id_auteurs like '%," . $elem['id'] . "') && etat='Publié'";
    $nombre = $action->nombre_row($sql2);
    if ($nombre != 0) {
        ++$i;
        $ligne = $action->get_list($sql2);
        ?>
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="auteur<?php echo $i; ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <?php
                        echo '<b>Les articles de l\'auteur' . $elem['nom'] . ' ' . $elem['prenom'] . ' - ' . $elem['laboratoire'] . ' - ' . $elem['organisation'] . ': </b>';
                        ?>
                    </div>
                    <div class="modal-body">
                        <?php
                        foreach ($ligne as $value) {
                            echo '<p><a href="../accueil/index.php?id_article=' . $value['id'] . '" target="_blank">' . $value['titre'] . '</a></p>';
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require 'contenu_article_admin.php';
    }
}
?>


