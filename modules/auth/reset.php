<?php
layouts('header-login');
$token = filter()['token'];

if (!empty($token)) {
    $tokenQuery = getOneRaw("SELECT id, fullname, email FROM student WHERE forgotToken = '$token'");
    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        if (isPost()) {
            $filterAll = filter();
            $errors = []; //arr contain error

            // Validates password field: required and matches password.
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


            if (empty($errors)) {
                $passwordHash = password_hash($filterAll['password'], PASSWORD_DEFAULT);
                $dataUpdate = [
                    'password' => $passwordHash,
                    'forgotToken' => null,
                    'update_at' => date('Y-m-d H:i:s')
                ];

                $updateStatus = update('student', $dataUpdate, "id = '$userId'");
                if ($updateStatus) {
                    setFlashData('msg', "Change password success!");
                    setFlashData('msg_type', "success");
                    redirect('?module=auth&action=login');
                } else {
                    setFlashData('msg', "System error, please try again later!");
                    setFlashData('msg_type', "danger");
                }
            } else {
                setFlashData('msg', "Please check insert data again!");
                setFlashData('msg_type', "danger");
                setFlashData('errors', $errors);
                redirect('?module=auth&action=reset&token=' . $token);
            }
        }


        $msg = getFlashData('msg');
        $msg_type = getFlashData('msg_type');
        $errors = getFlashData('errors');
?>


        <div class="row">
            <div class="col-4" style="margin: 50px auto;">
                <form action="" method="post">
                    <h2 class="text-center text-uppercase">Reset Password</h2>

                    <div class="form-group mg-form">
                        <label for="">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <?php
                        echo form_error('password', '<span class="error">', '</span>', $errors);
                        ?>
                    </div>

                    <div class="form-group mg-form">
                        <label for="">Re-type Password:</label>
                        <input type="password" class="form-control" name="password-confirm" placeholder="Re-type password">
                        <?php
                        echo form_error('password-confirm', '<span class="error">', '</span>', $errors);
                        ?>
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <button type="submit" class=" mg-btn btn btn-primary btn-block">Submit</button>
                        <hr>
                        <p class="text-center"><a href="?module=auth&action=login">Remembered your password?</a></p>
                </form>
            </div>
        </div>

<?php
    } else {
        getMsg('Link failed or expired', 'danger');
    }
} else {
    getMsg('Link failed or expired', 'danger');
}

?>

<?php
layouts('footer-login');
?>