<?php

if (isset($_GET['term'])) {
    require_once '../php_sql_action.php';
    $titre_recherche = $_GET['term'];
    $sql = 'SELECT titre,etat from articles where titre like "%' . $titre_recherche . '%" ';
    $action = new DB_driver();
    $liste_titre_articles = $action->get_list($sql);

    $results = array();
    $i = 0;
    foreach ($liste_titre_articles as $value) {
        if ($value['etat'] == 'Publié') {
            $results[] = array('label' => $value['titre']);
            ++$i;
            if ($i == 10) {
                break;
            }
        }
    }
    echo json_encode($results);
}
?>

