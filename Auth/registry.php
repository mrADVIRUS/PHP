<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/stylemain.css">
    <title>Registry new customer</title>
    <script src="JS/checkLogin.js" type="application/javascript"></script>
</head>
<body>
    <div id="contentwrapper">
        <h2>Registry new Customer</h2><br>
        <hr>
        <?php
        //init variables
        session_start();
        $data = array();
        $sessionReturn = false;
        if(isset($_SESSION['returndata'])){
            $data = $_SESSION['returndata'];
            $sessionReturn = true;
        }
        ?>
<!--        if exist erorrs - need to show it-->
        <ul id="errors" class="<?php echo ($sessionReturn && !$data['form_ok']) ? 'visible' : ''; ?>">
            <li id="info">There were some problems with your form submission:</li>
            <?php
            if(isset($data['errors']) && count($data['errors']) > 0) {
                foreach($data['errors'] as $error) {
                    echo '<li>'.$error.'</li>';
                }
            }
            ?>
        </ul>
        <p id="success" class="<?php echo ($sessionReturn && $data['form_ok']) ? 'visible' : ''; ?>"><?php $indexPage = "<a href=\"index.html\">Home page</a>"; echo 'Registry successful! Go to '.$indexPage.' for enter new Login!'; ?></p>
        <form action="handlerRegistry.php" method="post" enctype="multipart/form-data">
<!--            required-->
            <label for="login">Your Login <span class="required">*</span><span id="checkLogin"></span></label>
            <input type="text" id="loginValue" onblur="checkLoginInDB(this.value)" name="login" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['login'] : ''; ?>" placeholder="Your Login" required autofocus>
            <label for="password">Password <span class="required">*</span></label>
            <input type="password" name="password" placeholder="***" required>
            <label for="email">Email <span class="required">*</span></label>
            <input type="text" name="email" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['email'] : ''; ?>" placeholder="yourEmail@example.com" required>

            <label for="fullName">Full name <span class="required">*</span></label>
            <input type="text" name="fullName" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['fio'] : ''; ?>" placeholder="Mr Smith" required>

<!--            optional-->
            <label for="date">Date Birthday</label>
            <input type="text" name="date" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['date'] : ''; ?>" placeholder="YYYY/MM/DD">

            <label for="city">City</label>
            <input type="text" name="city" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['city'] : ''; ?>" placeholder="-- City --">

            <label for="phone">Phone number</label>
            <input type="text" name="phone" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['phone'] : ''; ?>" placeholder="80xxx">

            <label for="familyStatus">Family status</label>
            <select name="familyStatus">
                <option value="0" <?php echo ($sessionReturn && !$data['form_ok'] && $data['posted_form_data']['status'] == 0) ? "selected='selected'" : '' ?>>Single</option>
                <option value="1" <?php echo ($sessionReturn && !$data['form_ok'] && $data['posted_form_data']['status'] == 1) ? "selected='selected'" : '' ?>>Married</option>
            </select>

            <label for="education">Education</label>
            <input type="text" name="education" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['education'] : ''; ?>">

            <label for="experience">Experience</label>
            <input type="text" name="experience" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['experience'] : ''; ?>">

            <label for="info">Additional information</label>
            <textarea name="info" value="<?php echo ($sessionReturn && !$data['form_ok']) ? $data['posted_form_data']['info'] : ''; ?>" rows="5" cols="40"></textarea>

            <label for="file">Filename:</label>
            <input type="file" name="userfile" id="file"><br>

            <input type="submit" class="login login-submit" value="Registry">

            <p id="req-field-desc"><span class="required">*</span> indicates a required field</p>
        </form>
        <?php unset($_SESSION['returndata']); ?>
    </div>

</body>
</html>
