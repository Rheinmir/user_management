<?php
$data = [
    'fullname' => 'Karen',
    'email' => 'karen@dtb.edu',
    'phone' => '12376681',
];


// Conditional code execution based on HTTP method: if the request is a POST, it applies a filter and initializes an empty error array.
if (isPost()) {
    $filterAll = filter();
    $errors = []; //array fix error

    // Validates that the name field is not empty and has a minimum length of 5 characters.
    if (empty($filterAll['name'])) {
        $errors['name']['required'] = "Your name can not be null";
    } else {
        if (strlen($filterAll['name']) < 5) {
            $errors['name']['min'] = "Your name need to have at least 5 characters";
        }
    }

    // Validates if an email is empty and if it already exists.
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = "Email can not be null";
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM student WHERE email = '$email' ";
        if (getRow($sql) > 0) {
            $errors['email']['unique'] = "Email is exist";
        }
    }

    // Validates a phone number, ensuring it's not empty and has a valid format.
    if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = "Phone number can not be null";
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = "Phone number not valid, must start with 0 and followed with 9 numbers ";
        }
    }

    // Check if password is empty or less than 8 characters long, and add appropriate error messages if necessary.
    if (empty($filterAll['password'])) {
        $errors['password']['required'] = "Password can not be null";
    } else {
        if (strlen($filterAll['password']) < 8) {
            $errors['password']['min'] = "Your password need to have at least 8 characters";
        }
    }
    // Validates password-confirm field: required and matches password.
    if (empty($filterAll['password-confirm'])) {
        $errors['password-confirm']['required'] = "Password can not be null";
    } else {
        if (($filterAll['password-confirm']) != ($filterAll['password'])) {
            $errors['password-confirm']['match'] = " Re-type password is not correct";
        }
    }



    // Sets flash message and type based on whether errors exist.
    if (empty($errors)) {
        $activeToken = sha1(uniqid() . time());
        $dataInsert = [
            'fullname' => $filterAll['name'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date('Y-m-d H:i:s')
        ];

        
        $insertStatus = insert('student', $dataInsert);
        if ($insertStatus) {

            //Create activating link
            $linkActive = _WEB_HOST . '?module=auth&action=activate&token=' . $activeToken;

            //Mail to user
            $subject = $filterAll['name'] . ', here is your verifying link';
            // $content = 'Dear'.$fillterAll['name']. "\n\n\n\n";
            // $content .= "Here is your verifying link, please click the link below to activate your account: .\n\n\n\n";
            // $content .= $linkActive."\n\n\n\n";
            // $content .= "Best regards.";

            $content = nl2br('Dear, ' . $filterAll['name'] . "\n\n\n\n");
            $content .= nl2br("Here is your verifying link. Please click the link below to activate your account:\n");
            $content .= nl2br($linkActive . "\n\n\n\n");
            $content .= "Best regards.";


            //Mail sent executed
            $sendMail = sendMail($filterAll['email'], $subject, $content);
            if ($sendMail) {
                setFlashData('msg', "Registration success!, check your mail to activate account");
                setFlashData('msg_type', "success");
            } else {
                setFlashData('msg', "System error! please try again later");
                setFlashData('msg_type', "danger");
            }
        } else {
            setFlashData('msg', "Registration failed! please try again later");
            setFlashData('msg_type', "danger");
        }

        redirect('?module=auth&action=register');
    } else {
        setFlashData('msg', "Please check insert data again!");
        setFlashData('msg_type', "danger");
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
        redirect('?module=auth&action=register');
    }
}

layouts('header', $data);

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

echo '<pre>';
print_r($old);
echo '</pre>';

?>
<div class="row">
    <div class="col-" style="margin: 50px auto;">
        <form action="" method="post">
            <h2 class="text-center text-uppercase">Register</h2>
            <?php
            if (!empty($msg)) {
                getmsg($msg, $msg_type);
            }
            ?>
            <div class="form-group mg-form">
                <label for="">Your Name:</label>
                <input type="name" class="form-control" name="name" placeholder="Your Name" value="<?php
                                                                                                    echo old('name', $old); ?>">

                <?php
                // Display errors for the 'name' field.
                echo form_error('name', '<span class="error">', '</span>', $errors);
                ?>

            </div>
            <div class="form-group mg-form">
                <label for="">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Email" value="<?php
                                                                                                    echo old('email', $old); ?>">
                <?php
                echo form_error('email', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group mg-form">
                <label for="">Phone Number:</label>
                <input type="phone" class="form-control" name="phone" placeholder="Phone number" value="<?php
                                                                                                        echo old('phone', $old); ?>">
                <?php
                echo form_error('phone', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group mg-form">
                <label for="">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Password" value="<?php
                                                                                                            echo old('password', $old); ?>">
                <?php
                echo form_error('password', '<span class="error">', '</span>', $errors);
                ?>

            </div>
            <div class="form-group mg-form">
                <label for="">Re-type Password:</label>
                <input type="password" class="form-control" name="password-confirm" placeholder="Re-type password" value="<?php
                                                                                                                            echo old('password-confirm', $old); ?>">
                <?php
                echo form_error('password-confirm', '<span class="error">', '</span>', $errors);
                ?>
                <button type="submit" class=" mg-btn btn btn-primary btn-block">Register</button>
                <hr>
            </div>
            <div>
                <p class="text-center"><a href="?module=auth&action=login">Already have an account?</a></p>
                <p class="text-center"><a href="?module=auth&action=forgot">Forgot the password?</a></p>
            </div>
    </div>
    </form>
</div>
</div>

<?php
layouts('footer');
?>