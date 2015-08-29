<?php
header('Content-Type: text/html; charset=utf-8');

class DB {
    private $dbh;

    function  __construct()
    {
        include "dbconnection.php";
        try {
            $this->dbh = new PDO("mysql:host={$connection['host']};dbname={$connection['dbname']};charset=utf8", "{$connection['adminDB']}", "{$connection['passw']}");
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->dbh->query("SET NAMES UTF8;");
        }
        catch (PDOException $ex)
        {
            echo "ERROR: ".$ex->getMessage();
            $msg = "DB -> construct(): ERROR [".$ex->getMessage()."]";
            $this->SaveMsgToFile($msg);
        }
    }

    ///////////////////////////////////////////
    //DB Methods

    //check login in DB
    function checkLogin($login) {
        try {
            $STH = $this->dbh->prepare("SELECT * FROM users WHERE user_login = ?");
            $STH->execute([$login]);

            if ($STH->rowCount() > 0) //Login find
            {
                return true;
            }
        }
        catch (PDOException $ex)
        {
            echo "ERROR: ".$ex->getMessage();
            $msg = "checkLogin(): ERROR [".$ex->getMessage()."]";
            $this->SaveMsgToFile($msg);
        }
        return false;
    }

    //check user & psw exist in DB
    function checkUserInDB($login, $psw) {
        try {
            $hash = $this->encrypt($psw);
            $STH = $this->dbh->prepare("SELECT * FROM users WHERE user_login = ? AND user_hash = ?");
            $STH->execute([$login, $hash]);

            if ($STH->rowCount() > 0) //User find
            {
                $user = $STH->fetch(PDO::FETCH_ASSOC);
                return array('status' => 1, 'login' => $user['user_login'], 'hash' => $hash);
            }
        }
        catch (PDOException $ex)
        {
            echo "ERROR: ".$ex->getMessage();
            $msg = "checkUserInDB(): ERROR [".$ex->getMessage()."]";
            $this->SaveMsgToFile($msg);
        }
        return array('status' => 0, 'login' => '', 'hash' => '');
    }

    //save new User in DB
    function registryCustomer ($arr) {
        $hash = $this->encrypt($arr['psw']);
        $data = array($arr['login'], $arr['psw'], $hash, $arr['fio'], $arr['email'], $arr['status'], $arr['city'], $arr['date'], $arr['phone'], $arr['education'], $arr['experience'], $arr['info']);
        try {
            $STH = $this->dbh->prepare("INSERT INTO users (`user_login`, `user_password`, `user_hash`, `user_fio`, `user_email`, `user_family_status`, `user_city`, `user_date`, `user_phone`, `user_education`, `user_experience`, `user_about`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $status = $STH->execute($data);
            return $status;
        }
        catch (PDOException $ex)
        {
            echo "ERROR: ".$ex->getMessage();
            $msg = "registryCustomer(): ERROR [".$ex->getMessage()."]";
            $this->SaveMsgToFile($msg);
        }
        return false;
    }

    //function return all info about user
    function getInfo($login) {
        try {
            $STH = $this->dbh->prepare("SELECT * FROM users WHERE user_login = ?");
            $STH->execute([$login]);

            if ($STH->rowCount() > 0) //User find
            {
                $user = $STH->fetch(PDO::FETCH_ASSOC);
                return $user;
            }
        }
        catch (PDOException $ex)
        {
            echo "ERROR: ".$ex->getMessage();
            $msg = "checkUserInDB(): ERROR [".$ex->getMessage()."]";
            $this->SaveMsgToFile($msg);
        }
        return array();
    }

    //save message to file-log
    private function SaveMsgToFile($message) {
        $data = sprintf("%s\n", $message);
        $file = "PDOErrors.txt";
        file_put_contents($file, $data, FILE_APPEND);
    }

    //encrypt password
    private function encrypt($str){
        $salt = 'lfyerbt8ghhw0er';
        return md5($salt. md5($str));
    }
}
