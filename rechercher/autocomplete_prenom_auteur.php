<?php
header('Content-Type: text/html; charset=UTF-8');
if (isset($_GET['term'])) {
    require_once '../php_sql_action.php';
    $auteur = $_GET['term'];
    $sql = 'SELECT nom,prenom from utilisateurs where prenom like "%' . $auteur . '%" ';
    $action = new DB_driver();
    $liste_titre_articles = $action->get_list($sql);
    $results = array();
    $i = 0;
    foreach ($liste_titre_articles as $value) {
        $a=array('label' => $value['prenom']);
        if (!in_array($a, $results)) {
            $results[] = array('label' => $value['prenom']);
            ++$i;
            if ($i == 10) {
                break;
            }
        }
    }
    echo json_encode($results);
}
?>