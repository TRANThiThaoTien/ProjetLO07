<?php

require_once '../php_sql_action.php';
$action = new DB_driver();
if (isset($_POST["modifier_titre_action"])) {
    $data = array('titre' => $_POST["titre"]);
    $where = 'id="' . $_POST['id_article'] . '"';
    $action->update('articles', $data, $where);
};
if (isset($_POST["supprimer_auteur"])) {
    $sql = 'select * from articles where id = "' . $_POST["id_article"] . '";';
    $article = $action->get_row($sql);
    $array_auteurs = explode(',', $article["liste_id_auteurs"]);
    $array_auteurs_new = array();
    foreach ($array_auteurs as $elem) {
        if ($elem != $_POST["id_auteur"]) {
            $array_auteurs_new[] = $elem;
        };
    };
    $liste_id_auteurs = implode(',', $array_auteurs_new);
    $data = array('liste_id_auteurs' => $liste_id_auteurs);
    $where = 'id="' . $_POST['id_article'] . '"';
    $action->update('articles', $data, $where);
}

if (isset($_POST["changer_ordre"])) {
    $length = 0;
    foreach ($_POST['id_auteurs'] as $ele) {
        $length = $length + 1;
        $id_auteurs[$length] = addslashes($ele);
    };
    for ($i = 1; $i <= $length - 1; $i++) {
        for ($j = $i + 1; $j <= $length; $j++) {
            if ($id_auteurs[$i] == $id_auteurs[$j]) {
                echo "Il y a eurrer, deux ordre a le même auteur! <a href='javascript: history.go(-1)'>Retour</a>";
                exit();
            }
        }
    };
    $liste_id_auteurs = implode(',', $id_auteurs);
    $data = array('liste_id_auteurs' => $liste_id_auteurs);
    $where = 'id="' . $_POST['id_article'] . '"';
    $action->update('articles', $data, $where);
}
?>