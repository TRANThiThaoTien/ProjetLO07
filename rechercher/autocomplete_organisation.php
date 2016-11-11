<?php
header('Content-Type: text/html; charset=UTF-8');
if (isset($_GET['term'])) {
    require_once '../php_sql_action.php';
    $org = $_GET['term'];
    $sql = 'SELECT organisation from utilisateurs where organisation like "%' . $org . '%" ';
    $action = new DB_driver();
    $liste_titre_articles = $action->get_list($sql);

    $results = array();
    $i = 0;
    foreach ($liste_titre_articles as $value) {
        $a=array('label' => strtoupper($value['organisation']));
        if (!in_array($a, $results)) {
            $results[] = array('label' => strtoupper($value['organisation']));
            ++$i;
            if ($i == 10) {
                break;
            }
        }
    }
    echo json_encode($results);
}
?>