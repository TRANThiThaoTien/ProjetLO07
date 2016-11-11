<?php 
session_start(); 
 
if (isset($_SESSION['id_connexion'])){
    unset($_SESSION['id_connexion']); // xóa session login
}
?>
