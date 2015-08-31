<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/stylemain.css">
    <title>About user</title>
</head>
<body>
<?php
header('Content-Type: text/html; charset=utf-8');
$userData = array();
if (isset($_COOKIE['auth_login']) && isset($_COOKIE['auth_UDID']))
{
    include 'db.php';
    $db = new DB();

    $userData = $db->getInfo($_COOKIE['auth_login']);
    if ($userData['hash'] !== $_COOKIE['auth_UDID'])
    {
        //убиваем старые куки
        setcookie("auth_login", "", time() - 3600*24*30*12, "/");
        setcookie("auth_UDID", "", time() - 3600*24*30*12, "/");
    }
}

function p($x){print "<div>$x</div>";}
function text($field)
{
    if (isset($field))
    {
        return $field;
    }
    return '';
}
?>
<div id="contentwrapper">
    <h1>About Information User</h1><br>
    <hr>
    <?php
    if (strlen($userData['user_path']) > 0) {
        echo "<img src='". $userData['user_path'] ."' alt=\"Logo\" width=\"100\" height=\"150\" />";
    }
    ?>
    <label>Full name:</label>
    <input type="text" value="<?php echo text($userData['user_fio']); ?>" readonly />
    <label>Date birthday:</label>
    <input type="text" value="<?php echo text($userData['user_date']); ?>" readonly />
    <label>City:</label>
    <input type="text" value="<?php echo text($userData['user_city']); ?>" readonly />
    <label>Family status:</label>
    <input type="text" value="<?php echo $userData['user_family_status'] ? 'Married' : 'Single'; ?>" readonly />
    <label>Education:</label>
    <input type="text" value="<?php echo text($userData['user_education']); ?>" readonly/> <br>
    <label>Experience:</label>
    <input type="text" value="<?php echo text($userData['user_experience']); ?>" readonly/> <br>
    <label>Email:</label>
    <input type="text" value="<?php echo text($userData['user_email']); ?>" readonly/> <br>
    <label>Mobile phone:</label>
    <input type="text" value="<?php echo text($userData['user_phone']); ?>" readonly/> <br>
    <label>Additional information:</label>
    <textarea placeholder="<?php echo text($userData['user_about']); ?>" readonly></textarea>


    <div class="login">
        <a href="index.html">Home</a>
    </div>
</div>
</body>
</html>

