<?php

/* header('Content-Type: text/html; charset=UTF-8'); */

function afficher_partiel_main($categorie) {
    require_once "../php_sql_action.php";
    $action = new DB_driver();

    $sql = 'select * from articles where categorie="' . $categorie . '" order by id desc ;';

    $nombre = $action->nombre_row($sql);
    $syntaxe = '';
    if ($nombre != 0) {
        $resultat = $action->get_list($sql);
        $syntaxe .= '<table width="100%" class="table_contenu">';
        $i = 0;
        foreach ($resultat as $ligne) {
            if ($ligne["etat"] == "Publié") {
                $i = $i + 1;
                if ($i == 1) {
                    $syntaxe .='<tr>
                    <td rowspan="5">
                        <p style="border-bottom: 1px solid #ddd; padding :2px; padding-right : 12px "><a href="../accueil/index.php?id_article=' . $ligne["id"] . '"><b>' . $ligne["titre"] . '</a></b></p>';
                    $syntaxe .='<div class="row"><div class="col-md-4"><a href="../accueil/index.php?id_article=' . $ligne["id"] . '"><img class="img-thumbnail img-responsive"   src="../images/' . $ligne['photo'] . '"/></a></div>'
                            . '<div class="col-md-6"> <p style=" padding :2px; padding-right : 12px" >' . substr($ligne["resume"], 0, 200) . '...</p></div>'
                            . '</td>'
                            . '</div>';
                };
                if ($nombre == 1) {
                    $syntaxe .='</tr>';
                };
                if ($i == 2) {
                    $syntaxe .='<td><a href="../accueil/index.php?id_article=' . $ligne["id"] . '">' . $ligne["titre"] . '</a></td>
                </tr> ';
                };
                if ($i >= 3) {
                    $syntaxe .='<tr>
                    <td><a href="../accueil/index.php?id_article=' . $ligne["id"] . '">' . $ligne["titre"] . '</a></td>
                </tr> ';
                }
                if ($i == 6)
                    break;
            }
        };
        $syntaxe .='</table>';
    };
    return $syntaxe;
}

;
?>