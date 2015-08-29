<?php
$login = $_GET['login'];

//include DB Class
include_once 'db.php';

$db = new DB();
$checkLogin = $db->checkLogin($login);

if ($checkLogin) {
    $responce = array('status' => false, 'msg' => 'This login \''.$login.'\' is already in use');
    echo json_encode($responce);
} else {
    $responce = array('status' => true, 'msg' => 'This login is available');
    echo json_encode($responce);
}
