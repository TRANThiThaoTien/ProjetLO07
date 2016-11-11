<?php

$errors = array(
    'error' => 0);
$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$mdp = isset($_POST['mdp']) ? trim($_POST['mdp']) : '';
if (empty($login)) {
    $errors['login'] = 'Entrez votre identifiant, svp!';
}
if (empty($mdp)) {
    $errors['mdp'] = 'Entrez votre mot de passe, svp!';
}
if (count($errors) > 1) {
    $errors['error'] = 1;
    die(json_encode($errors));
}
require_once '../php_sql_action.php';
$action = new DB_driver();
$login = addslashes($login);
$mdp = addslashes($mdp);
$mdp = md5($mdp);

$sql = "SELECT * FROM utilisateurs WHERE login='" . $login . "' and password='" . $mdp . "'";
if ($action->nombre_row($sql) ==0) {
    $errors['verifier'] = 'Identifiant ou mot de passe incorrect';
} else{
    $ligne=$action->get_row($sql);
    session_start(); 
    $_SESSION['id_connexion']=$ligne["id"];
}
if (count($errors) > 1) {
    $errors['error'] = 1;
}
die(json_encode($errors));
?>