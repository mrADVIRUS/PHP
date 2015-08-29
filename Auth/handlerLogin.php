<?php
header('Content-Type: text/html; charset=utf-8');

// define variables and set to empty values
$login = $password = "";
//p('Login1 = '.$login);
if(isset($_POST['login']) && isset($_POST['password'])) {
    include_once 'db.php';
    $db = new DB();

    $login    = $_POST['login'];
    $password = $_POST['password'];
//    p('login2 = '.$login.' psw = '.$password);
    $checkLogin = $db->checkLogin($login);
    if ($checkLogin) {
        $res = $db->checkUserInDB($login, $password);
//        print_r($res);
        if($res['status'] == true)
        {
            # Ставим куки
            setcookie("auth_login", $res['login'], time()+60*60*24*30);
            setcookie("auth_UDID", $res['hash'], time()+60*60*24*30);

            # Переадресовываем браузер на страницу с главную страницу с дополнительной информацией
            header("Location: main.php");
            exit;
        } else {
            p('Неверный пароль');
            echo "<p><a href='javascript:history.back(-1);'>Back</a></p>";
        }
    } else {
        p('Неверный логин');
        echo "<p><a href='javascript:history.back(-1);'>Back</a></p>";
        exit;
    }
}

function p($x){print "<div>$x</div>";}
