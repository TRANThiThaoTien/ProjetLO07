<?php

header('Content-Type: text/html; charset=UTF-8');

$nom_auteur = trim($_POST['nom_auteur']);
$prenom_auteur = trim($_POST['prenom_auteur']);
$organisation = trim($_POST['organisation']);
$laboratoire = trim($_POST['laboratoire']);
$liste_id_auteurs = trim($_POST['liste_id_auteurs']);
$id_article=$_POST["id_article"];
require_once '../php_sql_action.php';
$action = new DB_driver();
$errors = array(
    'error' => '0',
    'nom_auteur' => '',
    'prenom_auteur' => '',
    'organisation' => '',
    'text' => ''
);
foreach ($_POST as $key => $value) {
    if ($value == '') {
        $errors['error'] = '1';
        $errors[$key] = "Ce champ est obligatoire.";
    }
}
$array_id_auteurs = explode(' ', $liste_id_auteurs);
if ($errors['error'] == '0') {
    $sql1 = "select * from utilisateurs where nom='$nom_auteur' and prenom='$prenom_auteur' and organisation='$organisation' and laboratoire='$laboratoire' ";
    $ligne = $action->get_row($sql1);
    if ($action->nombre_row($sql1) != 0) {
        foreach ($array_id_auteurs as $elem) {
            if ($elem == $ligne['id']) {
                $errors['error'] = '1';
                $errors['text'] = "Cet auteur a été présenté dans cet article.";
            }
        }
    };
}

if ($errors['error'] == '0') {
        $sql1 = 'select * from articles where id = "' . $id_article . '";';
        $article = $action->get_row($sql1);
        $sql = "select * from utilisateurs where nom='$nom_auteur' and prenom='$prenom_auteur' and organisation='$organisation' and laboratoire='$laboratoire'";
        if ($action->nombre_row($sql) != 0) {
            $list = $action->get_row($sql);
            $array_id_auteurs[] = $list['id'];
        } else {
            $data = array('nom' => $nom_auteur,
                'prenom' => $prenom_auteur,
                'organisation' => $organisation,
                'laboratoire' => $laboratoire);
            $action->insert('utilisateurs', $data);
            $list = $action->get_row($sql);
            $array_id_auteurs[] = $list['id'];
        };

        $liste_id_auteurs = implode(',', $array_id_auteurs);
        $data2 = array('liste_id_auteurs' => $liste_id_auteurs);
        $where = 'id="' . $_POST['id_article'] . '"';
        $action->update('articles', $data2, $where);
};
die(json_encode($errors));
?>
