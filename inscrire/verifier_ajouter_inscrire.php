
<?php

header('Content-Type: text/html; charset=UTF-8');

$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$login = trim($_POST['login']);
$mdp = trim($_POST['mdp']);
$confirm_mdp = trim($_POST['confirm_mdp']);
$organisation = trim($_POST['organisation']);
$laboratoire = trim($_POST['laboratoire']);
$email = trim($_POST['email']);
$confirm_email = trim($_POST['confirm_email']);


$mdp = md5($mdp);
$confirm_mdp = md5($confirm_mdp);

require_once '../php_sql_action.php';
$action = new DB_driver();
$errors = array(
    'error' => '0',
    'nom' => '',
    'prenom' => '',
    'login' => '',
    'mdp' => '',
    'confirm_mdp' => '',
    'organisation' => '',
    'email' => '',
    'confirm_email' => '',
    'compte' => ''
);
foreach ($_POST as $key => $value) {
    if ($value == '') {
        $errors['error'] = '1';
        $errors[$key] = "Ce champ est obligatoire.";
    } else {

        if ($key == 'login') {
            $Rule = '/^[a-zA-Z0-9_]{6,}$/';
            if (strlen($_POST['login']) < 6) {
                $errors['login'] = "Veuillez utiliser à partir de 6 caractères.";
                $errors['error'] = '1';
            } elseif (!preg_match($Rule, $value, $matches)) {
                $errors['login'] = "L'identifiant ne doit pas contenir des caractères spéciaux.";
                $errors['error'] = '1';
            } else {
                $action = new DB_driver();
                $text = $action->nombre_row("select * from utilisateurs where login='$login'");
                if ($text != 0) {
                    $errors['login'] = "Cet identifiant est déjà attribué. Voulez-vous en essayer un autre ?";
                    $errors['error'] = '1';
                }
            }
        }
        if ($key == 'email') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['error'] = '1';
                $errors['email'] = "Veuillez saisir une adresse e-mail valide.(Par exemple: abc@gmail.com)";
            } else {
                $text = $action->nombre_row("select * from utilisateurs where email='$email'");
                if ($text != 0) {
                    $errors['email'] = "Cet address email est déjà attribué. Voulez-vous en essayer un autre?";
                    $errors['error'] = '1';
                }
            }
        }
        if ($key == 'confirm_email' && $confirm_email != $email) {
            $errors['confirm_email'] = "L'adresse email ne correspondent pas. Voulez-vous réessayer?";
            $errors['error'] = '1';
        }
        if ($key == 'mdp') {
            if (strlen($_POST['mdp']) < 6) {
                $errors['mdp'] = "Veuillez utiliser à partir de 6 caractères.";
                $errors['error'] = '1';
            }
        }
        if ($key == 'confirm_mdp' && $confirm_mdp != $mdp) {
            $errors['confirm_mdp'] = "Les mots de passe ne correspondent pas. Voulez-vous réessayer?";
            $errors['error'] = '1';
        }
    }
}
if ($nom != '' && $prenom != '') {
    $sql3 = "select * from utilisateurs where nom='$nom' && prenom='$prenom' && laboratoire='$laboratoire' ";
    if ($action->nombre_row($sql3) != 0) {
        $row = $action->get_row($sql3);
        if ($row['login'] != '') {
            $errors['compte'] = "Vous allez déjà créé un compte. Contactez l'admin pour obtenir votre compte!";
            $errors['error'] = '1';
        }
    }
}
if ($errors['error'] == '0') {

    $sql1 = "select * from utilisateurs where nom='$nom' and prenom='$prenom' and organisation='$organisation' and laboratoire='$laboratoire' ";
    $ligne = $action->get_row($sql1);
    if ($action->nombre_row($sql1) != 0 && $ligne['login'] == '') {
        $data = array('login' => $login,
            'password' => $mdp,
            'email' => $email,
            );
        $where = " nom='$nom' && prenom='$prenom' && organisation='$organisation' && laboratoire='$laboratoire'";
        $action->update('utilisateurs', $data, $where);
    } else {
        $data = array('nom' => $nom,
            'prenom' => $prenom,
            'login' => $login,
            'password' => $mdp,
            'organisation' => $organisation,
            'email' => $email,
            'level_utilisateur' => 'utilisateur',
            'laboratoire' => $laboratoire);
        $action->insert('utilisateurs', $data);
    };
}
die(json_encode($errors));
?>

