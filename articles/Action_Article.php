
<?php

require_once '../php_sql_action.php';
$action = new DB_driver();

$titre = addslashes(trim($_POST['titre']));
$annee = addslashes(trim($_POST['annee']));
$lieu = addslashes(trim($_POST['lieu']));

foreach ($_POST['nom_auteurs'] as $ele) {
    $nom_auteurs[] = addslashes(trim($ele));
};
foreach ($_POST["prenom_auteurs"] as $ele) {
    $prenom_auteurs[] = addslashes(trim($ele));
}
foreach ($_POST["organisation"] as $ele) {
    $organisation[] = addslashes(trim($ele));
}
foreach ($_POST["laboratoire"] as $ele) {
    $laboratoire[] = addslashes(trim($ele));
}

$resume = addslashes(trim($_POST['resume']));
$categorie = addslashes(trim($_POST['categorie']));
$photo = '';


if ($_FILES['photo']['name'] != NULL) {
    if ($_FILES['photo']['type'] == "image/jpeg" || $_FILES['photo']['type'] == "image/png" || $_FILES['photo']['type'] == "image/gif" || $_FILES['photo']['type'] == "image/jpg") {
        $path = "../images/";
        $tmp_name = $_FILES['photo']['tmp_name'];
        $name = $_FILES['photo']['name'];
        $sql = "select * from articles where photo='$name';";
        $test = $action->nombre_row($sql);
        if ($test != 0) {
            $i = 1;
            $kt = false;
            if ($_FILES['photo']['type'] == "image/png" || $_FILES['photo']['type'] == "image/gif" || $_FILES['photo']['type'] == "image/jpg") {
                while ($kt == false) {
                    $photo = substr($name, 0, strlen($name) - 3) . $i . substr($name, strlen($name) - 3, 3);
                    $sql2 = "select * from articles where photo='$photo';";
                    $test2 = $action->nombre_row($sql2);
                    if ($test2 == 0) {
                        $kt = true;
                    }
                    $i=$i+1;
                }
            }
            elseif ($_FILES['photo']['type'] == "image/jpeg") {
                while ($kt == false) {
                    $photo = substr($name, 0, strlen($name) - 4) . $i . substr($name, strlen($name) - 4, 4);
                    $sql2 = "select * from articles where photo='$photo';";
                    $test2 = $action->nombre_row($sql2);
                    if ($test2 == 0) {
                        $kt = true;
                    }
                    $i=$i+1;
                }
            }
        } else {
            $photo = $name;
        }
        move_uploaded_file($tmp_name, $path . $photo);

        require_once 'resize_image.php';
        $image = new SimpleImage();
        $image->load($path . $photo);
        $image->resize(400, 360);
        $image->save($path . $photo);
    }
} else {
    $photo = 'default.jpg';
}
$current = date('Y/m/d h:i:s');
$id_auteurs = array();
$i = -1;

foreach ($nom_auteurs as $elem) {
    $i = $i + 1;
    $sql = "select * from utilisateurs where nom='$nom_auteurs[$i]' and prenom='$prenom_auteurs[$i]' and organisation='$organisation[$i]' and laboratoire='$laboratoire[$i]'";
    if ($action->nombre_row($sql) != 0) {
        $list = $action->get_row($sql);
        $id_auteurs[] = $list['id'];
    } else {
        $data = array('nom' => $nom_auteurs[$i],
            'prenom' => $prenom_auteurs[$i],
            'organisation' => $organisation[$i],
            'laboratoire' => $laboratoire[$i]);
        $action->insert('utilisateurs', $data);
        $list = $action->get_row($sql);
        $id_auteurs[] = $list['id'];
    };
};
$etat = 'En attente';
$liste_id_auteurs = implode(',', $id_auteurs);
$data = array(
    'titre' => $titre,
    'categorie' => $categorie,
    'resume' => $resume,
    'annee' => $annee,
    'lieu' => $lieu,
    'etat' => $etat,
    'liste_id_auteurs' => $liste_id_auteurs,
    'photo' => $photo,
    'temps' => $current);
$action->insert('articles', $data);
?>  
