<script language="javascript">
    $('#contenu').html('');
    
    $("#utilisateurs").attr("class", "active");
    $('#articles').removeAttr('class');
    

</script>
<h2 class='text-center' style="font-weight: bold ;font-size: 1.6em;" >La liste d'utilisateur</h2>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>Ordre</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Organisation</th>
            <th>laboratoire</th>
            <th>Email</th>
            <th>Identifiant</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../php_sql_action.php';
        $action = new DB_driver();
        $sql = 'select * from utilisateurs where login !="" order by level_utilisateur, nom; ';
        $liste_utilisateurs = $action->get_list($sql);
        $syntaxe = '';
        $i = 0;
        foreach ($liste_utilisateurs as $elem) {
            ++$i;
            $syntaxe .='<tr>';
            $syntaxe .='<td>' . $i . '</td>';
            $syntaxe .='<td>' . $elem["nom"] . '</td>';
            $syntaxe .='<td>' . $elem["prenom"] . '</td>';
            $syntaxe .='<td>' . $elem["organisation"] . '</td>';
            $syntaxe .='<td>' . $elem["laboratoire"] . '</td>';
            $syntaxe .='<td>' . $elem["email"] . '</td>';
            $syntaxe .='<td>' . $elem["login"] . '</td>';
            if ($elem["level_utilisateur"] == 'utilisateur') {
                $syntaxe .='<td><form method="POST" action="admin.php">'
                        . '<input type="hidden" name="id_utilisateur" value=' . $elem['id'] . '>'
                        . '<input type="hidden" name="utilisateurs" value="">'
                        . '&nbsp;&nbsp;&nbsp;&nbsp;<input name="supprimer_utilisateur" class="btn btn-danger btn-sm" type="submit" onclick="return confirmer2();" value="-"></form></td>';
            } else {
                $syntaxe .='<td></td>';
            }
            $syntaxe .='</tr>';
        }
        echo $syntaxe;
        ?>
    </tbody>
</table>
