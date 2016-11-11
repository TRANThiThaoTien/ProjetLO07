<?php
require_once '../php_sql_action.php';
$action = new DB_driver();
$sql = "select * from articles";
$liste_article = $action->get_list($sql);
$array_id_auteurs = array();
foreach ($liste_article as $elem) {
    $array_id_auteurs_test = explode(',', $elem['liste_id_auteurs']);
    foreach ($array_id_auteurs_test as $id1) {
        $sql2 = "select * from utilisateurs where id='$id1'";
        $nombre = $action->nombre_row($sql2);
        if ($nombre != 0) {
            $auteur = $action->get_row($sql2);
            if (!in_array($auteur['id'], $array_id_auteurs)) {
                $array_id_auteurs[] = $auteur['id'];
            }
        }
    }
}
?>
<h3>Rechercher les co-auteurs du chercheur : </h3>
<form method="get" action="../rechercher/recherche.php">
    <div class="form-group"
         <label>Choisir un chercheur de l'UTT  </label>
        <select name="id_auteur_rc">
            <?php
            foreach ($array_id_auteurs as $value) {
                $sql3 = "select * from utilisateurs where id='$value' ";
                $auteur = $action->get_row($sql3);
                echo '<option value="' . $auteur['id'] . '">' . $auteur['nom'] . ' ' . $auteur['prenom'] . ' - ' . $auteur['laboratoire'] .' - ' . $auteur['organisation'] . '</option>';
            }
            ?>
        </select>
    </div>
    <input class="btn btn-default" type="submit" name="submit_coauteur" value="Rechercher">
</form>
