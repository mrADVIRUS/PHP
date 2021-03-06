
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

    $uploadDir = 'Pictures/';
    $filePath = '';
    if(isset ($_FILES ['userfile'])) {
        //echo '<br>File uploaded<br>';
        $fileName = $_FILES['userfile']['name'];
        $tmpName = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];

        if($fileType=='image/jpeg' || $fileType=='image/png' || $fileType=='image/gif' || $fileType=='image/jpeg') {
            // get the file extension first
            $ext = substr(strrchr($fileName, "."), 1);
            // make the random file name
            $randName = md5(rand() * time());

            $filePath = $uploadDir . $randName . '.' . $ext;
            echo '<br>Path: '. $filePath .'<br>';
            $result = move_uploaded_file($tmpName, $filePath);
            if (!$result) {
                echo "Error uploading file";
                exit;
            }

            //echo "<img src='". $filePath ."' alt=\"Logo\" width=\"100\" height=\"150\" />";
        } else {
            $formflag = false;
            $err[] = "Uploaded file is not image format! Need to select format file png, gif or jpeg.";
        }

    } else {
        echo '<br>File not uploaded<br>';
    }


    //check the form, if ok - save a new user to DB
    if ($formflag) {
        //include DB Class
        include_once 'db.php';

        $db = new DB();

        $user = array('login'=>$login, 'psw'=>$password, 'fio'=>$fullName, 'email'=>$email, 'status'=>$family_status, 'city'=>$city, 'date'=>$date, 'phone'=>$phone, 'education'=>$education, 'experience'=>$experience, 'info'=>$info, 'filepath'=>$filePath);
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

