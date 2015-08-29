
<?php
header('Content-Type: text/html; charset=utf-8');
if(isset($_POST)) {
    $formflag = true;
    $err = array();
    echo 'Incoming POST';
    //required field
    $login      = $_POST["login"];
    $password   = $_POST["password"];
    $email      = $_POST["email"];
    $fullName   = $_POST["fullName"];

    //optional field
    /*$date           = isset($_POST["date"]) ? $_POST["date"] : "";
    $city           = isset($_POST["city"]) ? $_POST["city"] : "";
    $family_status  = isset($_POST["familyStatus"]) ? $_POST["familyStatus"] : false;
    $phone          = isset($_POST["phone"]) ? $_POST["phone"] : "";
    $education      = isset($_POST["education"]) ? $_POST["education"] : "";
    $experience     = isset($_POST["experience"]) ? $_POST["experience"] : "";
    $info           = isset($_POST["info"]) ? $_POST["info"] : "";*/

    $date           = $_POST["date"];
    $city           = $_POST["city"];
    $family_status  = $_POST["familyStatus"];
    $phone          = $_POST["phone"];
    $education      = $_POST["education"];
    $experience     = $_POST["experience"];
    $info           = $_POST["info"];

    //validation
    if(strlen($login) < 3) {
        $formflag = false;
        $err[] = "Login must be greater than 3 characters!";
    }
    if(strlen($fullName) < 5) {
        $formflag = false;
        $err[] = "Full name must be greater than 5 characters!";
    }
    if(strlen($password) < 8) {
        $formflag = false;
        $err[] = "Password must be greater than 8 characters!";
    }
    if (!preg_match("#[0-9]+#", $password)) {
        $formflag = false;
        $err[] = "Password must include at least one number!";
    }

    if (!preg_match("#[a-zA-Z]+#", $password)) {
        $formflag = false;
        $err[] = "Password must include at least one letter!";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formflag = false;
        $err[] = "You have not entered a valid email address";
    }

    //check the form, if ok - save a new user to DB
    if ($formflag) {
        //include DB Class
        include_once 'db.php';

        $db = new DB();

        $user = array('login'=>$login, 'psw'=>$password, 'fio'=>$fullName, 'email'=>$email, 'status'=>$family_status, 'city'=>$city, 'date'=>$date, 'phone'=>$phone, 'education'=>$education, 'experience'=>$experience, 'info'=>$info);
        $flag = $db->registryCustomer($user);
        if (!$flag) {
            echo "Something wrong";
            exit;
        } else {
            echo 'Registry successful';
        }
    }

    $returndata = array(
        'posted_form_data' => array(
            'login' => $login,
            'email' => $email,
            'fio' => $fullName,
            'status' => $family_status,
            'city' => $city,
            'date' => $date,
            'phone' => $phone,
            'education' => $education,
            'experience' =>$experience,
            'info' => $info
        ),
        'form_ok' => $formflag,
        'errors' => $err
    );

    session_start();
    $_SESSION['returndata'] = $returndata;
    //redirect back to form
    header('location: ' . $_SERVER['HTTP_REFERER']);
}


/*//include DB Class
include_once 'db.php';

$db = new DB();
$checkLogin = $db->checkLogin($login);
if ($checkLogin) {
    $againReg = "<a href=\"registry.php\">again registry</a>";
    p('Login exists. Goto '. $againReg. ' for change data');
    exit;
} else {
    $arr = array('login'=>$login, 'psw'=>$password, 'fio'=>$fullName, 'email'=>$email, 'status'=>$family_status, 'city'=>$city, 'date'=>$date, 'phone'=>$phone, 'education'=>$education, 'experience'=>$experience, 'info'=>$info);
    $flag = $db->registryCustomer($arr);
    if (!$flag) {
        p("Something wrong");
        exit;
    } else {
        //goto to form index.html
        $indexPage = "<a href=\"index.html\">Home page</a>";
        p('Registry successful. Goto '. $indexPage);
    }
}


function p($x){print "<div>$x</div>";}*/
